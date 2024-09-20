<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
    use HasFactory, SoftDeletes;

    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
