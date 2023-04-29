<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class User extends Controller {
  public function login(Request $request) {
    try {
      $email = $request->input('email', '');
      $password = $request->input('password', '');

      if (empty($email) || empty($password))
        return back()->with('error', 'email or password is required');

      $client = new Client();
      $result = $client->post('http://localhost:8001/api/v1/login', [
        'form_params' => [
          'email'    => $email,
          'password' => $password
        ]
      ]);

      $response = $result->getBody()->getContents();
      $response = json_decode($response, true);
      $request->session()->regenerate();

      foreach ($response as $key => $value) {
        $request->session()->put($key, $value);
      }

      return redirect()->intended('/dashboard');
    } catch (ClientException $e) {
      $errorMessage = $e->getResponse()->getBody()->getContents();
      $errorMessage = json_decode($errorMessage, true);

      return back()->with('error', $errorMessage['errors']['message']);
    } catch (\Exception  $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  public function logout(Request $request) {
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
  }

  public function create(Request $request) {
    $validator = Validator::make($request->all(), [
      'name'             => 'required|max:255',
      'education'        => 'required|min:2',
      'birthdate'        => 'required|date_format:Y-m-d',
      'applied_position' => 'required|min:5',
      'top_five_skills'  => 'required|array|size:5',
      'email'            => 'required|email',
      'phone'            => 'required|digits_between:10,12',
      'resume'           => 'required|file|mimes:pdf|max:10000',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'errors' => $validator->errors(),
      ], 422);
    }

    try {
      $resume = $request->file('resume');
      $file = new \SplFileInfo($resume->getRealPath());
      $topFiveSkills = $request->input('top_five_skills');

      $formData = [
        [
            'name' => 'experience',
            'contents' => $request->input('experience'),
        ],
        [
            'name' => 'last_position',
            'contents' => $request->input('last_position'),
        ],
        [
            'name' => 'name',
            'contents' => $request->input('name'),
        ],
        [
            'name' => 'education',
            'contents' => $request->input('education'),
        ],
        [
            'name' => 'birthdate',
            'contents' => $request->input('birthdate'),
        ],
        [
            'name' => 'applied_position',
            'contents' => $request->input('applied_position'),
        ],
        [
            'name' => 'email',
            'contents' => $request->input('email'),
        ],
        [
            'name' => 'phone',
            'contents' => $request->input('phone'),
        ],
        [
            'name' => 'resume',
            'contents' => fopen($file->getPathname(), 'r'),
            'filename' => $resume->getClientOriginalName(),
        ],
      ];

      foreach ($topFiveSkills as $item) {
        $formData[] = [
          'name' => "top_five_skills[]",
          'contents' => $item
        ];
      }

      $client = new Client();
      $result = $client->post('http://localhost:8001/api/v1/candidates', [
        'multipart' => $formData,
        'headers' => [
          'Authorization' => 'Bearer ' . session()->get('access_token'),
        ],
      ]);

      $response = $result->getBody()->getContents();
      $response = json_decode($response, true);

      return response()->json([
        'success' => true,
        'message' => 'Resource created successfully',
      ], 200);
    } catch (ClientException $e) {
      $errorMessage = $e->getResponse()->getBody()->getContents();
      $errorMessage = json_decode($errorMessage, true);

      $message = '';
      if (is_array($errorMessage['errors'])) {
        foreach ($errorMessage['errors'] as $key => $value) {
          $message = $value[0];
          break;
        }

      } else {
        $message = $errorMessage['errors']['message'];
      }

      return response()->json([
        'success' => false,
        'message' => $message,
      ], 400);
    } catch (\Exception  $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 400);
    }
  }

  public function update(Request $request, string $candidateId) {
    $validator = Validator::make($request->all(), [
      'name'             => 'required|max:255',
      'education'        => 'required|min:2',
      'birthdate'        => 'required|date_format:Y-m-d',
      'applied_position' => 'required|min:5',
      'top_five_skills'  => 'required|array|size:5',
      'email'            => 'required|email',
      'phone'            => 'required|digits_between:10,12',
    ]);

    if ($validator->fails()) {
      return response()->json([
        'success' => false,
        'errors' => $validator->errors(),
      ], 422);
    }

    try {
      $formData = [
        'experience' => $request->input('experience'),
        'last_position' => $request->input('last_position'),
        'name' => $request->input('name'),
        'education' => $request->input('education'),
        'birthdate' => $request->input('birthdate'),
        'applied_position' => $request->input('applied_position'),
        'email' => $request->input('email'),
        'phone' => $request->input('phone'),
        'top_five_skills' => $request->input('top_five_skills')
      ];

      $client = new Client();
      $result = $client->put("http://localhost:8001/api/v1/candidates/{$candidateId}", [
        'form_params' => $formData,
        'headers' => [
          'Authorization' => 'Bearer ' . session()->get('access_token'),
        ],
      ]);

      $response = $result->getBody()->getContents();
      $response = json_decode($response, true);

      return response()->json([
        'success' => true,
        'message' => 'Resource updated successfully',
      ], 200);
    } catch (ClientException $e) {
      $errorMessage = $e->getResponse()->getBody()->getContents();
      $errorMessage = json_decode($errorMessage, true);

      $message = '';
      if (is_array($errorMessage['errors'])) {
        foreach ($errorMessage['errors'] as $key => $value) {
          $message = $value[0];
          break;
        }

      } else {
        $message = $errorMessage['errors']['message'];
      }

      return response()->json([
        'success' => false,
        'message' => $message,
      ], 400);
    } catch (\Exception  $e) {
      return response()->json([
        'success' => false,
        'message' => $e->getMessage(),
      ], 400);
    }
  }
}
