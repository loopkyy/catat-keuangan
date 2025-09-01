<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'amount', 'date', 
        'category_id', 'source_id', 'goal_id'
    ];

    public function category() { return $this->belongsTo(Category::class); }
    public function source() { return $this->belongsTo(Source::class); }
    public function goal() { return $this->belongsTo(Goal::class); }
}
