<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function tipo()
    {
        return $this->belongsTo(TipoOcorrencia::class, 'tipo_ocorrencia_id');
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected $fillable = [
        'aluno_id',
        'user_id',
        'descricao',
        'data',
        'professor_nome',
        'tipo_ocorrencia_id',
        'foto',
        'codigo_conviva',
    ];
    protected $casts = [
        'data_ocorrencia' => 'date',
    ];

    public function getDataFormatadaAttribute()
    {
        return \Carbon\Carbon::parse($this->data_ocorrencia)->format('d/m/Y');
    }
}
