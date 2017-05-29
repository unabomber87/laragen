<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateArticlesAPIRequest;
use App\Http\Requests\API\UpdateArticlesAPIRequest;
use App\Models\Articles;
use App\Repositories\ArticlesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ArticlesController
 * @package App\Http\Controllers\API
 */

class ArticlesAPIController extends AppBaseController
{
    /** @var  ArticlesRepository */
    private $articlesRepository;

    public function __construct(ArticlesRepository $articlesRepo)
    {
        $this->articlesRepository = $articlesRepo;
    }

    /**
     * Display a listing of the Articles.
     * GET|HEAD /articles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->articlesRepository->pushCriteria(new RequestCriteria($request));
        $this->articlesRepository->pushCriteria(new LimitOffsetCriteria($request));
        $articles = $this->articlesRepository->all();

        return $this->sendResponse($articles->toArray(), 'Articles retrieved successfully');
    }

    /**
     * Store a newly created Articles in storage.
     * POST /articles
     *
     * @param CreateArticlesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateArticlesAPIRequest $request)
    {
        $input = $request->all();

        $articles = $this->articlesRepository->create($input);

        return $this->sendResponse($articles->toArray(), 'Articles saved successfully');
    }

    /**
     * Display the specified Articles.
     * GET|HEAD /articles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Articles $articles */
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            return $this->sendError('Articles not found');
        }

        return $this->sendResponse($articles->toArray(), 'Articles retrieved successfully');
    }

    /**
     * Update the specified Articles in storage.
     * PUT/PATCH /articles/{id}
     *
     * @param  int $id
     * @param UpdateArticlesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticlesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Articles $articles */
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            return $this->sendError('Articles not found');
        }

        $articles = $this->articlesRepository->update($input, $id);

        return $this->sendResponse($articles->toArray(), 'Articles updated successfully');
    }

    /**
     * Remove the specified Articles from storage.
     * DELETE /articles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Articles $articles */
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            return $this->sendError('Articles not found');
        }

        $articles->delete();

        return $this->sendResponse($id, 'Articles deleted successfully');
    }
}
