<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'site_title'         => 'Pustaka Riyadz',
            'site_url'           => 'https://pustakariyadz.com',
            'site_logo'          => 'logo.png',
            'site_favicon'       => 'favicon.png',

            'whatsapp'           => '81234567890',
            'email'              => 'halo@riyadzaqsha.com',
            'instagram'          => 'https://instagram.com/riyadzaqsha',
            'linkedin'           => 'https://linkedin.com/in/riyadzaqsha',

            'meta_title'         => 'Pustaka Riyadz | Penerbit Buku Berkualitas & Inspiratif',
            'meta_description'   => 'Pustaka Riyadz adalah penerbit buku yang berdedikasi menghadirkan karya literasi berkualitas, mulai dari buku agama, pendidikan, hingga inspirasi umum. Kami membantu penulis mewujudkan naskah impian menjadi karya yang bermanfaat bagi umat.',
            'meta_keywords'      => 'Pustaka Riyadz, penerbit buku, jasa penerbitan naskah, cetak buku, toko buku online, literasi islami, penulis buku, naskah inspiratif, penerbit berkualitas',

            'og_title'           => 'Pustaka Riyadz - Mewujudkan Karya, Menebar Inspirasi',
            'og_description'     => 'Temukan koleksi buku terbaik dan layanan penerbitan profesional di Pustaka Riyadz. Kami percaya setiap kata adalah jembatan ilmu dan amal jariah.',
            'og_image'           => 'og-image-pustaka.jpg',

            'api_tinymce_key'    => 'x9rlvoood10xkxwd58t9wmyo3dns64y134pe5u7we2v6cq61',
        ]);
    }
}
