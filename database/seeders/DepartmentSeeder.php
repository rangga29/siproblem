<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['dp_code' => 'FA00', 'dp_name' => 'FARMASI', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'POL1', 'dp_name' => 'POLIKLINIK', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'GIZ1', 'dp_name' => 'GIZI', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'FI01', 'dp_name' => 'FISIOTERAPI', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'LA01', 'dp_name' => 'LABORATORIUM', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'MDS1', 'dp_name' => 'MEDIS (KPI)', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'RMED', 'dp_name' => 'REKAM MEDIK', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'RA01', 'dp_name' => 'RADIOLOGI', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'KUGD', 'dp_name' => 'UNIT GAWAT DARURAT', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'OKPM', 'dp_name' => 'KAMAR BEDAH', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'HCU2', 'dp_name' => 'ICU', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'PUR1', 'dp_name' => 'PURS', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'PURS', 'dp_name' => 'HUMAS & MARKETING', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'SISF', 'dp_name' => 'SISFO', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => true],
            ['dp_code' => 'SEKR', 'dp_name' => 'SEKRETARIAT RS', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'KOMP', 'dp_name' => 'KOMITE KEPERAWATAN', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'PKMR', 'dp_name' => 'PKRS', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'SPI1', 'dp_name' => 'SATUAN PENGAWAS INTERNAL', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'UMR1', 'dp_name' => 'KOMITE K3RS DAN MANAJEMEN RISIKO', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'KOMD', 'dp_name' => 'KOMITE MEDIK', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'RNP1', 'dp_name' => 'ELISABETH', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'ABRM', 'dp_name' => 'ABRAHAM', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'GABR', 'dp_name' => 'GABRIEL', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'RAFA', 'dp_name' => 'RAFAEL', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'PASO', 'dp_name' => 'PASOSMED', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'RNP3', 'dp_name' => 'PERAWAT MAGANG', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'PERS', 'dp_name' => 'SUMBER DAYA MANUSIA', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => false],
            ['dp_code' => 'BNDH', 'dp_name' => 'PERBENDAHARAAN', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => false],
            ['dp_code' => 'AKUN', 'dp_name' => 'AKUNTANSI & ANGGARAN', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => false],
            ['dp_code' => 'RTCK', 'dp_name' => 'RUMAH TANGGA', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => false],
            ['dp_code' => 'PENG', 'dp_name' => 'PENGADAAN', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => false],
            ['dp_code' => 'SUPS', 'dp_name' => 'SUPPORTING SERVICES', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => true],
            ['dp_code' => 'LOIN', 'dp_name' => 'LOGISTIK & INVENTARIS', 'dp_group' => 'DIREKTORAT UMUM', 'dp_spr' => false],
            ['dp_code' => 'JARM', 'dp_name' => 'JAJARAN MANAJEMEN RSCK', 'dp_group' => '', 'dp_spr' => false],
            ['dp_code' => 'DIR1', 'dp_name' => 'DIREKTUR', 'dp_group' => '', 'dp_spr' => false],
            ['dp_code' => 'MMED', 'dp_name' => 'WADIR MEDIS', 'dp_group' => '', 'dp_spr' => false],
            ['dp_code' => 'MPER', 'dp_name' => 'WADIR PERAWATAN', 'dp_group' => '', 'dp_spr' => false],
            ['dp_code' => 'MUMU', 'dp_name' => 'WADIR UMUM', 'dp_group' => '', 'dp_spr' => false],
            ['dp_code' => 'SARH', 'dp_name' => 'SARAH / MIKAEL', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'HEMO', 'dp_name' => 'HEMODIALISA', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'MIKL', 'dp_name' => 'MIKAEL (TIDAK DIPAKAI)', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'KOMI', 'dp_name' => 'KOMITE PPI', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'KCOV', 'dp_name' => 'KLINIK C', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'CARL', 'dp_name' => 'CAROLUS', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'ICUN', 'dp_name' => 'ICU (NC)', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'MPP1', 'dp_name' => 'MPP / CASE MANAGER', 'dp_group' => 'DIREKTORAT KEPERAWATAN', 'dp_spr' => false],
            ['dp_code' => 'KOMU', 'dp_name' => 'KOMITE MUTU DAN KESELAMATAN PASIEN', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'KOMT', 'dp_name' => 'KOMITE TENAGA KESEHATAN LAIN', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'KOME', 'dp_name' => 'KOMITE ETIK DAN HUKUM RS', 'dp_group' => 'NON DIREKTORAT', 'dp_spr' => false],
            ['dp_code' => 'PJKN', 'dp_name' => 'PENGELOLAAN PELAYANAN JKN', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'JKN1', 'dp_name' => 'JKN', 'dp_group' => 'DIREKTORAT MEDIS', 'dp_spr' => false],
            ['dp_code' => 'ADM', 'dp_name' => 'ADMINISTRATOR', 'dp_group' => '', 'dp_spr' => false]
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'dp_code' => $department['dp_code'],
                'dp_name' => $department['dp_name'],
                'dp_group' => $department['dp_group'],
                'dp_spr' => $department['dp_spr'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
