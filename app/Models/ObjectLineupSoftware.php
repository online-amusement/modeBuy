<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectLineupSoftware extends Model
{
    use HasFactory;

    const OBJECT_LINEUP_ID = 'object_lineup_id';

    protected $table = "object_lineup_software";

    protected $fillable = [
        "object_lineup_id",
        "software_id"
    ];
}
