<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    public function initializeHasStatus(): void
    {
        $this->fillable[] = 'status';

        $this->casts['status'] = Status::class;
    }

    public static function bootHasStatus(): void
    {
        static::creating(function (self $model) {
            $model->status = Status::PENDING;
        });
    }

    public function scopeWhereActive(Builder $query): Builder
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function scopeWhereInactive(Builder $query): Builder
    {
        return $query->where('status', Status::INACTIVE);
    }

    public function scopeWherePending(Builder $query): Builder
    {
        return $query->where('status', Status::PENDING);
    }

    public function isActive(): bool
    {
        return Status::isValue($this->status, Status::ACTIVE);
    }

    public function isInactive(): bool
    {
        return Status::isValue($this->status, Status::INACTIVE);
    }

    public function isPending(): bool
    {
        return Status::isValue($this->status, Status::PENDING);
    }

    public function activate(): bool
    {
        return $this->update([
            'status' => Status::ACTIVE,
        ]);
    }

    public function deactivate(): self
    {
        return $this->update([
            'status' => Status::INACTIVE,
        ]);
    }
}
