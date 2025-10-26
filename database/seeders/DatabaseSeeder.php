<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Role;
use App\Models\Topic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin = Role::create([
            'name' => 'admin',
        ]);

        $this->call(TopicSeeder::class);
        $topics = Topic::all();

        $users = User::factory(10)->create();

        $posts = Post::factory(20)
            ->has(Comment::factory(15)->recycle($users))
            ->recycle([$users, $topics])
            ->create();

        User::factory()
            ->has(Post::factory(5))->recycle($topics)
            ->has(Comment::factory(12)->recycle($posts))
            ->has(Like::factory(50)->forEachSequence(
                ...$posts->random(10)->map(fn (Post $post) => ['likeable_id' => $post]),
            ))
            ->create([
                'name' => 'Ibra',
                'email' => 'Ibra@example.com',
                'password' => '12345678',
                'is_admin' => true,
            ])->roles()->attach($admin);

        User::factory()->create([
            'name' => 'James Harry',
            'email' => 'user@example.com',
            'password' => '12345678',
            'is_admin' => false,
        ]);
    }
}
