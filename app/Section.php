<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
  protected $fillable = ['section_name', 'description', 'created_by'];

  public function products()
  {
    return $this->hasMany('App\Product', 'section_id');
  }

  public function Invoices()
  {
    return $this->hasMany('App\Invoice', 'section_id');
  }

}
