<?php

use Faker\Factory as Faker;
use App\Models\Posts;
use App\Repositories\PostsRepository;

trait MakePostsTrait
{
    /**
     * Create fake instance of Posts and save it in database
     *
     * @param array $postsFields
     * @return Posts
     */
    public function makePosts($postsFields = [])
    {
        /** @var PostsRepository $postsRepo */
        $postsRepo = App::make(PostsRepository::class);
        $theme = $this->fakePostsData($postsFields);
        return $postsRepo->create($theme);
    }

    /**
     * Get fake instance of Posts
     *
     * @param array $postsFields
     * @return Posts
     */
    public function fakePosts($postsFields = [])
    {
        return new Posts($this->fakePostsData($postsFields));
    }

    /**
     * Get fake data of Posts
     *
     * @param array $postFields
     * @return array
     */
    public function fakePostsData($postsFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'content' => $fake->text,
            'user_id' => $fake->randomDigitNotNull,
            'image' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $postsFields);
    }
}
