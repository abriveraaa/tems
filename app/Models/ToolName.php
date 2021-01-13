<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ToolName extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $guarded = [];
    
    protected $table = 'tool_names';
    protected $primaryKey = 'id';
    protected $fillable = [ 'description'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_toolnames');
    }

    public function toolcategory()
    {
        return $this->belongsToMany(Category::class, 'tool_category');
    }

    public function tools()
    {
        return $this->belongsToMany(Tools::class, 'tool_toolnames');
    }

    public function toolroom()
    {
        return $this->belongsToMany(Room::class, 'tool_rooms');
    }

}
