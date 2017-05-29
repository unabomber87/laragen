<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreatePostsRequest;
use App\Http\Requests\UpdatePostsRequest;
use App\Repositories\PostsRepository;
use App\User;
use Flash;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PostsController extends AppBaseController
{
    /** @var  PostsRepository */
    private $postsRepository;

    public function __construct(PostsRepository $postsRepo)
    {
        $this->postsRepository = $postsRepo;
    }

    /**
     * Display a listing of the Posts.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->postsRepository->pushCriteria(new RequestCriteria($request));
        $posts = $this->postsRepository->all();

        return view('posts.index')
            ->with('posts', $posts);
    }

    /**
     * Show the form for creating a new Posts.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('posts.create', ['users' => $users]);
    }

    /**
     * Store a newly created Posts in storage.
     *
     * @param CreatePostsRequest $request
     *
     * @return Response
     */
    public function store(CreatePostsRequest $request)
    {
        $input = $request->all();

        $posts = $this->postsRepository->create($input);

        Flash::success('Posts saved successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Display the specified Posts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $posts = $this->postsRepository->findWithoutFail($id);

        if (empty($posts)) {
            Flash::error('Posts not found');

            return redirect(route('posts.index'));
        }

        return view('posts.show')->with('posts', $posts);
    }

    /**
     * Show the form for editing the specified Posts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $posts = $this->postsRepository->findWithoutFail($id);
        $users = User::pluck('name', 'id');
        if (empty($posts)) {
            Flash::error('Posts not found');

            return redirect(route('posts.index'));
        }

        return view('posts.edit')->with(['posts' => $posts, 'users' => $users]);
    }

    /**
     * Update the specified Posts in storage.
     *
     * @param  int              $id
     * @param UpdatePostsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePostsRequest $request)
    {
        $posts = $this->postsRepository->findWithoutFail($id);

        if (empty($posts)) {
            Flash::error('Posts not found');

            return redirect(route('posts.index'));
        }

        $posts = $this->postsRepository->update($request->all(), $id);

        Flash::success('Posts updated successfully.');

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified Posts from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $posts = $this->postsRepository->findWithoutFail($id);

        if (empty($posts)) {
            Flash::error('Posts not found');

            return redirect(route('posts.index'));
        }

        $this->postsRepository->delete($id);

        Flash::success('Posts deleted successfully.');

        return redirect(route('posts.index'));
    }
}
