<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function ocorrencias()
    {
        return $this->hasMany(Ocorrencia::class);
    }

    protected $fillable = [
        'ra',
        'nome',
        'sala_id'
    ];
}
