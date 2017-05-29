<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticlesRequest;
use App\Http\Requests\UpdateArticlesRequest;
use App\Repositories\ArticlesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ArticlesController extends AppBaseController
{
    /** @var  ArticlesRepository */
    private $articlesRepository;

    public function __construct(ArticlesRepository $articlesRepo)
    {
        $this->articlesRepository = $articlesRepo;
    }

    /**
     * Display a listing of the Articles.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->articlesRepository->pushCriteria(new RequestCriteria($request));
        $articles = $this->articlesRepository->all();

        return view('articles.index')
            ->with('articles', $articles);
    }

    /**
     * Show the form for creating a new Articles.
     *
     * @return Response
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created Articles in storage.
     *
     * @param CreateArticlesRequest $request
     *
     * @return Response
     */
    public function store(CreateArticlesRequest $request)
    {
        $input = $request->all();

        $articles = $this->articlesRepository->create($input);

        Flash::success('Articles saved successfully.');

        return redirect(route('articles.index'));
    }

    /**
     * Display the specified Articles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            Flash::error('Articles not found');

            return redirect(route('articles.index'));
        }

        return view('articles.show')->with('articles', $articles);
    }

    /**
     * Show the form for editing the specified Articles.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            Flash::error('Articles not found');

            return redirect(route('articles.index'));
        }

        return view('articles.edit')->with('articles', $articles);
    }

    /**
     * Update the specified Articles in storage.
     *
     * @param  int              $id
     * @param UpdateArticlesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateArticlesRequest $request)
    {
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            Flash::error('Articles not found');

            return redirect(route('articles.index'));
        }

        $articles = $this->articlesRepository->update($request->all(), $id);

        Flash::success('Articles updated successfully.');

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified Articles from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $articles = $this->articlesRepository->findWithoutFail($id);

        if (empty($articles)) {
            Flash::error('Articles not found');

            return redirect(route('articles.index'));
        }

        $this->articlesRepository->delete($id);

        Flash::success('Articles deleted successfully.');

        return redirect(route('articles.index'));
    }
}
