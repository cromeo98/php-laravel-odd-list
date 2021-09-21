<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 11; $i++){

            $newPost = new Post;

            $newPost->title = 'Post numero ' . $i;
            $newPost->slug = Str::slug($newPost->title, '-');
            $newPost->content = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Est facere aperiam nemo similique repudiandae obcaecati cupiditate dolores, mollitia vero iusto rem omnis aut consequuntur magni voluptas iure ducimus asperiores porro architecto quos neque velit. Ullam deserunt repellat unde rem sapiente enim tempora nostrum eligendi, reiciendis ea quas dicta voluptatum. Voluptatem?';

            $newPost->save();
        }
    }
}
