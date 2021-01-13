<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DDZobov\PivotSoftDeletes\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\ToolName;

class Tools extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'tools';
    protected $primaryKey = 'id';
    protected $fillable = ['barcode', 'brand', 'property', 'reason'];

    public function toolcategory()
    {
        return $this->belongsToMany(Category::class, 'tool_category');
    }

    public function toolname()
    {
        return $this->belongsToMany(ToolName::class, 'tool_toolnames');
    }

    public function toolroom()
    {
        return $this->belongsToMany(Room::class, 'tool_rooms');
    }

    public function toolreport()
    {
        return $this->belongsToMany(Borrower::class, 'tool_report');
    }

    public function tooladmin()
    {
        return $this->belongsToMany(User::class, 'tool_admin');
    }
}
