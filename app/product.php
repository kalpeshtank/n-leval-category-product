<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class product extends Model {

    protected $table = 'products';
    protected $appends = ['image_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'image', 'descriptions', 'price'
    ];

    public function category_data() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getImageUrlAttribute() {
        return asset('storage/' . $this->image);
    }

}
