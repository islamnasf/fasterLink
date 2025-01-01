<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('elements')->insert([
            // عناصر العلامة التجارية
            [
                'name_en' => 'Brand Information (Name, Logo, Category, Country)',
                'name_ar' => 'بيانات العلامة التجارية (الاسم - الشعار - الفئة - البلد)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Branches (Single or Multiple)',
                'name_ar' => 'الفروع (فرع واحد / أكثر من فرع)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Branch Contact Information (Phone, WhatsApp, Address, Location, Working Hours)',
                'name_ar' => 'بيانات التواصل لكل فرع على حدا (أرقام الاتصال والواتساب - العنوان والموقع - مواعيد العمل)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Electronic Menu (Menu/Catalog/Services, Max 100 Items)',
                'name_ar' => 'القائمة الإلكترونية (منيو / كتالوج / خدمات) : أقسام وأصناف (بحد أقصى 100 صنف)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Discounts on Prices (Available)',
                'name_ar' => 'الخصومات على الأسعار (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Sections and Items Order by Priority',
                'name_ar' => 'ترتيب الأقسام والأصناف حسب أولوية ظهورها للمتصفح',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Unlimited Links Creation and Management',
                'name_ar' => 'الروابط : إضافة وإنشاء روابط (غير محدود)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Promotional Offers (Duration Can Be Set)',
                'name_ar' => 'العروض الترويجية (متاح) مع إمكانية تحديد مدة صلاحية العرض',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Customer Reviews and Feedback (Hide Comments Option)',
                'name_ar' => 'تقييمات العملاء وإبداء آرائهم (متاح) مع إمكانية إخفاء التعليقات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Messaging: Receiving Suggestions and Complaints',
                'name_ar' => 'المراسلة: استقبال مقترحات وشكاوى العملاء (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'FasterLink Sharing and Copying',
                'name_ar' => 'مشاركة رابط فاستر لينك (متاح) المشاركة والنسخ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'QR Code Customization (Sharing and Download)',
                'name_ar' => 'تخصيص رمز الوصول السريع QRcode (متاح) مشاركة وتنزيل',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'NFC Integration',
                'name_ar' => 'إمكانية الربط مع خاصية NFC (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Simple and Easy Dashboard (Add, Edit, Delete, Activate, Deactivate)',
                'name_ar' => 'لوحة تحكم سهلة وبسيطة (إضافة - تعديل - حذف - تشغيل - إيقاف)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Visual Identity Color Selection',
                'name_ar' => 'اختيار لون الهوية البصرية (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Multilingual Support (Arabic, English)',
                'name_ar' => 'لغات متعددة (عربية - إنجليزية)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Day and Night Modes',
                'name_ar' => 'الوضع النهاري والليلي (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Mobile Application (Download Without App Stores)',
                'name_ar' => 'تطبيق الموبايل (متاح) مع إمكانية تحميل وتثبيت التطبيق على جوال العميل بدون الدخول إلى متاجر التطبيقات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Social Media Integration',
                'name_ar' => 'الربط مع منصات التواصل المختلفة (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Save Brand Phone Number to Client’s Device',
                'name_ar' => 'حفظ رقم هاتف العلامة التجارية على جوال العميل (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Client Activity Statistics (Views, App Downloads, Phone Saves, QR Downloads)',
                'name_ar' => 'إحصائيات نشاطات وتفاعلات العملاء (المشاهدات - تحميل التطبيق - حفظ رقم الهاتف - تنزيل رمز الوصول السريع)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'SEO Optimization',
                'name_ar' => 'تحسين ظهورك على محركات البحث (SEO)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Add Faster Effect Button (Flashing Effect on Main Screens)',
                'name_ar' => 'إضافة زر ايفيكت فاستر (به وميض، على الشاشات الرئيسية)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Add Welcome Message (Image + Text + Link)',
                'name_ar' => 'إضافة الرسالة الافتتاحية (صورة + نص + رابط)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Add Moving Advertisement Banner (Top of Main Screen)',
                'name_ar' => 'إضافة شريط الإعلانات المتحرك (أعلى الشاشة الرئيسية)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Change Main Screen Background (Animated Image)',
                'name_ar' => 'تغيير خلفية الشاشة الرئيسية (صورة متحركة)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Display Link Click Statistics',
                'name_ar' => 'عرض إحصائيات بعدد الضغطات على الروابط (متاح)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
