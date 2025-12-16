<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create specific Test User
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->createProfile($user, 'Software Engineer', 'Dhaka, Bangladesh');

        // 2. Create 20 random users
        User::factory(20)->create()->each(function ($u) {
            $this->createProfile($u);
        });
    }

    private function createProfile($user, $headline = null, $location = null)
    {
        $headlines = [
            'Software Engineer at Tech',
            'Product Manager',
            'HR Specialist',
            'Marketing Guru',
            'Student at BUET',
            'Data Scientist',
            'Frontend Developer',
            'CEO at Startup',
        ];

        $locations = ['Dhaka, Bangladesh', 'Chittagong, Bangladesh', 'Sylhet', 'Remote'];

        if (!$user->profile) {
            UserProfile::create([
                'user_id' => $user->id,
                'headline' => $headline ?? $headlines[array_rand($headlines)],
                'about' => 'Passionate professional with experience in the industry. Looking to connect with like-minded individuals.',
                'location' => $location ?? $locations[array_rand($locations)],
                'website' => 'https://example.com',
                'skills' => 'PHP, Laravel, JavaScript',
            ]);
        }
    }
}
