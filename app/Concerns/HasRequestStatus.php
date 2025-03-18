<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasRequestStatus
{
    public function initializeHasRequestStatus(): void
    {
        $this->fillable[] = 'status';

        $this->casts['status'] = RequestStatus::class;
    }

    public static function bootHasRequestStatus(): void
    {
        static::creating(function (self $request) {
            if (blank($request->status)) {
                $request->status = RequestStatus::NEW;
            }
        });
    }

    public function scopeWhereNew(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::NEW);
    }

    public function scopeWhereReferred(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::REFERRED);
    }

    public function scopeWhereNewOrReferred(Builder $query): Builder
    {
        return $query->whereIn('status', [RequestStatus::NEW, RequestStatus::REFERRED]);
    }

    public function scopeWherePending(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::PENDING);
    }

    public function scopeWhereAccepted(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::ACCEPTED);
    }

    public function scopeWhereRejected(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::REJECTED);
    }

    public function scopeWhereObsolete(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::OBSOLETE);
    }

    public function scopeWhereDuplicate(Builder $query): Builder
    {
        return $query->where('status', RequestStatus::DUPLICATE);
    }

    public function isNew(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::NEW);
    }

    public function isReferred(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::REFERRED);
    }

    public function isPending(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::PENDING);
    }

    public function isAccepted(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::ACCEPTED);
    }

    public function isRejected(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::REJECTED);
    }

    public function isObsolete(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::OBSOLETE);
    }

    public function isDuplicate(): bool
    {
        return RequestStatus::isValue($this->status, RequestStatus::DUPLICATE);
    }

    public function accept(): bool
    {
        return $this->update([
            'status' => RequestStatus::ACCEPTED,
        ]);
    }

    public function reject(?string $reason = null): bool
    {
        return $this->update([
            'status' => RequestStatus::REJECTED,
            'reason_rejected' => $reason,
        ]);
    }

    public function markAsPending(): bool
    {
        return $this->update([
            'status' => RequestStatus::PENDING,
        ]);
    }

    public function markAsObsolete(): bool
    {
        return $this->update([
            'status' => RequestStatus::OBSOLETE,
        ]);
    }

    public function markAsDuplicate(): bool
    {
        return $this->update([
            'status' => RequestStatus::DUPLICATE,
        ]);
    }
}
