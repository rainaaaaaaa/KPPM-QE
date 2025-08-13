<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MtraProject;
use Illuminate\Support\Facades\Hash;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample partner users
        $partners = [
            [
                'name' => 'Mitra Jakarta',
                'email' => 'mitra@jakarta.com',
                'password' => Hash::make('password'),
                'role' => 'partner',
            ],
            [
                'name' => 'Mitra Bandung',
                'email' => 'mitra@bandung.com',
                'password' => Hash::make('password'),
                'role' => 'partner',
            ],
            [
                'name' => 'Mitra Surabaya',
                'email' => 'mitra@surabaya.com',
                'password' => Hash::make('password'),
                'role' => 'partner',
            ],
        ];

        foreach ($partners as $partner) {
            User::create($partner);
        }

        // Create sample MTRA projects
        $projects = [
            [
                'nomor_kontrak' => 'MTRA-001-2024',
                'lokasi' => 'Jakarta Pusat',
                'latitude' => -6.2088,
                'longitude' => 106.8456,
                'jenis' => 'recovery',
                'keterangan' => 'Project recovery jaringan di Jakarta Pusat',
                'user_id' => 1,
            ],
            [
                'nomor_kontrak' => 'MTRA-002-2024',
                'lokasi' => 'Bandung',
                'latitude' => -6.9175,
                'longitude' => 107.6191,
                'jenis' => 'preventif',
                'keterangan' => 'Maintenance preventif di Bandung',
                'user_id' => 2,
            ],
            [
                'nomor_kontrak' => 'MTRA-003-2024',
                'lokasi' => 'Surabaya',
                'latitude' => -7.2575,
                'longitude' => 112.7521,
                'jenis' => 'relokasi',
                'keterangan' => 'Relokasi peralatan di Surabaya',
                'user_id' => 3,
            ],
        ];

        foreach ($projects as $project) {
            MtraProject::create($project);
        }
    }
}
