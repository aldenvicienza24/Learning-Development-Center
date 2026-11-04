<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected static function booted(): void
    {
        static::saving(function (Registration $registration): void {
            if ($registration->payment_status !== 'disetujui') {
                return;
            }

            // Approval confirms payment at the program tariff unless an amount is supplied.
            // Store it once so later price edits cannot change recognized income.
            if ($registration->payment_amount === null) {
                $registration->payment_amount = $registration->getOriginal('payment_amount')
                    ?? max(0, (int) ($registration->final_price ?? Program::query()->whereKey($registration->program_id)->value('price')));
            }
            if (! $registration->payment_received_at) {
                $registration->payment_received_at = $registration->getOriginal('payment_received_at');
                if (! $registration->payment_received_at && $registration->getOriginal('payment_status') !== 'disetujui') {
                    $registration->payment_received_at = today();
                }
            }
        });
    }

    protected $fillable = [
        'program_id',
        'visitor_id',
        'full_name',
        'email',
        'phone',
        'institution',
        'partner_discount_id',
        'discount_percentage',
        'discount_amount',
        'final_price',
        'payment_proof',
        'participant_status',
        'payment_status',
        'status',
        'seat_reserved',
        'payment_amount',
        'payment_received_at',
    ];

    protected function casts(): array
    {
        return [
            'seat_reserved' => 'boolean',
            'discount_percentage' => 'integer',
            'discount_amount' => 'integer',
            'final_price' => 'integer',
            'payment_amount' => 'integer',
            'payment_received_at' => 'date',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function partnerDiscount(): BelongsTo
    {
        return $this->belongsTo(PartnerDiscount::class);
    }

    public function getUniqueCodeAttribute(): string
    {
        // Example: REG-00123-030926
        return 'REG-' . str_pad($this->id, 5, '0', STR_PAD_LEFT) . '-' . $this->created_at->format('dmy');
    }
}
