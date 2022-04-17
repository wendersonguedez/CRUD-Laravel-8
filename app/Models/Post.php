<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Indicando quais campos podem ter atribuição em massa (valores inseridos de uma só vez).
    protected $fillable = ['title', 'content', 'image'];

}
