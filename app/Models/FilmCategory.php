<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filmcategories';

    protected $fillable = [
        'name', 'description'
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'filmcategory_film');
    }
}
