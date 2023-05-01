<?php declare(strict_types = 1);

namespace App\Request\Candidates;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateValidation extends FormRequest {
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
      'name'             => 'sometimes|required|max:255',
      'education'        => 'sometimes|required|min:2',
      'birthdate'        => 'sometimes|required|date_format:Y-m-d',
      'applied_position' => 'sometimes|required|min:5',
      'top_five_skills'  => 'sometimes|required|array|size:5',
      'email'            => 'required|email',
      'phone'            => 'sometimes|required|digits_between:10,12',
      'resume'           => 'sometimes|required|file|mimes:pdf|max:10000',
    ];
  }

  public function failedValidation(Validator $validator) {
    throw new HttpResponseException(response()->json([
        'code'   => 400,
        'errors' => $validator->errors(),
    ], 400));
  }
}
