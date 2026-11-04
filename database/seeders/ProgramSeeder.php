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
                'title' => 'Perpajakan dan Asuransi',
                'category' => 'pelatihan',
                'faculty' => 'ekonomi-bisnis',
                'image_url' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=450&fit=crop',
                'registration_date' => '12 Feb sampai 12 Mar',
                'price' => 2000000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detail1',
                'is_international' => false,
            ],
            [
                'title' => 'Dasar-Dasar Desain UI/UX',
                'category' => 'pelatihan',
                'faculty' => 'teknologi-kreatif',
                'image_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=800&h=450&fit=crop',
                'registration_date' => '13 Feb sampai 29 Mar',
                'price' => 2500000,
                'quota' => 25,
                'total_quota' => 30,
                'detail_url' => 'detail2',
                'is_international' => false,
            ],
            [
                'title' => 'Spesialis Pemasaran Digital',
                'category' => 'pelatihan',
                'faculty' => 'ekonomi-bisnis',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&h=450&fit=crop',
                'registration_date' => '18 Mar sampai 20 Apr',
                'price' => 1500000,
                'quota' => 15,
                'total_quota' => 20,
                'detail_url' => 'detail6',
                'is_international' => false,
            ],
            // Sertifikasi
            [
                'title' => 'Sertifikasi Manajemen Proyek',
                'category' => 'sertifikasi',
                'faculty' => 'teknik-industri',
                'image_url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=450&fit=crop',
                'registration_date' => '10 Mar sampai 25 Apr',
                'price' => 2500000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detail3',
                'is_international' => false,
            ],
            [
                'title' => 'AutoCAD untuk Profesional',
                'category' => 'sertifikasi',
                'faculty' => 'teknik-industri',
                'image_url' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=800&h=450&fit=crop',
                'registration_date' => '15 Mar sampai 10 Apr',
                'price' => 2500000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detail4',
                'is_international' => false,
            ],
            // Bahasa
            [
                'title' => 'Program Persiapan TOEFL',
                'category' => 'bahasa',
                'faculty' => 'bahasa',
                'image_url' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&h=450&fit=crop',
                'registration_date' => '20 Feb sampai 30 Mar',
                'price' => 1200000,
                'quota' => 35,
                'total_quota' => 40,
                'detail_url' => 'detail5',
                'is_international' => false,
            ],
            [
                'title' => 'Pelatihan Intensif IELTS',
                'category' => 'bahasa',
                'faculty' => 'bahasa',
                'image_url' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=450&fit=crop',
                'registration_date' => '28 Feb sampai 15 Mar',
                'price' => 2500000,
                'quota' => 15,
                'total_quota' => 20,
                'detail_url' => 'detail7',
                'is_international' => false,
            ],
            [
                'title' => 'Corporate Tax and Risk Management',
                'subtitle' => 'International tax and enterprise risk training',
                'category' => 'pelatihan',
                'faculty' => 'ekonomi-bisnis',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=400&h=200&fit=crop',
                'registration_date' => '12 Feb to 12 Mar',
                'price' => 2000000,
                'quota' => 22,
                'total_quota' => 30,
                'detail_url' => 'detaila',
                'is_international' => true,
            ],
            [
                'title' => 'UI/UX Design Fundamentals (International)',
                'subtitle' => 'International UI/UX design fundamentals',
                'category' => 'pelatihan',
                'faculty' => 'teknologi-kreatif',
                'image_url' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=200&fit=crop',
                'registration_date' => '13 Feb to 29 Mar',
                'price' => 2500000,
                'quota' => 25,
                'total_quota' => 30,
                'detail_url' => 'detailb',
                'is_international' => true,
            ],
        ];

        foreach ($programs as $program) {
            Program::query()->updateOrCreate(
                ['detail_url' => $program['detail_url']],
                $program
            );
        }
    }
}
