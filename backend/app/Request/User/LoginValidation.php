<?php declare(strict_types = 1);

namespace App\Request\User;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LoginValidation extends FormRequest {
  /**
   * Determine if the user is authorize to make a request
   *
   * @return boolean
   */
  public function authorize(): bool {
    return true;
  }

  /**
   * Get the validation rules that apply to the request
   *
   * @return array
   */
  public function rules(): array {
    return [
      'email'    => 'required|email',
      'password' => 'required',
    ];
  }

  public function failedValidation(Validator $validator) {
    throw new HttpResponseException(response()->json([
      'code'   => 400,
      'errors' => $validator->errors(),
    ], 400));
  }
}
