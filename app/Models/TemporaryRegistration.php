<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryRegistration extends Model
{
    use HasFactory;

    protected $table = 'temporary_registration';

    protected $fillable = [
        'email',
        'token',
        'expiration_date',
        'created_at',
        'updated_at',
    ]; 
}
