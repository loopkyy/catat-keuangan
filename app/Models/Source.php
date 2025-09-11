<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['name', 'description'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}


