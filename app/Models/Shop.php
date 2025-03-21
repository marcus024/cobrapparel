<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'owner', 'image','contact_number', 'contact_name', 'duration','emailAddress'];
}
