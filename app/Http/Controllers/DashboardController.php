<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Get the logged-in user
        $user = auth()->user();

        // Load bookings where the user is the teacher (mentor)
        $teaching = $user->mentorBookings()
            ->with(['skill', 'student', 'milestones' => fn ($query) => $query->oldest()])
            ->latest()
            ->get();

        // Load bookings where the user is the learner (student)
        $learning = $user->studentBookings()
            ->with(['skill', 'mentor', 'milestones' => fn ($query) => $query->oldest()])
            ->latest()
            ->get();

        return Inertia::render('Dashboard', [
            'teaching' => $teaching,
            'learning' => $learning,
        ]);
    }
}
