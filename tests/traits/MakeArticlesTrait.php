<?php

use Faker\Factory as Faker;
use App\Models\Articles;
use App\Repositories\ArticlesRepository;

trait MakeArticlesTrait
{
    /**
     * Create fake instance of Articles and save it in database
     *
     * @param array $articlesFields
     * @return Articles
     */
    public function makeArticles($articlesFields = [])
    {
        /** @var ArticlesRepository $articlesRepo */
        $articlesRepo = App::make(ArticlesRepository::class);
        $theme = $this->fakeArticlesData($articlesFields);
        return $articlesRepo->create($theme);
    }

    /**
     * Get fake instance of Articles
     *
     * @param array $articlesFields
     * @return Articles
     */
    public function fakeArticles($articlesFields = [])
    {
        return new Articles($this->fakeArticlesData($articlesFields));
    }

    /**
     * Get fake data of Articles
     *
     * @param array $postFields
     * @return array
     */
    public function fakeArticlesData($articlesFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'nom' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $articlesFields);
    }
}
