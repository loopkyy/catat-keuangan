<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['name', 'target_amount', 'saved_amount', 'deadline'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

