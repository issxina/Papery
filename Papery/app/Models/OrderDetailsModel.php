<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BookModel;
use App\Models\OrderModel;

class OrderDetailsModel extends Model
{
    protected $table = 'tbl_order_details';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['order_id', 'book_id', 'orderdetails_qty', 'orderdetails_unit_price', 'orderdetails_total_price'];
    public $incrementing = true;
    public $timestamps = false;


    // เชื่อม OrderModel
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'id');
    }

    // เชื่อม BookModel
    public function book()
    {
        return $this->belongsTo(BookModel::class, 'book_id', 'id');
    }
}
