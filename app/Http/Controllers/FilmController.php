<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Film;
use Illuminate\Http\Request;
use App\Http\Requests\FilmRequest;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\BaseController;

class FilmController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('currentPage') && $request->input('currentPage') != '') {
            $currentPage = $request->input('currentPage');

            Paginator::currentPageResolver(function () use ($currentPage) {
                return $currentPage;
            });
        }
        
        $films = Film::search($request)->latest()->paginate($request->input('perPage', '10'));

        if($films == null) {
            return $this->sendError('Film selected doesn\'t exist');
        }

        return $this->sendResponse($films, 'Film list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $film = Film::with('filmcategories')->find($id);

        if($film == null) {
            return $this->sendError('Film selected doesn\'t exist');
        }

        return $this->sendResponse($film, 'Film selected');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\FilmRequest  $request
     *
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(FilmRequest $request)
    {
        $film = Film::create($request->all());

        if($request->has('film_category_id') && $request->input('film_category_id') != '') {
            if(is_array($request->input('film_category_id'))) {
                foreach ($request->input('film_category_id') as $key => $category_id) {
                    $filmCategory = FilmCategory::find($category_id);

                    $film->associate($filmCategory);
                    $film->save();
                }
            } else  {
                $filmCategory = FilmCategory::find($request->input('film_category_id'));

                $film->associate($filmCategory);
                $film->save();
            }
        }

        return $this->sendCreated($film, 'Film Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\FilmRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(FilmRequest $request, $id)
    {
        $film = Film::find($id);

        if($film == null) {
            return $this->sendError('Film selected doesn\'t exist');
        }

        $film->update($request->all());

        if($request->has('film_category_id') && $request->input('film_category_id') != '') {
            if(is_array($request->input('film_category_id'))) {
                foreach ($request->input('film_category_id') as $key => $category_id) {
                    $filmCategory = FilmCategory::find($category_id);

                    $film->associate($filmCategory);
                    $film->save();
                }
            } else  {
                $filmCategory = FilmCategory::find($request->input('film_category_id'));

                $film->associate($filmCategory);
                $film->save();
            }
        }

        return $this->sendResponse($film, 'Film Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);

        if($film == null) {
            return $this->sendError('Film selected doesn\'t exist');
        }

        $film->delete();

        return $this->sendResponse([$film], 'Film has been Deleted');
    }
}
