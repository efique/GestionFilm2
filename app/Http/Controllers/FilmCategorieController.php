<?php

namespace App\Http\Controllers;

use App\Models\FilmCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class FilmCategorieController extends BaseController
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
        
        $filmsCategories = FilmCategory::latest()->paginate($request->input('perPage', '10'));

        if($filmsCategories == null) {
            return $this->sendError('Film Category selected doesn\'t exist');
        }

        return $this->sendResponse($filmsCategories, 'Film Category list');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $filmCategory = FilmCategory::with('films')->find($id);

        if($filmCategory == null) {
            return $this->sendError('Film Category selected doesn\'t exist');
        }

        return $this->sendResponse($filmCategory, 'Film Category selected');
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $filmCategory = FilmCategory::create($request->all());

        return $this->sendCreated($filmCategory, 'Film Category Created Successfully');
    }

    /**
     * Update the resource in storage
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $filmCategory = FilmCategory::find($id);

        if($filmCategory == null) {
            return $this->sendError('Film Category selected doesn\'t exist');
        }

        $filmCategory->update($request->all());

        return $this->sendResponse($filmCategory, 'Film Category Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filmCategory = FilmCategory::find($id);

        if($filmCategory == null) {
            return $this->sendError('Film Category selected doesn\'t exist');
        }

        $filmCategory->delete();

        return $this->sendResponse([$filmCategory], 'Film Category has been Deleted');
    }
}
