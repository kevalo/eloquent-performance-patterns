<?php

namespace App\Models;

use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Builder;

class BillQueryBuilder extends Builder
{
    public function pendingBills(): self
    {
        $this->where('status', BillStatus::PENDING->value);
        return $this;
    }
}
