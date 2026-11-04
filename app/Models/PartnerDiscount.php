<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PartnerDiscount extends Model
{
    protected $fillable = [
        'institution_name',
        'email_domain',
        'discount_percentage',
        'program_id',
        'is_active',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'discount_percentage' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function setEmailDomainAttribute($value): void
    {
        $this->attributes['email_domain'] = strtolower(ltrim(trim((string) $value), '@'));
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public static function normalizeDomain(string $domain): string
    {
        return strtolower(ltrim(trim($domain), '@'));
    }

    public static function extractDomainFromEmail(string $email): ?string
    {
        $parts = explode('@', trim($email));
        if (count($parts) < 2) {
            return null;
        }

        return strtolower(trim(end($parts)));
    }

    public static function findDiscountForEmail(string $email, ?int $programId = null): ?self
    {
        $domain = self::extractDomainFromEmail($email);
        if (! $domain) {
            return null;
        }

        $candidates = self::query()
            ->where('is_active', true)
            ->where(function ($query) use ($programId) {
                $query->whereNull('program_id');
                if ($programId) {
                    $query->orWhere('program_id', $programId);
                }
            })
            ->get();

        $matched = $candidates->filter(function (self $candidate) use ($domain) {
            $candidateDomain = self::normalizeDomain($candidate->email_domain);
            if ($candidateDomain === '') {
                return false;
            }

            return $domain === $candidateDomain || Str::endsWith($domain, '.' . $candidateDomain);
        });

        return $matched
            ->sortByDesc(function (self $candidate) {
                // Program-specific discounts take priority over global discounts, then by discount percentage.
                $isSpecific = $candidate->program_id !== null ? 1000 : 0;
                return $isSpecific + $candidate->discount_percentage;
            })
            ->first();
    }
}
