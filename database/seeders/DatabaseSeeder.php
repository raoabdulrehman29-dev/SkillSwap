<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Swap;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'trust_score' => 85,
            ],
            [
                'name' => 'Ayesha Khan',
                'email' => 'ayesha@example.com',
                'trust_score' => 92,
            ],
            [
                'name' => 'Bilal Ahmed',
                'email' => 'bilal@example.com',
                'trust_score' => 78,
            ],
            [
                'name' => 'Sara Malik',
                'email' => 'sara@example.com',
                'trust_score' => 73,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'trust_score' => $user['trust_score'],
                ],
            );
        }

        $testUser = User::where('email', 'test@example.com')->first();
        $ayesha = User::where('email', 'ayesha@example.com')->first();
        $bilal = User::where('email', 'bilal@example.com')->first();
        $sara = User::where('email', 'sara@example.com')->first();

        $skills = collect([
            [
                'user_id' => $testUser->id,
                'title' => 'Laravel App Debugging',
                'description' => 'I can help fix controllers, routes, migrations, and Inertia pages in Laravel projects.',
                'category' => 'Web Development',
                'type' => 'offering',
            ],
            [
                'user_id' => $testUser->id,
                'title' => 'UI Design Feedback',
                'description' => 'Looking for someone to review dashboard screens and suggest cleaner layouts.',
                'category' => 'Graphic Design',
                'type' => 'seeking',
            ],
            [
                'user_id' => $ayesha->id,
                'title' => 'Vue Components',
                'description' => 'I teach reusable Vue components, props, layouts, and Inertia page structure.',
                'category' => 'Web Development',
                'type' => 'offering',
            ],
            [
                'user_id' => $bilal->id,
                'title' => 'Logo Design',
                'description' => 'I can design simple brand logos and social media assets for small projects.',
                'category' => 'Graphic Design',
                'type' => 'offering',
            ],
            [
                'user_id' => $sara->id,
                'title' => 'Digital Marketing Basics',
                'description' => 'I want to learn SEO, content planning, and basic campaign reporting.',
                'category' => 'Marketing',
                'type' => 'seeking',
            ],
        ])->map(function (array $skill) {
            return Skill::updateOrCreate(
                [
                    'user_id' => $skill['user_id'],
                    'title' => $skill['title'],
                ],
                $skill,
            );
        });

        Swap::updateOrCreate(
            [
                'sender_id' => $testUser->id,
                'receiver_id' => $ayesha->id,
                'sender_skill_id' => $skills[1]->id,
                'receiver_skill_id' => $skills[2]->id,
            ],
            ['status' => 'pending'],
        );
    }
}
