<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StaffModel extends Authenticatable
{
    protected $table = 'tbl_staff';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['st_name', 'st_email', 'st_password', 'st_timestamp'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->st_password;
    }

    public function getAuthIdentifierName()
    {
        return 'st_name';
    }
}


