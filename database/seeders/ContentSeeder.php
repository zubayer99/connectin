<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Connection;
use App\Models\Job;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            return;
        }

        // 1. Create Connections
        foreach ($users as $user) {
            // Connect with 3-5 random users
            $targets = $users->random(rand(3, 8));
            foreach ($targets as $target) {
                if ($user->id !== $target->id && !$user->isConnectedWith($target) && !$user->hasPendingRequestFrom($target) && !$user->hasSentRequestTo($target)) {
                    Connection::create([
                        'sender_id' => $user->id,
                        'receiver_id' => $target->id,
                        'status' => 'accepted',
                    ]);
                }
            }
        }

        // 2. Create Posts
        foreach ($users as $user) {
            Post::factory(rand(1, 3))->create([
                'user_id' => $user->id,
            ]);
        }

        // 3. Create Interactions (Likes & Comments)
        $posts = Post::all();
        foreach ($posts as $post) {
            // Random likes
            $likers = $users->random(rand(0, 5));
            foreach ($likers as $liker) {
                if ($liker->id !== $post->user_id) { // Avoid self-like for variety (though allowed)
                    Like::firstOrCreate([
                        'user_id' => $liker->id,
                        'post_id' => $post->id,
                    ]);
                }
            }

            // Random comments
            $commenters = $users->random(rand(0, 3));
            foreach ($commenters as $commenter) {
                 Comment::create([
                    'user_id' => $commenter->id,
                    'post_id' => $post->id,
                    'content' => $this->getRandomComment(),
                ]);
            }
        }

        // 4. Create Jobs
        $jobTitles = ['Software Engineer', 'Product Manager', 'Designer', 'Data Analyst', 'Marketing Specialist', 'Sales Manager'];
        $companies = ['TechBd', 'Pathao', 'Bkash', 'Grameenphone', 'Robi', 'ShopUp'];
        
        foreach (range(1, 15) as $i) {
            Job::create([
                'user_id' => $users->random()->id,
                'title' => $jobTitles[array_rand($jobTitles)],
                'company' => $companies[array_rand($companies)],
                'location' => 'Dhaka, Bangladesh',
                'type' => 'Full-time',
                'description' => "We are looking for a talented individual to join our team. \n\nResponsibilities:\n- Develop high quality software.\n- Collaborate with cross-functional teams.\n\nRequirements:\n- 3+ years of experience.\n- Strong problem solving skills.",
            ]);
        }
    }

    private function getRandomComment()
    {
        $comments = [
            'Great post!',
            'Thanks for sharing.',
            'Insightful.',
            'Congratulations!',
            'Interesting perspective.',
            'Well said.',
            'Agree 100%.',
        ];
        return $comments[array_rand($comments)];
    }
}
