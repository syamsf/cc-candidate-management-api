<?php declare(strict_types = 1);

namespace App\Helpers;

use Illuminate\Database\QueryException;

trait MysqlErrorHandlerTrait {
  use ResponseFormatterTrait;

  public function handleMysqlError(QueryException $e): string {
    $errorCode = $e->errorInfo[1];

    $message = 'undefined error';
    if ($errorCode == 1062) {
      $message = "email already registered";
    }

    return $message;
  }
}
