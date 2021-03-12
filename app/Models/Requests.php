<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    public $guarded = [];
    
    protected $table = 'requests';
    protected $primaryKey = 'id';
    protected $fillable = [ 'lhof', 'tool', 'status' ];

    public function scopeGroupByLhof($query)
    {
        return $query->where('status', 'Borrowed')->groupBy('lhof')->with(['borrower', 'item', 'room', 'borrow'])->get();
    }

    public function scopeBorrowed($query, $item)
    {
        return $query->where('tool', $item)->where('status', 'Borrowed')->first();
    }

    public function scopeBorrowedItem($query, $item)
    {
        return $query->where('status', 'Borrowed')->where('tool', $item)->with(['borrower', 'item', 'room', 'borrow'])->get();
    }

    public function scopeHasBorrower($query, $borrower, $item)
    {
        return $query->with(['borrower' => function($q) use($borrower) {
            $q->where('borrower_id', $borrower);
        }])
        ->whereHas('borrower', function ($q) use($borrower) {
            $q->where('borrowers.id', $borrower);
        }) 
        ->where('status', 'Borrowed')
        ->where('tool', $item)
        ->exists();
    }

    public function room()
    {
        return $this->belongsToMany(Room::class, 'request_room');
    }

    public function borrower()
    {
        return $this->belongsToMany(Borrower::class, 'request_borrower');
    }

    public function borrowers()
    {
        return $this->belongsToMany(Borrower::class, 'request_borrower')->groupBy('borrower_id');
    }

    public function course()
    {
        return $this->belongsToMany(Course::class, 'request_course');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'request_course')->groupBy('course_id');
    }

    public function item()
    {
        return $this->belongsToMany(ToolName::class, 'request_item');
    }

    public function usageCount()
    {
        return $this->belongsToMany(ToolName::class, 'request_item')
            ->selectRaw('count(tool_names.id) as aggregate')
            ->groupBy('tool_name_id');
    }

    public function getusageCountAttribute()
    {
        if ( ! array_key_exists('usageCount', $this->relations)) $this->load('usageCount');

        $related = $this->getRelation('usageCount')->first();

        return ($related) ? $related->aggregate : 0;
    }

    public function borrow()
    {
        return $this->belongsToMany(User::class, 'request_borrow');
    }

    public function borrows()
    {
        return $this->belongsToMany(User::class, 'request_borrow')->groupBy('user_id');
    }

    public function return()
    {
        return $this->belongsToMany(User::class, 'request_return');
    }

    public function returns()
    {
        return $this->belongsToMany(User::class, 'request_return')->groupBy('user_id');
    }
}
