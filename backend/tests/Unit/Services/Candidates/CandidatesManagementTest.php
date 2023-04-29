<?php declare(strict_types = 1);

namespace Tests\Unit\Services\Candidates;

use App\Helpers\TimestampConverterTrait;
use App\Request\Candidates\CreateValidation as CandidateCreateValidation;
use App\Repositories\Implementation\Candidates;
use App\Services\Candidates\CandidatesManagement as ServiceCandidateManagement;
use Tests\TestCase;
use Faker\Factory;

class CandidatesManagementTest extends TestCase {
  use TimestampConverterTrait;

  private $candidateRepo;

  public function setUp(): void {
    parent::setUp();

    $this->candidateRepo = $this->getMockBuilder(Candidates::class)
      ->onlyMethods(['insert', 'findAll', 'findById', 'delete', 'update'])
      ->getMock();
  }

  private function dataProvider(string $type = ''): array {
    $faker = Factory::create(Factory::DEFAULT_LOCALE);

    if ($type == 'uuid')
      return ['uuid' => $faker->uuid()];

    return [
      'name'             => 'test name',
      'education'        => 'universitas',
      'birthdate'        => '2020-01-01',
      'applied_position' => 'test position',
      'top_five_skills'  => ['1', '2', '3', '4', '5'],
      'email'            => $faker->email(),
      'phone'            => '1234567890',
      'resume'           => 'testfile.pdf',
    ];
  }

  /**
   * @test
   */
  public function createShouldWork(): void {
    // Custom provider for output
    $customOutput = $this->dataProvider();
    $customOutput['top_five_skills'] = "1,2,3,4,5";
    $customOutput['created_at']      = date('Y-m-d H:i:s');
    $customOutput['updated_at']      = date('Y-m-d H:i:s');
    $customOutput['resume']          = url($customOutput['resume']);

    $this->candidateRepo->expects($this->once())
      ->method('insert')
      ->willReturn($customOutput);

    // Custom provider for input
    $customInput = $this->dataProvider();
    $customInput['email']  = $customOutput['email'];

    $candidateManagement = new ServiceCandidateManagement($this->candidateRepo);
    $result = $candidateManagement->create($customInput);

    // Adjust some input and output
    $customInput['resume']     = url($customInput['resume']);
    $customInput['created_at'] = $this->toUtc($customOutput['created_at']);
    $customInput['updated_at'] = $this->toUtc($customOutput['updated_at']);

    $this->assertEquals($customInput, $result);
  }

  /**
   * @test
   */
  public function findAllShouldWork(): void {
    $customOutput = [$this->dataProvider()];
    $customOutput[0]['top_five_skills'] = "1,2,3,4,5";
    $customOutput[0]['created_at']      = date('Y-m-d H:i:s');
    $customOutput[0]['updated_at']      = date('Y-m-d H:i:s');
    $customOutput[0]['resume']          = url($customOutput[0]['resume']);

    $this->candidateRepo->expects($this->once())
      ->method('findAll')
      ->willReturn($customOutput);

    $candidateManagement = new ServiceCandidateManagement($this->candidateRepo);
    $result = $candidateManagement->fetchAll();

    // Adjust some output
    $customOutput[0]['top_five_skills'] = explode(',', $customOutput[0]['top_five_skills']);
    $customOutput[0]['created_at'] = $this->toUtc($customOutput[0]['created_at']);
    $customOutput[0]['updated_at'] = $this->toUtc($customOutput[0]['updated_at']);

    $this->assertCount(1, $result);
    $this->assertEquals($customOutput, $result);
  }

  /**
   * @test
   */
  public function findByIdShouldWork(): void {
    $customOutput = [$this->dataProvider()];
    $customOutput['id']              = $this->dataProvider('uuid')['uuid'];
    $customOutput['top_five_skills'] = "1,2,3,4,5";
    $customOutput['created_at']      = date('Y-m-d H:i:s');
    $customOutput['updated_at']      = date('Y-m-d H:i:s');
    $customOutput['resume']          = url($customOutput[0]['resume']);

    $this->candidateRepo->expects($this->once())
      ->method('findById')
      ->willReturn($customOutput);

    $candidateManagement = new ServiceCandidateManagement($this->candidateRepo);
    $result = $candidateManagement->fetchById($customOutput['id']);

    // Adjust some output
    $customOutput['top_five_skills'] = explode(',', $customOutput['top_five_skills']);
    $customOutput['created_at'] = $this->toUtc($customOutput['created_at']);
    $customOutput['updated_at'] = $this->toUtc($customOutput['updated_at']);

    $this->assertEquals($customOutput, $result);
  }

  /**
   * @test
   */
  public function deleteShouldWork(): void {
    $uuid = $this->dataProvider('uuid')['uuid'];

    $this->candidateRepo->expects($this->once())
      ->method('delete')
      ->willReturn(true);

    $candidateManagement = new ServiceCandidateManagement($this->candidateRepo);
    $result = $candidateManagement->delete($uuid);

    $expected = ['message' => "success to delete candidate data with id {$uuid}"];

    $this->assertEquals($expected, $result);
  }

  /**
   * @test
   */
  public function deleteShouldThrowException(): void {
    $uuid = $this->dataProvider('uuid')['uuid'];

    $this->candidateRepo->expects($this->once())
      ->method('delete')
      ->willReturn(false);

    $this->expectExceptionMessage("failed to delete candidate data with id {$uuid}");

    $candidateManagement = new ServiceCandidateManagement($this->candidateRepo);
    $candidateManagement->delete($uuid);
  }

  /**
   * @test
   */
  public function updateShouldWork(): void {
    $uuid = $this->dataProvider('uuid')['uuid'];

    $this->candidateRepo->expects($this->once())
      ->method('update')
      ->willReturn(true);

    $candidateManagement = new ServiceCandidateManagement($this->candidateRepo);
    $result = $candidateManagement->update($uuid, ['name' => 'testing']);

    $expected = ['message' => "success to update candidate data with id {$uuid}"];

    $this->assertEquals($expected, $result);
  }
}
