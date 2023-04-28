<?php declare(strict_types = 1);

namespace Tests\Unit\Request\Validation;

use App\Request\Candidates\UpdateValidation as CandidateUpdateValidation;
use Faker\Factory;
use Tests\TestCase;

class UpdateValidationTest extends TestCase {
  private array $rules;
  private $validator;

  public function setUp(): void {
    parent::setUp();
    $this->rules = (new CandidateUpdateValidation())->rules();
    $this->validator = app()->get('validator');
  }

  public static function validationProvider(): array {
    $faker = Factory::create(Factory::DEFAULT_LOCALE);

    $pdfFile = \Illuminate\Http\UploadedFile::fake()->create('test.pdf');
    $rarFile = \Illuminate\Http\UploadedFile::fake()->create('test.rar');

    return [
      'should_fail_when_no_email_is_provided' => [
        'pass'   => false,
        'data'   => [
          'name' => null,
        ]
      ],
      'should_work_when_email_is_provided' => [
        'pass'   => true,
        'data'   => [
          'email' => $faker->email(),
          'education' => 'universitas'
        ]
      ],
      'should_fail_when_email_is_provided_but_name_is_empty' => [
        'pass'   => false,
        'data'   => [
          'name'  => '',
          'email' => $faker->email(),
        ]
      ],
      'should_fail_when_email_name_is_provided_but_education_is_empty' => [
        'pass'   => false,
        'data'   => [
          'name'      => $faker->name(),
          'email'     => $faker->email(),
          'education' => ''
        ]
      ],
      'should_work_when_complete_data_is_provided' => [
        'pass'   => true,
        'data'   => [
          'name'             => 'test name',
          'education'        => 'universitas',
          'birthdate'        => '2020-01-01',
          'applied_position' => 'test position',
          'top_five_skills'  => ['1', '2', '3', '4', '5'],
          'email'            => $faker->email(),
          'phone'            => '1234567890',
          'resume'           => $pdfFile,
        ]
      ],
      'should_fail_when_file_is_rar' => [
        'pass'   => false,
        'data'   => [
          'name'             => 'test name',
          'education'        => 'universitas',
          'birthdate'        => '2020-01-01',
          'applied_position' => 'test position',
          'top_five_skills'  => ['1', '2', '3', '4', '5'],
          'email'            => $faker->email(),
          'phone'            => '1234567890',
          'resume'           => $rarFile,
        ]
      ],
      'should_fail_when_skills_only_3' => [
        'pass'   => false,
        'data'   => [
          'name'             => 'test name',
          'education'        => 'universitas',
          'birthdate'        => '2020-01-01',
          'applied_position' => 'test position',
          'top_five_skills'  => ['1', '2', '3'],
          'email'            => $faker->email(),
          'phone'            => '1234567890',
          'resume'           => $rarFile,
        ]
      ],
      'should_fail_when_name_is_greater_than_255' => [
        'pass'   => false,
        'data'   => [
          'name' => $faker->words(256)
        ]
      ],
    ];
  }

  /**
   * @test
   * @dataProvider validationProvider
   */
  public function validation_result(bool $shouldPass, array $mockedRequestData): void {
    $this->assertEquals($shouldPass, $this->validate($mockedRequestData));
  }

  private function validate(array $mockedRequestData): bool {
    return $this->validator
      ->make($mockedRequestData, $this->rules)
      ->passes();
  }
}
