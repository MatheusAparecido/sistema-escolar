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
        return $this->belongsTo(Professores::class);
    }
    protected $fillable = [
        'aluno_id',
        'user_id',
        'descricao',
        'relato_aluno',
        'data_relato_aluno',
        'relato_responsavel',
        'data_relato_responsavel',
        'data',
        'professor_id',
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
