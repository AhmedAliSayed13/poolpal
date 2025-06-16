<?php

namespace App\Http\Requests\test;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreTestRequest extends FormRequest
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
            'pool_id' => 'required',
            'pool_water_status_id' => 'required',
            'hardness' => 'required',
            'chlorine' => 'required',
            'free_chlorine' => 'required',
            'ph' => 'required',
            'alkalinity' => 'required',
            'stabilizer' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
