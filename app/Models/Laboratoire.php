<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratoire extends Model
{
    use HasFactory, SoftDeletes;

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function doctorants()
    {
        return $this->hasManyThrough(Doctorant::class, User::class, 'laboratoire_id', 'user_id');
    }
}
