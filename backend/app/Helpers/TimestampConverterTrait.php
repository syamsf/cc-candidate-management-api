<?php declare(strict_types = 1);

namespace App\Helpers;

use Carbon\Carbon;

trait TimestampConverterTrait {
  public function toUtc(string $date): int {
    if (empty($date))
      throw new \Exception("date is required");

    return Carbon::parse($date)->setTimezone('UTC')->timestamp;
  }
}
