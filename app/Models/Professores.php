<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professores extends Model
{
    protected $fillable = ['nome'];

    public function ocorrencias()
    {
        return $this->hasMany(Ocorrencia::class);
    }
}
