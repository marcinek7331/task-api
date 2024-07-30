<?php

namespace App\Http\Requests;

use App\Constants\Response as ResponseConstant;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StoreTaskRequest extends FormRequest
{
    /**
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Task::SIZE => [
                'required',
                'integer',
                'min:1',
                'max:10',
            ],
        ];
    }

    /**
     *
     * @param Validator $validator
     *
     * @return JsonResponse
     */
    public function failedValidation(Validator $validator): JsonResponse
    {
        throw new HttpResponseException(response()->json([
            ResponseConstant::SUCCESS => false,
            ResponseConstant::DATA => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
