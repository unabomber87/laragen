<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticlesApiTest extends TestCase
{
    use MakeArticlesTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreateArticles()
    {
        $articles = $this->fakeArticlesData();
        $this->json('POST', '/api/v1/articles', $articles);

        $this->assertApiResponse($articles);
    }

    /**
     * @test
     */
    public function testReadArticles()
    {
        $articles = $this->makeArticles();
        $this->json('GET', '/api/v1/articles/'.$articles->id);

        $this->assertApiResponse($articles->toArray());
    }

    /**
     * @test
     */
    public function testUpdateArticles()
    {
        $articles = $this->makeArticles();
        $editedArticles = $this->fakeArticlesData();

        $this->json('PUT', '/api/v1/articles/'.$articles->id, $editedArticles);

        $this->assertApiResponse($editedArticles);
    }

    /**
     * @test
     */
    public function testDeleteArticles()
    {
        $articles = $this->makeArticles();
        $this->json('DELETE', '/api/v1/articles/'.$articles->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/articles/'.$articles->id);

        $this->assertResponseStatus(404);
    }
}
