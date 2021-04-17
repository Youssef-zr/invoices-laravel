<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Section;

class Product extends Model
{
    protected $guarded = [];
    protected $table = 'products';

    /**
     * Get the user associated with the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function section()
    {
        return $this->hasOne(Section::class,'id','section_id');
    }
}
