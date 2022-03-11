<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'films';

    protected $fillable = [
        'name', 'description', 'date', 'note'
    ];

    public function filmCategories()
    {
        return $this->belongsToMany(FilmCategory::class, 'filmcategory_film');
    }

    public function scopeSearch($query, $request)
    {
        $shouldApplySearch = false;

        if ($request->has('search') && $request->input('search') != '') {
            $shouldApplySearch = true;
        }

        $request_filter = $request->input('search');

        return $query->when($shouldApplySearch, function ($q) use ($request_filter) {
            $q->where('name', 'LIKE', "%$request_filter%")->orWhere('description', 'LIKE', "%$request_filter%");
        });
    }
}
