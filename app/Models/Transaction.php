<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',       
        'amount',
        'type', 
        'description',
        'category_id',
        'source_id',
        'goal_id',
        'date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
