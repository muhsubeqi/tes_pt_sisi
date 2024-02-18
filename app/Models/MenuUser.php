<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuUser extends Model
{
    use HasFactory;

    protected $table = "menu_user";
    protected $guarded = [];
    protected $primaryKey = 'no_setting';
    public $timestamps = false;
}