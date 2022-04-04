<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOpname extends Model
{
    use HasFactory;
    public $table = 'barang';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $fillable = [
        'nama', 
        'kategori', 
        'varian',
        
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
