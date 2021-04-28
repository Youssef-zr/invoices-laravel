<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Section extends Model
{
    protected $guarded = [];
    protected $table = 'sections';

    /**
     * Get all of the comments for the Section
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class,'section_id','id');
    }
}
