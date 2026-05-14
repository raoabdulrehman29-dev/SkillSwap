<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_id' => ['required', 'exists:skills,id'],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'milestones' => ['required', 'array', 'min:1'],
            'milestones.*.title' => ['required', 'string', 'max:255'],
            'milestones.*.description' => ['nullable', 'string', 'max:1000'],
        ]);

        $skill = Skill::query()->findOrFail($validated['skill_id']);

        if ($skill->user_id === $request->user()->id) {
            return back()->withErrors([
                'skill_id' => 'You cannot book your own skill.',
            ]);
        }

        [$mentorId, $studentId] = $skill->type === 'offering'
            ? [$skill->user_id, $request->user()->id]
            : [$request->user()->id, $skill->user_id];

        $isBusy = Booking::query()
            ->where('mentor_id', $mentorId)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('start_time', '<', $validated['end_time'])
            ->where('end_time', '>', $validated['start_time'])
            ->exists();

        if ($isBusy) {
            return back()->withErrors([
                'start_time' => 'The mentor is already booked during this time.',
            ]);
        }

        DB::transaction(function () use ($validated, $mentorId, $studentId, $skill) {
            $booking = Booking::query()->create([
                'mentor_id' => $mentorId,
                'student_id' => $studentId,
                'skill_id' => $skill->id,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'status' => 'pending',
            ]);

            foreach ($validated['milestones'] as $milestone) {
                $booking->milestones()->create([
                    'title' => $milestone['title'],
                    'description' => $milestone['description'] ?? null,
                ]);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Booking request sent.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:confirmed,cancelled'],
        ]);

        $userId = $request->user()->id;
        $isMentor = $userId === $booking->mentor_id;
        $isParticipant = $isMentor || $userId === $booking->student_id;

        abort_unless($isParticipant, 403);

        if ($validated['status'] === 'confirmed') {
            abort_unless($isMentor, 403, 'Only the mentor can confirm a booking.');
        }

        if ($booking->status === 'completed') {
            return back()->withErrors([
                'status' => 'Completed bookings cannot be changed.',
            ]);
        }

        $booking->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Booking status updated.');
    }
}
