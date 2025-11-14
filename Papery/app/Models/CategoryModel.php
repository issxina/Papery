<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'tbl_categories';
    protected $primaryKey = 'id';
    protected $fillable = ['category_name', 'category_slug'];
    public $incrementing = true;
    public $timestamps = false;
}