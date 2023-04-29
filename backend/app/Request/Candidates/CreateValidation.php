<?php declare(strict_types = 1);

namespace App\Request\Candidates;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateValidation extends FormRequest {
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
      'name'             => 'required|max:255',
      'education'        => 'required|min:2',
      'birthdate'        => 'required|date_format:Y-m-d',
      'applied_position' => 'required|min:5',
      'top_five_skills'  => 'required|array|size:5',
      'email'            => 'required|email',
      'phone'            => 'required|digits_between:10,12',
      'resume'           => 'required|file|mimes:pdf|max:10000',
    ];
  }

  public function failedValidation(Validator $validator) {
    throw new HttpResponseException(response()->json([
        'errors' => $validator->errors(),
    ], 400));
  }
}
