<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'price', 
        'image', 
        'quantity', 
        'size', 
        'color',
        'custom_name',
        'custom_number'
    ];
}
