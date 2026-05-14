<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MilestoneController extends Controller
{
    public function toggle(Request $request, Milestone $milestone)
    {
        $booking = $milestone->booking;
        $userId = $request->user()->id;

        abort_unless(
            $userId === $booking->mentor_id || $userId === $booking->student_id,
            403
        );

        if (! in_array($booking->status, ['confirmed', 'completed'], true)) {
            return back()->withErrors([
                'milestone' => 'Milestones can only be updated after the booking is confirmed.',
            ]);
        }

        DB::transaction(function () use ($milestone, $booking) {
            $milestone->update([
                'is_completed' => ! $milestone->is_completed,
                'completed_at' => $milestone->is_completed ? null : now(),
            ]);

            $this->syncBookingStatus($booking->fresh());
        });

        return back()->with('success', 'Milestone updated.');
    }

    protected function syncBookingStatus(Booking $booking): void
    {
        $hasOpenMilestones = $booking->milestones()
            ->where('is_completed', false)
            ->exists();

        $booking->update([
            'status' => $hasOpenMilestones ? 'confirmed' : 'completed',
        ]);
    }
}
