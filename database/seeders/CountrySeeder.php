<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Country::create([
            'name_en' => 'Egypt',
            'name_ar' => 'مصر',
            'country_code' => 'EG',
            'phone_code' => '+20'
        ]);
        Country::create([
            'name_en' => 'Saudi Arabia',
            'name_ar' => 'السعودية',
            'country_code' => 'SA',
            'phone_code' => '+966'
        ]);
        $egypt_cities = [
            [
                "name_ar" => "القاهرة",
                "name_en" => "Cairo",
                "country_id" => 1
            ],
            [
                "name_ar" => "الجيزة",
                "name_en" => "Giza",
                "country_id" => 1
            ],
            [
                "name_ar" => "الأسكندرية",
                "name_en" => "Alexandria",
                "country_id" => 1
            ],
            [
                "name_ar" => "الدقهلية",
                "name_en" => "Dakahlia",
                "country_id" => 1
            ],
            [
                "name_ar" => "البحر الأحمر",
                "name_en" => "Red Sea",
                "country_id" => 1
            ],
            [
                "name_ar" => "البحيرة",
                "name_en" => "Beheira",
                "country_id" => 1
            ],
            [
                "name_ar" => "الفيوم",
                "name_en" => "Fayoum",
                "country_id" => 1
            ],
            [
                "name_ar" => "الغربية",
                "name_en" => "Gharbiya",
                "country_id" => 1
            ],
            [
                "name_ar" => "الإسماعلية",
                "name_en" => "Ismailia",
                "country_id" => 1
            ],
            [
                "name_ar" => "المنوفية",
                "name_en" => "Menofia",
                "country_id" => 1
            ],
            [
                "name_ar" => "المنيا",
                "name_en" => "Minya",
                "country_id" => 1
            ],
            [
                "name_ar" => "القليوبية",
                "name_en" => "Qaliubiya",
                "country_id" => 1
            ],
            [
                "name_ar" => "الوادي الجديد",
                "name_en" => "New Valley",
                "country_id" => 1
            ],
            [
                "name_ar" => "السويس",
                "name_en" => "Suez",
                "country_id" => 1
            ],
            [
                "name_ar" => "اسوان",
                "name_en" => "Aswan",
                "country_id" => 1
            ],
            [
                "name_ar" => "اسيوط",
                "name_en" => "Assiut",
                "country_id" => 1
            ],
            [
                "name_ar" => "بني سويف",
                "name_en" => "Beni Suef",
                "country_id" => 1
            ],
            [
                "name_ar" => "بورسعيد",
                "name_en" => "Port Said",
                "country_id" => 1
            ],
            [
                "name_ar" => "دمياط",
                "name_en" => "Damietta",
                "country_id" => 1
            ],
            [
                "name_ar" => "الشرقية",
                "name_en" => "Sharkia",
                "country_id" => 1
            ],
            [
                "name_ar" => "جنوب سيناء",
                "name_en" => "South Sinai",
                "country_id" => 1
            ],
            [
                "name_ar" => "كفر الشيخ",
                "name_en" => "Kafr Al sheikh",
                "country_id" => 1
            ],
            [
                "name_ar" => "مطروح",
                "name_en" => "Matrouh",
                "country_id" => 1
            ],
            [
                "name_ar" => "الأقصر",
                "name_en" => "Luxor",
                "country_id" => 1
            ],
            [
                "name_ar" => "قنا",
                "name_en" => "Qena",
                "country_id" => 1
            ],
            [
                "name_ar" => "شمال سيناء",
                "name_en" => "North Sinai",
                "country_id" => 1
            ],
            [
                "name_ar" => "سوهاج",
                "name_en" => "Sohag",
                "country_id" => 1
            ]
        ];
        City::insert($egypt_cities);

        $saudi_arabia_cites = [
            [
                "name_ar" => "تبوك",
                "name_en" => "Tabuk",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الرياض",
                "name_en" => "Riyadh",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الطائف",
                "name_en" => "At Taif",
                "country_id" => "2"
            ],
            [
                "name_ar" => "مكة المكرمة",
                "name_en" => "Makkah Al Mukarramah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "حائل",
                "name_en" => "Hail",
                "country_id" => "2"
            ],
            [
                "name_ar" => "بريدة",
                "name_en" => "Buraydah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الهفوف",
                "name_en" => "Al Hufuf",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الدمام",
                "name_en" => "Ad Dammam",
                "country_id" => "2"
            ],
            [
                "name_ar" => "المدينة المنورة",
                "name_en" => "Al Madinah Al Munawwarah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ابها",
                "name_en" => "Abha",
                "country_id" => "2"
            ],
            [
                "name_ar" => "جازان",
                "name_en" => "Jazan",
                "country_id" => "2"
            ],
            [
                "name_ar" => "جدة",
                "name_en" => "Jeddah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "المجمعة",
                "name_en" => "Al Majmaah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الخبر",
                "name_en" => "Al Khubar",
                "country_id" => "2"
            ],
            [
                "name_ar" => "حفر الباطن",
                "name_en" => "Hafar Al Batin",
                "country_id" => "2"
            ],
            [
                "name_ar" => "خميس مشيط",
                "name_en" => "Khamis Mushayt",
                "country_id" => "2"
            ],
            [
                "name_ar" => "احد رفيده",
                "name_en" => "Ahad Rifaydah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "القطيف",
                "name_en" => "Al Qatif",
                "country_id" => "2"
            ],
            [
                "name_ar" => "عنيزة",
                "name_en" => "Unayzah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "قرية العليا",
                "name_en" => "Qaryat Al Ulya",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الجبيل",
                "name_en" => "Al Jubail",
                "country_id" => "2"
            ],
            [
                "name_ar" => "النعيرية",
                "name_en" => "An Nuayriyah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الظهران",
                "name_en" => "Dhahran",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الوجه",
                "name_en" => "Al Wajh",
                "country_id" => "2"
            ],
            [
                "name_ar" => "بقيق",
                "name_en" => "Buqayq",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الزلفي",
                "name_en" => "Az Zulfi",
                "country_id" => "2"
            ],
            [
                "name_ar" => "خيبر",
                "name_en" => "Khaybar",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الغاط",
                "name_en" => "Al Ghat",
                "country_id" => "2"
            ],
            [
                "name_ar" => "املج",
                "name_en" => "Umluj",
                "country_id" => "2"
            ],
            [
                "name_ar" => "رابغ",
                "name_en" => "Rabigh",
                "country_id" => "2"
            ],
            [
                "name_ar" => "عفيف",
                "name_en" => "Afif",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ثادق",
                "name_en" => "Thadiq",
                "country_id" => "2"
            ],
            [
                "name_ar" => "سيهات",
                "name_en" => "Sayhat",
                "country_id" => "2"
            ],
            [
                "name_ar" => "تاروت",
                "name_en" => "Tarut",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ينبع",
                "name_en" => "Yanbu",
                "country_id" => "2"
            ],
            [
                "name_ar" => "شقراء",
                "name_en" => "Shaqra",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الدوادمي",
                "name_en" => "Ad Duwadimi",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الدرعية",
                "name_en" => "Ad Diriyah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "القويعية",
                "name_en" => "Quwayiyah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "المزاحمية",
                "name_en" => "Al Muzahimiyah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "بدر",
                "name_en" => "Badr",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الخرج",
                "name_en" => "Al Kharj",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الدلم",
                "name_en" => "Ad Dilam",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الشنان",
                "name_en" => "Ash Shinan",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الخرمة",
                "name_en" => "Al Khurmah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الجموم",
                "name_en" => "Al Jumum",
                "country_id" => "2"
            ],
            [
                "name_ar" => "المجاردة",
                "name_en" => "Al Majardah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "السليل",
                "name_en" => "As Sulayyil",
                "country_id" => "2"
            ],
            [
                "name_ar" => "تثليث",
                "name_en" => "Tathilith",
                "country_id" => "2"
            ],
            [
                "name_ar" => "بيشة",
                "name_en" => "Bishah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الباحة",
                "name_en" => "Al Baha",
                "country_id" => "2"
            ],
            [
                "name_ar" => "القنفذة",
                "name_en" => "Al Qunfidhah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "محايل",
                "name_en" => "Muhayil",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ثول",
                "name_en" => "Thuwal",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ضبا",
                "name_en" => "Duba",
                "country_id" => "2"
            ],
            [
                "name_ar" => "تربه",
                "name_en" => "Turbah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "صفوى",
                "name_en" => "Safwa",
                "country_id" => "2"
            ],
            [
                "name_ar" => "عنك",
                "name_en" => "Inak",
                "country_id" => "2"
            ],
            [
                "name_ar" => "طريف",
                "name_en" => "Turaif",
                "country_id" => "2"
            ],
            [
                "name_ar" => "عرعر",
                "name_en" => "Arar",
                "country_id" => "2"
            ],
            [
                "name_ar" => "القريات",
                "name_en" => "Al Qurayyat",
                "country_id" => "2"
            ],
            [
                "name_ar" => "سكاكا",
                "name_en" => "Sakaka",
                "country_id" => "2"
            ],
            [
                "name_ar" => "رفحاء",
                "name_en" => "Rafha",
                "country_id" => "2"
            ],
            [
                "name_ar" => "دومة الجندل",
                "name_en" => "Dawmat Al Jandal",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الرس",
                "name_en" => "Ar Rass",
                "country_id" => "2"
            ],
            [
                "name_ar" => "المذنب",
                "name_en" => "Al Midhnab",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الخفجي",
                "name_en" => "Al Khafji",
                "country_id" => "2"
            ],
            [
                "name_ar" => "رياض الخبراء",
                "name_en" => "Riyad Al Khabra",
                "country_id" => "2"
            ],
            [
                "name_ar" => "البدائع",
                "name_en" => "Al Badai",
                "country_id" => "2"
            ],
            [
                "name_ar" => "رأس تنورة",
                "name_en" => "Ras Tannurah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "البكيرية",
                "name_en" => "Al Bukayriyah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الشماسية",
                "name_en" => "Ash Shimasiyah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "الحريق",
                "name_en" => "Al Hariq",
                "country_id" => "2"
            ],
            [
                "name_ar" => "حوطة بني تميم",
                "name_en" => "Hawtat Bani Tamim",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ليلى",
                "name_en" => "Layla",
                "country_id" => "2"
            ],
            [
                "name_ar" => "بللسمر",
                "name_en" => "Billasmar",
                "country_id" => "2"
            ],
            [
                "name_ar" => "شرورة",
                "name_en" => "Sharurah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "نجران",
                "name_en" => "Najran",
                "country_id" => "2"
            ],
            [
                "name_ar" => "صبيا",
                "name_en" => "Sabya",
                "country_id" => "2"
            ],
            [
                "name_ar" => "ابو عريش",
                "name_en" => "Abu Arish",
                "country_id" => "2"
            ],
            [
                "name_ar" => "صامطة",
                "name_en" => "Samtah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "احد المسارحة",
                "name_en" => "Ahad Al Musarihah",
                "country_id" => "2"
            ],
            [
                "name_ar" => "مدينة الملك عبدالله الاقتصادية",
                "name_en" => "King Abdullah Economic City",
                "country_id" => "2"
            ]
        ];
        City::insert($saudi_arabia_cites);
    }
}
