<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\Software;

class ObjectLineup extends Model
{
    use HasFactory;

    protected $table = 'object_lineups';

    protected $fillable = [
        "name",
        "description",
        "amount",
        "preview_file",
        "download_file",
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();;
    }

    public function softwares()
    {
        return $this->belongsToMany(Software::class)->withTimestamps();;
    }
}
