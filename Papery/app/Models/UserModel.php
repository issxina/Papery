<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderModel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['user_name', 'user_email','user_password', 'user_address', 'user_phone'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    // เชื่อม OrderModel
    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'user_id');
    }

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    public function getAuthIdentifierName()
    {
        return 'user_email';
    }

}
