<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];
    
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = [ 'description' ];

    public function items()
    {
        return $this->belongsToMany(ToolName::class, 'category_toolnames');
    }

    public function tools()
    {
        return $this->belongsToMany(Tools::class, 'tool_category');
    }

    public function toolname()
    {
        return $this->belongsToMany(ToolName::class, 'tool_toolnames');
    }

    public function toolroom()
    {
        return $this->belongsToMany(Room::class, 'tool_rooms');
    }
}
