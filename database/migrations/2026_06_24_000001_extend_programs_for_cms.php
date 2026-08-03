<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            if (! Schema::hasColumn('programs', 'slug')) {
                $table->string('slug')->nullable()->unique();
            }

            if (! Schema::hasColumn('programs', 'description')) {
                $table->text('description')->nullable();
            }

            if (! Schema::hasColumn('programs', 'syllabus')) {
                $table->text('syllabus')->nullable();
            }

            if (! Schema::hasColumn('programs', 'thumbnail')) {
                $table->string('thumbnail')->nullable();
            }

            if (! Schema::hasColumn('programs', 'publish_date')) {
                $table->date('publish_date')->nullable();
            }

            if (! Schema::hasColumn('programs', 'registration_open_date')) {
                $table->date('registration_open_date')->nullable();
            }

            if (! Schema::hasColumn('programs', 'event_date')) {
                $table->date('event_date')->nullable();
            }

            if (! Schema::hasColumn('programs', 'status')) {
                $table->string('status')->default('coming_soon');
            }

            if (! Schema::hasColumn('programs', 'is_registration_closed')) {
                $table->boolean('is_registration_closed')->default(false);
            }
        });

        DB::table('programs')->orderBy('id')->get()->each(function ($program): void {
            $slug = $program->slug ?: Str::slug($program->title);
            $baseSlug = $slug;
            $counter = 2;

            while (DB::table('programs')->where('slug', $slug)->where('id', '!=', $program->id)->exists()) {
                $slug = $baseSlug.'-'.$counter;
                $counter++;
            }

            DB::table('programs')
                ->where('id', $program->id)
                ->update([
                    'slug' => $slug,
                    'thumbnail' => $program->thumbnail ?: $program->image_url,
                    'description' => $program->description ?: 'Program '.$program->title.' dirancang untuk membantu peserta meningkatkan kompetensi melalui materi terarah dan pembelajaran praktis.',
                    'syllabus' => $program->syllabus ?: 'Materi utama akan disesuaikan dengan kebutuhan program dan dapat diperbarui oleh admin melalui CMS.',
                ]);
        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $columns = [
                'slug',
                'description',
                'syllabus',
                'thumbnail',
                'publish_date',
                'registration_open_date',
                'event_date',
                'status',
                'is_registration_closed',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('programs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
