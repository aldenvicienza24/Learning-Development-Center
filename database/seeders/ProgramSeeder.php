<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            // Pelatihan
            [
                'title' => 'Perpajakan & Asuransi',
                'category' => 'pelatihan',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400&h=200&fit=crop',
                'registration_date' => '12 Feb - 12 Mar',
                'price' => 2000000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detail1',
            ],
            [
                'title' => 'UI/UX Design Fundamental',
                'category' => 'pelatihan',
                'image_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=200&fit=crop',
                'registration_date' => '13 Feb - 29 Mar',
                'price' => 2500000,
                'quota' => 25,
                'total_quota' => 30,
                'detail_url' => 'detail2',
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'category' => 'pelatihan',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=200&fit=crop',
                'registration_date' => '18 Mar - 20 Apr',
                'price' => 1500000,
                'quota' => 15,
                'total_quota' => 20,
                'detail_url' => 'detail6', // Adjusted to match user's previous detail6 link
            ],
            // Sertifikasi
            [
                'title' => 'Sertifikasi Manajemen Proyek',
                'category' => 'sertifikasi',
                'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=200&fit=crop',
                'registration_date' => '10 Mar - 25 Apr',
                'price' => 2500000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detail3',
            ],
            [
                'title' => 'AutoCAD for Professional',
                'category' => 'sertifikasi',
                'image_url' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=400&h=200&fit=crop',
                'registration_date' => '15 Mar - 10 Apr',
                'price' => 2500000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detail4',
            ],
            // Bahasa
            [
                'title' => 'TOEFL Preparation Program',
                'category' => 'bahasa',
                'image_url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&auto=format&fit=crop',
                'registration_date' => '20 Feb - 30 Mar',
                'price' => 1200000,
                'quota' => 35,
                'total_quota' => 40,
                'detail_url' => 'detail5',
            ],
            [
                'title' => 'IELTS Intensive Coaching',
                'category' => 'bahasa',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=200&fit=crop',
                'registration_date' => '30 Feb - 15 Mar',
                'price' => 2500000,
                'quota' => 15,
                'total_quota' => 20,
                'detail_url' => 'detail6',
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
}
