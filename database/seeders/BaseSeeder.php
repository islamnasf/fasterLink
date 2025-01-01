<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\LinkLibrary;
use App\Models\LinkType;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        LinkType::insert(
            [['name_en' => 'Our Links', 'name_ar' => 'روابطنا'], ['name_en' => 'Evaluation Links', 'name_ar' => 'روابط التقييم'], ['name_en' => 'Social Links', 'name_ar' => 'روابط السوشيال'], ['name_en' => 'Group Links', 'name_ar' => 'روابط المجموعات'], ['name_en' => 'Important Links for Our Activity', 'name_ar' => 'روابط هامة لنشاطنا'], ['name_en' => 'Payment Methods Links', 'name_ar' => 'روابط وسائل الدفع'], ['name_en' => 'Our Clients\' Links', 'name_ar' => 'روابط عملاؤنا'], ['name_en' => 'Miscellaneous Links', 'name_ar' => 'روابط منوعة']]
        );
        LinkLibrary::insert(
            [['name_en' => 'Facebook', 'name_ar' => 'فيس بوك'], ['name_en' => 'Instagram', 'name_ar' => 'إنستغرام'], ['name_en' => 'TikTok', 'name_ar' => 'تيك توك'], ['name_en' => 'YouTube', 'name_ar' => 'يوتيوب'], ['name_en' => 'X (formerly Twitter)', 'name_ar' => 'أكس'], ['name_en' => 'Pinterest', 'name_ar' => 'بنترست'], ['name_en' => 'Vimeo', 'name_ar' => 'فيميو'], ['name_en' => 'Google', 'name_ar' => 'جوجل']]
        );
    }
}
