<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
    protected $fillable = ['nome'];
}
