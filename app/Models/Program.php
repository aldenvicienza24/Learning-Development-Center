<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'category',
        'faculty',
        'image_url',
        'thumbnail',
        'description',
        'syllabus',
        'registration_date',
        'price',
        'quota',
        'total_quota',
        'detail_url',
        'publish_date',
        'registration_open_date',
        'event_date',
        'execution_date',
        'status',
        'is_registration_closed',
        'show_in_offer',
    ];

    protected $appends = [
        'computed_status',
        'registered_count',
        'remaining_quota',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'quota' => 'integer',
            'total_quota' => 'integer',
            'publish_date' => 'date',
            'registration_open_date' => 'date',
            'event_date' => 'date',
            'execution_date' => 'date',
            'is_registration_closed' => 'boolean',
            'show_in_offer' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saving(function (Program $program): void {
            if (! $program->slug) {
                $program->slug = static::uniqueSlug($program->title, $program->id);
            }

            if (! $program->thumbnail && $program->image_url) {
                $program->thumbnail = $program->image_url;
            }

            if (! $program->image_url && $program->thumbnail) {
                $program->image_url = $program->thumbnail;
            }

            if (! $program->total_quota) {
                $program->total_quota = $program->quota ?: 0;
            }
        });
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function trainers(): BelongsToMany
    {
        return $this->belongsToMany(Trainer::class);
    }

    protected function computedStatus(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->is_registration_closed || $this->remaining_quota <= 0) {
                return 'closed';
            }

            $today = CarbonImmutable::today(config('app.timezone'));

            if ($this->execution_date && $today->greaterThan($this->execution_date)) {
                return 'closed';
            }

            if ($this->event_date && $today->greaterThan($this->event_date)) {
                return 'closed';
            }

            if (! $this->event_date && ! $this->execution_date) {
                $deadline = $this->legacyRegistrationDeadline();

                if ($deadline && $today->greaterThan($deadline)) {
                    return 'closed';
                }
            }

            if ($this->registration_open_date && $today->lessThan($this->registration_open_date)) {
                return 'coming_soon';
            }

            return 'open_registration';
        });
    }

    protected function registeredCount(): Attribute
    {
        return Attribute::get(
            fn (): int => (int) ($this->registrations_count ?? $this->registrations()->count())
        );
    }

    protected function remainingQuota(): Attribute
    {
        return Attribute::get(fn (): int => max(0, (int) $this->quota));
    }

    public function isOpenForRegistration(): bool
    {
        return $this->computed_status === 'open_registration';
    }

    public function calendarDate(): ?CarbonImmutable
    {
        if ($this->execution_date) {
            return CarbonImmutable::instance($this->execution_date);
        }

        if ($this->event_date) {
            return CarbonImmutable::instance($this->event_date);
        }

        return $this->legacyRegistrationDeadline();
    }

    private function legacyRegistrationDeadline(): ?CarbonImmutable
    {
        preg_match_all('/(\d{1,2})\s+([\p{L}.]+)(?:\s+(\d{4}))?/u', (string) $this->registration_date, $matches, PREG_SET_ORDER);
        $lastDate = $matches ? end($matches) : null;

        if (! $lastDate) {
            return null;
        }

        $months = [
            'jan' => 1, 'januari' => 1,
            'feb' => 2, 'februari' => 2,
            'mar' => 3, 'maret' => 3,
            'apr' => 4, 'april' => 4,
            'mei' => 5, 'may' => 5,
            'jun' => 6, 'juni' => 6,
            'jul' => 7, 'juli' => 7,
            'agu' => 8, 'ags' => 8, 'aug' => 8, 'agustus' => 8,
            'sep' => 9, 'september' => 9,
            'okt' => 10, 'oct' => 10, 'oktober' => 10,
            'nov' => 11, 'november' => 11,
            'des' => 12, 'dec' => 12, 'desember' => 12,
        ];
        $monthName = strtolower(rtrim($lastDate[2], '.'));
        $month = $months[$monthName] ?? null;

        if (! $month) {
            return null;
        }

        // Legacy labels omit the year. Keep them in their original schedule year
        // so an expired program never reopens when the calendar year changes.
        $year = (int) ($lastDate[3] ?? $this->registration_open_date?->year
            ?? $this->publish_date?->year ?? $this->created_at?->year
            ?? CarbonImmutable::today(config('app.timezone'))->year);

        try {
            return CarbonImmutable::createSafe($year, $month, (int) $lastDate[1], 0, 0, 0, config('app.timezone'));
        } catch (\Throwable) {
            return null;
        }
    }

    public function calendarDateLabel(): string
    {
        return $this->execution_date ? 'Pelaksanaan Program' : 'Batas Akhir Pendaftaran';
    }

    public function categoryFacultyLabel(bool $english = false): string
    {
        $categoryLabels = $english
            ? [
                'pelatihan' => 'Professional Training',
                'sertifikasi' => 'Certification',
                'bahasa' => 'Language Program',
            ]
            : [
                'pelatihan' => 'Pelatihan',
                'sertifikasi' => 'Sertifikasi',
                'bahasa' => 'Bahasa',
            ];

        $facultyLabels = $english
            ? [
                'ekonomi-bisnis' => 'Economics and Business',
                'teknik-industri' => 'Industrial Technology',
                'teknologi-kreatif' => 'Creative Technology',
                'bahasa' => 'Language Studies',
            ]
            : [
                'ekonomi-bisnis' => 'Ekonomi dan Bisnis',
                'teknik-industri' => 'Teknik Industri',
                'teknologi-kreatif' => 'Teknologi Kreatif',
                'bahasa' => 'Bahasa',
            ];

        $category = $categoryLabels[strtolower((string) $this->category)]
            ?? Str::headline((string) $this->category);
        $faculty = $facultyLabels[strtolower((string) $this->faculty)]
            ?? Str::headline((string) $this->faculty);

        return $category === $faculty || $faculty === ''
            ? $category
            : "{$category} - {$faculty}";
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
