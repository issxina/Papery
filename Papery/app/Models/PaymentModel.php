<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderModel; 

class PaymentModel extends Model
{
    protected $table = 'tbl_payments';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['order_id', 'pay_method', 'pay_amount','pay_proof_path','pay_paid_at'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'id');
    }
}
