<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'staff_id', 'status', 'date'];
}
