<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lhof extends Model
{
    use HasFactory;

    public $guarded = [];
    
    protected $table = 'lhof';
    protected $primaryKey = 'id';
    protected $fillable = [ 'code' ];
}
