<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillUser extends Model
{
    use HasFactory;

    protected $table = 'bill_user';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'bill_id',
    ];
}
