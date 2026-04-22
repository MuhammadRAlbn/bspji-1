<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KabupatenCoordinateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coordinates = [
            1171 => ['latitude' => 5.5483000, 'longitude' => 95.3238000], // KOTA BANDA ACEH
            1106 => ['latitude' => 5.1050000, 'longitude' => 95.5880000], // KAB. ACEH BESAR
            1105 => ['latitude' => 4.1449000, 'longitude' => 96.1284000], // KAB. ACEH BARAT
            1173 => ['latitude' => 5.1801000, 'longitude' => 97.1507000], // KOTA LHOKSEUMAWE
            1115 => ['latitude' => 4.1360000, 'longitude' => 96.3400000], // KAB. NAGAN RAYA
            1107 => ['latitude' => 5.3822000, 'longitude' => 95.9587000], // KAB. PIDIE
            1108 => ['latitude' => 5.0482000, 'longitude' => 97.3039000], // KAB. ACEH UTARA
            1112 => ['latitude' => 3.7396000, 'longitude' => 96.8340000], // KAB. ACEH BARAT DAYA
            1111 => ['latitude' => 5.2046000, 'longitude' => 96.7042000], // KAB. BIREUEN
            1101 => ['latitude' => 3.2573000, 'longitude' => 97.1812000], // KAB. ACEH SELATAN
            1117 => ['latitude' => 4.7230000, 'longitude' => 96.8480000], // KAB. BENER MERIAH
            1114 => ['latitude' => 4.7270000, 'longitude' => 95.6010000], // KAB. ACEH JAYA
            1104 => ['latitude' => 4.6289000, 'longitude' => 96.8364000], // KAB. ACEH TENGAH
            1172 => ['latitude' => 5.8906000, 'longitude' => 95.3197000], // KOTA SABANG
            1175 => ['latitude' => 2.6420000, 'longitude' => 98.0010000], // KOTA SUBULUSSALAM
            1174 => ['latitude' => 4.4683000, 'longitude' => 97.9683000], // KOTA LANGSA
            1271 => ['latitude' => 3.5952000, 'longitude' => 98.6722000], // KOTA MEDAN
            1103 => ['latitude' => 4.9875000, 'longitude' => 97.7833000], // KAB. ACEH TIMUR
            1109 => ['latitude' => 2.4800000, 'longitude' => 96.3800000], // KAB. SIMEULUE
            1113 => ['latitude' => 3.9940000, 'longitude' => 97.3690000], // KAB. GAYO LUES
            3201 => ['latitude' => -6.4852000, 'longitude' => 106.8540000], // KAB. BOGOR
            1110 => ['latitude' => 2.2894000, 'longitude' => 97.7889000], // KAB. ACEH SINGKIL
            3204 => ['latitude' => -7.0253000, 'longitude' => 107.5182000], // KAB. BANDUNG
            1118 => ['latitude' => 5.2487000, 'longitude' => 96.2672000], // KAB. PIDIE JAYA
            3174 => ['latitude' => -6.2615000, 'longitude' => 106.8106000], // KOTA ADM JAKARTA SELATAN
            3404 => ['latitude' => -7.7167000, 'longitude' => 110.3556000], // KAB. SLEMAN
            1471 => ['latitude' => 0.5333000, 'longitude' => 101.4500000], // KOTA PEKANBARU
            3578 => ['latitude' => -7.2575000, 'longitude' => 112.7521000], // KOTA SURABAYA
            3171 => ['latitude' => -6.1865000, 'longitude' => 106.8341000], // KOTA ADM JAKARTA PUSAT
            1102 => ['latitude' => 3.4703000, 'longitude' => 97.9405000], // KAB. ACEH TENGGARA
            1671 => ['latitude' => -2.9909000, 'longitude' => 104.7566000], // KOTA PALEMBANG
            3173 => ['latitude' => -6.1683000, 'longitude' => 106.7588000], // KOTA ADM JAKARTA BARAT
            3216 => ['latitude' => -6.3211000, 'longitude' => 107.1713000], // KAB. BEKASI
            3217 => ['latitude' => -6.8428000, 'longitude' => 107.5000000], // KAB. BANDUNG BARAT
            3203 => ['latitude' => -6.8173000, 'longitude' => 107.1420000], // KAB. CIANJUR
            1205 => ['latitude' => 3.7366000, 'longitude' => 98.4505000], // KAB. LANGKAT
            3273 => ['latitude' => -6.9175000, 'longitude' => 107.6191000], // KOTA BANDUNG
            5301 => ['latitude' => -10.1812000, 'longitude' => 123.6677000], // KAB. KUPANG
        ];

        foreach ($coordinates as $kodeKabupaten => $coordinate) {
            DB::table('tbl_kabupaten')
                ->where('kode_kabupaten', $kodeKabupaten)
                ->update([
                    'latitude' => $coordinate['latitude'],
                    'longitude' => $coordinate['longitude'],
                ]);
        }
    }
}
