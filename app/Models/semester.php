<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class semester extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    protected $fillable = ['semester_years'];

    public $timestamps = false;
}
