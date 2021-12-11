<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelephoneBook extends Model
{
    use HasFactory;

    protected $table = "telephone_books";

    protected $fillable = [
        'name'
    ];
}
