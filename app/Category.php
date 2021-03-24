<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'perent_id', 'status'
    ];

    public function parentCategory() {
        return $this->belongsTo(Category::class, 'perent_id', 'id');
    }

    public function childs() {
        return $this->hasMany(Category::class, 'perent_id', 'id');
    }

}
