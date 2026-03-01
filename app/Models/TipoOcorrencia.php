<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoOcorrencia extends Model
{
    protected $table = 'tipos_ocorrencias';
    protected $fillable = ['nome'];
}
