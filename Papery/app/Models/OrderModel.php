<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserModel; 
use App\Models\OrderDetailsModel;


class OrderModel extends Model
{
    protected $table = 'tbl_orders';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['user_id', 'order_status', 'order_subtotal', 'order_discount','order_amount', 'order_date','order_shipping_address'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    // เชื่อม UserModel
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    // เชื่อม OrderDetails
    public function details()
    {
        return $this->hasMany(OrderDetailsModel::class, 'order_id', 'id');
    }
}
