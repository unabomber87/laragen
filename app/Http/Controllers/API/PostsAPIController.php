<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePostsAPIRequest;
use App\Http\Requests\API\UpdatePostsAPIRequest;
use App\Models\Posts;
use App\Repositories\PostsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class PostsController
 * @package App\Http\Controllers\API
 */

class PostsAPIController extends AppBaseController
{
    /** @var  PostsRepository */
    private $postsRepository;

    public function __construct(PostsRepository $postsRepo)
    {
        $this->postsRepository = $postsRepo;
    }

    /**
     * Display a listing of the Posts.
     * GET|HEAD /posts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->postsRepository->pushCriteria(new RequestCriteria($request));
        $this->postsRepository->pushCriteria(new LimitOffsetCriteria($request));
        $posts = $this->postsRepository->all();

        return $this->sendResponse($posts->toArray(), 'Posts retrieved successfully');
    }

    /**
     * Store a newly created Posts in storage.
     * POST /posts
     *
     * @param CreatePostsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePostsAPIRequest $request)
    {
        $input = $request->all();

        $posts = $this->postsRepository->create($input);

        return $this->sendResponse($posts->toArray(), 'Posts saved successfully');
    }

    /**
     * Display the specified Posts.
     * GET|HEAD /posts/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Posts $posts */
        $posts = $this->postsRepository->findWithoutFail($id);

        if (empty($posts)) {
            return $this->sendError('Posts not found');
        }

        return $this->sendResponse($posts->toArray(), 'Posts retrieved successfully');
    }

    /**
     * Update the specified Posts in storage.
     * PUT/PATCH /posts/{id}
     *
     * @param  int $id
     * @param UpdatePostsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Posts $posts */
        $posts = $this->postsRepository->findWithoutFail($id);

        if (empty($posts)) {
            return $this->sendError('Posts not found');
        }

        $posts = $this->postsRepository->update($input, $id);

        return $this->sendResponse($posts->toArray(), 'Posts updated successfully');
    }

    /**
     * Remove the specified Posts from storage.
     * DELETE /posts/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Posts $posts */
        $posts = $this->postsRepository->findWithoutFail($id);

        if (empty($posts)) {
            return $this->sendError('Posts not found');
        }

        $posts->delete();

        return $this->sendResponse($id, 'Posts deleted successfully');
    }
}
