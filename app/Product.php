<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  // protected $fillable = ['product_name', 'description', 'section_id'];

  protected $guarded = [];

  public function section()
  {
    return $this->belongsTo('App\Section', 'section_id');
  }

}
