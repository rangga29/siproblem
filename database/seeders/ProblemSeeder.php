<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function now;

class ProblemSeeder extends Seeder
{
    public function run(): void
    {
        $problems = [
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Rawat Jalan'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Rawat Darurat'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Rawat Inap'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Medical Checkup'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Rekam Medis'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'EMR'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Radiologi'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Laboratorium'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Penunjang Medis'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Farmasi'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Inventory'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Keuangan'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Accounting'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Gizi'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Keperawatan'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Pengaturan Sistem'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Sistem Oppe Keperawatan'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Sistem Oppe Nakes Lain'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Sistem Oppe Dokter'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Hardware'],
            ['dp_id' => 14, 'pr_ucode' => Str::random(20), 'pr_name' => 'Jaringan'],
            ['dp_id' => 32, 'pr_ucode' => Str::random(20), 'pr_name' => 'Alat Medis'],
            ['dp_id' => 32, 'pr_ucode' => Str::random(20), 'pr_name' => 'Kelistrikan'],
            ['dp_id' => 32, 'pr_ucode' => Str::random(20), 'pr_name' => 'Elektronik']
        ];

        foreach ($problems as $problem) {
            DB::table('problems')->insert([
                'dp_id' => $problem['dp_id'],
                'pr_ucode' => $problem['pr_ucode'],
                'pr_name' => $problem['pr_name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
