<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryModel; // นำเข้า CategoryModel

class BookModel extends Model
{
    protected $table = 'tbl_books';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['book_title', 'book_author', 'book_price', 'book_stock_qty','book_created', 'category_id','book_img'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    // เชื่อม CategoryModel(fk category_id)
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }
}
