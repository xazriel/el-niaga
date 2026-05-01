<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JneDestinationSeeder extends Seeder
{
    public function run(): void
    {
        $destinations = [
            ['code' => 'CGK10000', 'name' => 'PENJARINGAN, JAKARTA UTARA', 'city' => 'JAKARTA UTARA', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK10100', 'name' => 'PADEMANGAN, JAKARTA UTARA', 'city' => 'JAKARTA UTARA', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK20000', 'name' => 'GAMBIR, JAKARTA PUSAT', 'city' => 'JAKARTA PUSAT', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK20100', 'name' => 'SAWAH BESAR, JAKARTA PUSAT', 'city' => 'JAKARTA PUSAT', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK30000', 'name' => 'GROGOL, JAKARTA BARAT', 'city' => 'JAKARTA BARAT', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK30100', 'name' => 'KEBON JERUK, JAKARTA BARAT', 'city' => 'JAKARTA BARAT', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK40000', 'name' => 'TEBET, JAKARTA SELATAN', 'city' => 'JAKARTA SELATAN', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK40100', 'name' => 'KEBAYORAN BARU, JAKARTA SELATAN', 'city' => 'JAKARTA SELATAN', 'province' => 'DKI JAKARTA'],
            ['code' => 'CGK50000', 'name' => 'JATINEGARA, JAKARTA TIMUR', 'city' => 'JAKARTA TIMUR', 'province' => 'DKI JAKARTA'],
            ['code' => 'DPK10000', 'name' => 'BEJI, DEPOK', 'city' => 'DEPOK', 'province' => 'JAWA BARAT'],
            ['code' => 'DPK10100', 'name' => 'PANCORAN MAS, DEPOK', 'city' => 'DEPOK', 'province' => 'JAWA BARAT'],
            ['code' => 'DPK10200', 'name' => 'SUKMAJAYA, DEPOK', 'city' => 'DEPOK', 'province' => 'JAWA BARAT'],
            ['code' => 'DPK10300', 'name' => 'CIMANGGIS, DEPOK', 'city' => 'DEPOK', 'province' => 'JAWA BARAT'],
            ['code' => 'BDO10000', 'name' => 'ANDIR, BANDUNG', 'city' => 'BANDUNG', 'province' => 'JAWA BARAT'],
            ['code' => 'BDO10100', 'name' => 'CICENDO, BANDUNG', 'city' => 'BANDUNG', 'province' => 'JAWA BARAT'],
            ['code' => 'BDO10200', 'name' => 'COBLONG, BANDUNG', 'city' => 'BANDUNG', 'province' => 'JAWA BARAT'],
            ['code' => 'BDO10300', 'name' => 'BUAHBATU, BANDUNG', 'city' => 'BANDUNG', 'province' => 'JAWA BARAT'],
            ['code' => 'SBY10000', 'name' => 'GENTENG, SURABAYA', 'city' => 'SURABAYA', 'province' => 'JAWA TIMUR'],
            ['code' => 'SBY10100', 'name' => 'BUBUTAN, SURABAYA', 'city' => 'SURABAYA', 'province' => 'JAWA TIMUR'],
            ['code' => 'SBY10200', 'name' => 'TAMBAKSARI, SURABAYA', 'city' => 'SURABAYA', 'province' => 'JAWA TIMUR'],
            ['code' => 'MLG10000', 'name' => 'KLOJEN, MALANG', 'city' => 'MALANG', 'province' => 'JAWA TIMUR'],
            ['code' => 'MLG10100', 'name' => 'BLIMBING, MALANG', 'city' => 'MALANG', 'province' => 'JAWA TIMUR'],
            ['code' => 'YOG10000', 'name' => 'DANUREJAN, YOGYAKARTA', 'city' => 'YOGYAKARTA', 'province' => 'DI YOGYAKARTA'],
            ['code' => 'YOG10100', 'name' => 'GONDOKUSUMAN, YOGYAKARTA', 'city' => 'YOGYAKARTA', 'province' => 'DI YOGYAKARTA'],
            ['code' => 'SOC10000', 'name' => 'LAWEYAN, SOLO', 'city' => 'SOLO', 'province' => 'JAWA TENGAH'],
            ['code' => 'SMG10000', 'name' => 'SEMARANG TENGAH', 'city' => 'SEMARANG', 'province' => 'JAWA TENGAH'],
            ['code' => 'MES10000', 'name' => 'MEDAN KOTA', 'city' => 'MEDAN', 'province' => 'SUMATERA UTARA'],
            ['code' => 'PLM10000', 'name' => 'ILIR BARAT, PALEMBANG', 'city' => 'PALEMBANG', 'province' => 'SUMATERA SELATAN'],
            ['code' => 'PKU10000', 'name' => 'PEKANBARU KOTA', 'city' => 'PEKANBARU', 'province' => 'RIAU'],
            ['code' => 'BPN10000', 'name' => 'BALIKPAPAN KOTA', 'city' => 'BALIKPAPAN', 'province' => 'KALIMANTAN TIMUR'],
            ['code' => 'UPG10000', 'name' => 'UJUNG PANDANG, MAKASSAR', 'city' => 'MAKASSAR', 'province' => 'SULAWESI SELATAN'],
            ['code' => 'DPS10000', 'name' => 'DENPASAR KOTA', 'city' => 'DENPASAR', 'province' => 'BALI'],
            ['code' => 'DPS10100', 'name' => 'KUTA, BADUNG', 'city' => 'BADUNG', 'province' => 'BALI'],
        ];

        DB::table('jne_destinations')->insertOrIgnore($destinations);
    }
}