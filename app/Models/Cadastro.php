<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadastro extends Model
{
    use HasFactory;

    protected $table = 'cadastros';

    protected $fillable = ['name', 'cpf'];
}
