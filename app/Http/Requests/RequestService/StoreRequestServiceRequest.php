<?php

namespace App\Http\Requests\RequestService;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreRequestServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // set to false if you want to restrict access
    }

    public function rules(): array
    {
        return [
            // 'user_id' => 'required|integer',
            'address' => 'required|string',
            'service' => 'required|string',
            'phone' => 'required|string',
        ];
    }




protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json([
            'status'  => false,
            'message' => 'Validation Error',
            'errors'  => $validator->errors()
        ], 422));

}
}
