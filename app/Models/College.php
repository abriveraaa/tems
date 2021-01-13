<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Models\LaratrustPermission;
use Illuminate\Database\Eloquent\Model;


class College extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public $guarded = [];
    
    protected $table = 'colleges';
    protected $primaryKey = 'id';
    protected $fillable = [ 'description', 'code' ];
    
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'college_courses');
    }   
    
    public function borrowercollege()
    {
        return $this->belongsToMany(Borrower::class, 'borrower_college');
    }
}
