<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ObjectLineup;

class Tag extends Model
{
    use HasFactory;

    protected $table = "tags";

    protected $fillable = [
        "name",
        "status"
    ];

    public function objectLineups()
    {
        return $this->belongsToMany(ObjectLineup::class);
    }
}
