<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:cadastros,cpf'
        ]);

        $cadastro = Cadastro::create([
            'name' => $request->name,
            'cpf' => $request->cpf,
            'draw_numbers' => random_int(100, 200)
        ]);

        return response()->json($cadastro, 201);
    }

    public function show($cpf)
    {
        $cadastro = Cadastro::where('cpf', $cpf)->first();

        if (!$cadastro) {
            return response()->json(['message' => 'CPF não encontrado.'], 404);
        }
        return response()->json($cadastro, 200);
    }

    public function index()
    {
        $cadastros = Cadastro::all();
        return response()->json($cadastros, 200);
    }
}
