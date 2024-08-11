<?php

namespace App\Http\Controllers;

use App\Dto\ErrorResponseDto;
use App\Dto\SuccessResponseDto;
use App\Http\Requests\CadastroRequest;
use App\Models\Cadastro;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class CadastroController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function index()
    {
        $cadastro = Cadastro::all();
        $responseDto = new SuccessResponseDto(data: $cadastro, message: "Listando todos os moradores.");
        return response()->json($responseDto->toArray(), StatusCode::HTTP_OK);
    }

    public function store(CadastroRequest $request): Application|Response|JsonResponse|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            $cadastro = Cadastro::create([
                'name' => $request->input('name'),
                'cpf' => $request->input('cpf')
            ]);
            $responseDto = new SuccessResponseDto(data: $cadastro, message:
                "Estamos muito felizes por ter você conosco! Seu cadastro foi concluído com sucesso. Fique atento(a), entraremos em contato em breve.
            ");
            return \response()->json($responseDto->toArray(), StatusCode::HTTP_CREATED);
        } catch (\Exception $e) {
            $errorResponseDto = new ErrorResponseDto(error: $e->getMessage(), message: "Erro ao criar morador.");
            return \response()->json($errorResponseDto->toArray(), StatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function show($id):JsonResponse
    {
        try {
            $cadastro = Cadastro::findOrFail($id);
            $responseDto = new SuccessResponseDto(data: $cadastro, message: "Morador encontrado com sucesso.");
            return \response()->json($responseDto->toArray(), StatusCode::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $errorResponseDto = new ErrorResponseDto(error: $e->getMessage(), message: "Morador não encontrado.");
            return \response()->json($errorResponseDto->toArray(), StatusCode::HTTP_NOT_FOUND);
        }
    }

    public function update(CadastroRequest $request, string $id):JsonResponse
    {
        try {
            $cadastro = Cadastro::findOrFail($id);
            $cadastro->update($request->only('name'));
            $responseDto = new SuccessResponseDto(data: $cadastro, message: "Morador atualizado com sucesso.");
            return response()->json($responseDto->toArray(), StatusCode::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $errorResponseDto = new ErrorResponseDto(error: "Morador não encontrado.", message: "Nenhum morador encontrado com o ID ($id) fornecido para atualização.");
            return \response()->json($errorResponseDto->toArray(), StatusCode::HTTP_NOT_FOUND);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $cadastro = Cadastro::findOrFail($id);
            $cadastro->delete();
            $responseDto = new SuccessResponseDto(data: null, message: "Morador deletado com sucesso.");
            return \response()->json($responseDto->toArray(), StatusCode::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $errorResponseDto = new ErrorResponseDto(error: "Morador não encontrado.", message: "Nenhum morador encontrado com o ID($id) fornecido para deleção.");
            return response()->json($errorResponseDto->toArray(), StatusCode::HTTP_NOT_FOUND);
        }
    }
}
