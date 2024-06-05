<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = "members";

    protected $fillable = [
        "name",
        "email",
        "password",
        "api_token",
        "country",
        "address",
        "city",
        "status",
        "points",
        "created_at",
        "updated_at",
    ];
}
