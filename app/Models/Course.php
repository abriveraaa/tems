<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Softdeletes;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;

class Course extends Model
{
    use HasFactory;
    use Softdeletes;
    
    public $guarded = [];
    
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $fillable = [ 'description', 'code' ];

    public function colleges()
    {
        return $this->belongsToMany(College::class, 'college_courses');
    }
    
    public function borrowercourse()
    {
        return $this->belongsToMany(Borrower::class, 'borrower_course');
    }
}
