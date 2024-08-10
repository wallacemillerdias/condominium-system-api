<?php

namespace App\Http\Requests;

use App\Dto\ErrorResponseDto;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CadastroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'string|min:3|max:150',
            'cpf' => 'cpf|unique:cadastros|required|cpf|min:11|max:11'
        ];

        if ($this->isMethod('POST')) {
            $requiredFields = ['name', 'cpf'];
            foreach ($requiredFields as $field) {
                $rules[$field] = 'required|' . $rules[$field];
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser do tipo texto.',
            'name.min' => 'O campo nome não poder ter menos de :min caracteres.',
            'name.max' => 'O campo nome não pode ter mais de :max caracteres.',
            'cpf.required' => 'O campo cpf é obrigatório.',
            'cpf.unique' => 'Este cpf já está cadastrado.',
            'cpf.min' => 'O campo CPF não pode ter menos de :min caracteres.',
            'cpf.max' => 'O campo CPF não pode ter mais de :max caracteres.'
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws UnknownProperties
     */

    protected function failedValidation(Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();
        $messages = array_merge(...array_values($errors));
        $errorResponseDto = new ErrorResponseDto(error: $messages, message: 'Existe erros de validação.');
        throw new HttpResponseException(
            response()->json($errorResponseDto->toArray(), ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
