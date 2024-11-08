<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObjectLineupTag extends Model
{
    use HasFactory;

    const OBJECT_LINEUP_ID = "object_lineup_id";

    protected $table = "object_lineup_tag";

    protected $fillable = [
        "object_lineup_id",
        "tag_id"
    ];
}
