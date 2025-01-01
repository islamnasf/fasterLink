<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Http\Shared\FileType;
use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Network
        Feature::create([
            'id' => 1,
            'name_en' => 'Network',
            'name_ar' => 'الشبكة',
            'description_ar' => "شبكة العلامات التجارية داخل فاستر لينك  تجمع أفضل المحلات والعلامات التجارية ، المتنوعة والمختلفة للإعلان عن بعضهم البعض أنشطة تجارية مجالاتها مختلفة . لا يوجد بينها منافسة ولا تعارض . إذا هدفها واحد ومصلحتها مشتركة الآلية التي تعد الآن هي الأكثر ذكائا والأكثر تطورا وانتشارا من بين آليات وطرق التسويق والدعاية المتنوعة في العالم ، تتلخص في تلك العبارة : ( أرحب بالإعلان عنك وعن عروضك  ... ويسعدني أن تعلن عني وعن عروضي ) وتطبيقها باختصار شديد قائم على أنه لا مانع من أن أسمح لعملائي بأن يتعرفوا على علامتك التجارية ويستفيدوا من العروض الترويجية التي تقدمها ، شرط أن تسمح أنت كذلك لعملائك بأن يتعرفوا على علامتي التجارية ويستفيدوا من عروضي الترويجية التي أقدمها . لقد حققنا لك تلك المعادلة الصعبة بانضمامك إلى شبكة العلامات التجارية داخل فاستر لينك ، بحيث تستطيع الآن أن تعلن عن علامتك التجارية وتزيد من شهرتها وتميزها ، بطريقة سهلة وأسرع انتشارا وأكثر تطورا ، وأقل تكلفة . حيث ابتكرنا بفضل الله تعالى وصممنا لك النظام الرقمي الذكي الذي يحقق ذلك ، من خلال إنشاء وتكوين شبكة العلامات التجارية ، والتي تضم بداخلها مجموعة من أفضل العلامات التجارية من مختلف المجالات والأنشطة التجارية العديدة والمتنوعة والتي لا يجمعها أي منافسة ولا يوجد تعارض بينها ، ولكن كلا منها يجتمع على هدف واحد وهو إظهار وتميز علامته التجارية . وهذه الشبكة سوف تمكنك بعد الانضمام إليها من الإعلان بداخلها عن علامتك التجارية وعرض منتجاتك أو خدماتك والإعلان عن العروض الترويجية التي تقدمها أنت وتقدمها باقي العلامات التجارية الأخرى المنضمة للشبكة ، وعرضها للعملاء والزبائن كوسيلة جذب لهم وتحفيزهم على الشراء والاستفادة بتلك العروض الترويجية المقدمة .  وبهذه الطريقة نكون قد حققنا لك انتشارا وتميزا لعلامتك التجارية بظهورها في كل شاشات الشبكة ليشاهدها ويطالعها الآلاف من العملاء والزبائن بشكل دائم طوال العام . مزايا الانضمام لشبكة العلامات التجارية تعريف علامتك التجارية لشرائح متعددة من الزبائن والعملاء التي لا تستطيع بمفردك الوصول إليها . توسيع دائرة عملائك وجذب عملاء جدد باستمرار . الارتقاء بعلامتك التجارية بشكل دائم والحفاظ على استمرارية ظهورها وعدم غيابها عن الأنظار . التفوق على منافسيك وتميزك بتطبيق الأفكار التسويقية الفريدة والمبتكرة والتي تلائم التطور التكنولوجي والتحول الرقمي الذي نشهده من حولنا .",
            'description_en' => "Brand Network Inside Faster Link Gathers the best shops and brands, diverse and different to advertise each other Commercial activities with different fields. There is no competition or conflict between them. If their goal is one and their interest is common The mechanism that is now the most intelligent, most developed and widespread among the various marketing and advertising mechanisms and methods in the world, is summarized in this phrase: (I welcome advertising for you and your offers ... I am happy for you to advertise for me and my offers) And its application in a very brief manner is based on the fact that there is no objection to allowing my customers to get to know your brand and benefit from the promotional offers that you provide, provided that you also allow your customers to get to know my brand and benefit from the promotional offers that I provide. We have achieved this difficult equation for you by joining the brand network within Faster Link, so that you can now advertise your brand and increase its fame and distinction, in an easy, faster, more developed and less expensive way. By the grace of God Almighty, we have created and designed for you the smart digital system that achieves this, by creating and forming a network of brands, which includes within it a group of the best brands from various fields and numerous and diverse commercial activities that do not have any competition or conflict between them, but each of them meets one goal, which is to show and distinguish its brand. This network will enable you, after joining it, to advertise your brand within it, display your products or services, and announce the promotional offers that you and the other brands that have joined the network provide, and display them to customers and clients as a means of attracting them and motivating them to buy and benefit from those promotional offers provided. In this way, we have achieved for you the spread and distinction of your brand by appearing on all network screens for thousands of customers and clients to see and view it permanently throughout the year. Advantages of joining the network of brands Defining your brand to multiple segments of customers and clients that you cannot reach alone. Expanding your customer circle and attracting new customers continuously. Constantly upgrading your brand and maintaining its continued presence and not disappearing from sight. Outperform your competitors and distinguish yourself by applying unique and innovative marketing ideas that suit the technological development and digital transformation that we are witnessing around us.",
            'file_type' => FileType::image,
            'price' => 500,
        ]);

        //Features
        Feature::create([
            'id' => 2,
            'name_en' => 'Authorized Agents',
            'name_ar' => 'الوكلاء المعتمدون',
            'description_en' => "If your business is specialized in the production or manufacturing process, and you have authorized agents in all cities or in specific cities, you can now add the data of each of your agents separately, such as phone, address and location, so that your customers can recognize them and reach the nearest agent to purchase your original products through reliable and authorized agents.",
            'description_ar' => "إذا كان نشاطك التجاري يختص بعملية الإنتاج أو التصنيع ، ولديك وكلاء معتمدين في جميع المدن أو في مدن محددة ، فتستطيع الآن أن تضيف بيانات كل وكيل من وكلائك على حدا ، مثل الهاتف والعنوان والموقع ، وذلك لكي يتعرف عليها عملائك ويتم الوصول إلى الوكيل الأقرب لشراء منتجاتك الأصلية عن طريق الوكلاء الموثوقين والمعتمدين .",
            'file_type' => FileType::image,
            'price' => 500,
        ]);
        Feature::create([
            'id' => 3,
            'name_en' => 'Shopping cart',
            'name_ar' => 'سلة المشتريات',
            'description_en' => "You can now market your products or services online by adding the (shopping cart) feature that turns your Faster Link into an online store. So that the visitor or customer can carry out the shopping process and choose and add the items that suit him and he needs to the shopping cart in the quantity he wants, indicated by the price, and then the order is sent via WhatsApp with ease to complete it.",
            'description_ar' => "يمكنك الآن تسويق منتجاتك أو خدماتك أونلاين من خلال إضافة ميزة ( سلة المشتريات ) التي تحول فاستر لينك الخاص بك إلى متجر الكتروني .بحيث يستطيع الزائر أو العميل إجراء عملية التسوق واختيار وإضافة الأصناف التي تناسبه ويحتاجها إلى سلة المشتريات بالكمية التي يرغبها موضحة بالسعر ، وبعد ذلك يتم إرسال الطلب عبر الواتساب بكل سهولة لإتمامه .",
            'file_type' => FileType::image,
            'price' => 500,
        ]);
        Feature::create([
            'id' => 4,
            'name_en' => 'verification mark',
            'name_ar' => 'علامة التوثيق',
            'description_en' => "Enhance your brand's credibility with the public by obtaining the credentials and badge, which gives it a better and distinctive appearance. Which increases your customers' confidence and trust in your brand even more.",
            'description_ar' => "عزز من وثائقية علامتك التجارية لدى الجمهور من خلال حصولها على علامة وشارة التوثيق ، التي تمنحها ظهور أفضل ومتميز .مما يزيد من اطمئنان وثقة عملائك في علامتك التجارية بشكل أكبر .",
            'file_type' => FileType::image,
            'price' => 500,
        ]);

        //NFC
        Feature::create([
            'id' => 5,
            'name_en' => 'NFC Acrylic Stand',
            'name_ar' => 'ستاند أكريلك NFC',
            'description_en' => "You definitely need an NFC stand made of strong acrylic, to put it on your desk, counter or on the tables where customers sit, with NFC feature and QR Code printed on it. Get it with a great and attractive design bearing your brand name and logo.",
            'description_ar' => "من المؤكد أنك تحتاج إلى ستاند NFC المصنوع من خامة الأكريلك القوية ، لكي تضعه على مكتبك أو علي كاونتر أو على الطاولات التي يجلس عليها العملاء ، به خاصية NFC ومطبوع عليه رمز الوصول السريع QR Code .احصل عليه بتصميم رائع وجذاب حاملا اسم وشعار علامتك التجارية.",
            'file_type' => FileType::image,
            'price' => 500,
        ]);
        Feature::create([
            'id' => 6,
            'name_en' => 'NFC roll up',
            'name_ar' => 'رول اب NFC',
            'description_en' => "You have a lounge or hall to receive customers, and many people visit it, and you want to decorate it with a roll-up with the NFC feature as a means of advertising and attracting customers, and to facilitate the access of those visitors to your data through NFC, or by scanning the QR Code printed on the roll-up. Get it with a wonderful and attractive design bearing the name and logo of your brand.",
            'description_ar' => "لديك صالة أو قاعة لاستقبال العملاء ، ويزورها العديد من الأشخاص ، وتريد أن تزينها بالرول اب ذو خاصية ال NFC كوسيلة دعايا وجذب للعملاء ، ولتسهيل وصول تلك الزوار إلى بياناتك من خلال ال NFC ، أو من خلال مسح رمز الوصول السريع QR Code المطبوع علي الرول اب احصل عليه بتصميم رائع وجذاب حاملا اسم وشعار علامتك التجارية.",
            'file_type' => FileType::image,
            'price' => 500,
        ]);
        Feature::create([
            'id' => 7,
            'name_en' => 'NFC card',
            'name_ar' => 'بطاقة NFC',
            'description_en' => "The NFC plastic card is easy to carry with you in your pocket or wallet, move it anywhere, and extract it at any time and in places of work gatherings or important meetings, so that your Faster Link data reaches through it to whoever approaches it with his mobile phone with the NFC feature, and also the QR Code is printed on it. Get it with a wonderful and attractive design bearing the name and logo of your brand.",
            'description_ar' => "بطاقة NFC البلاستيكية يسهل حملها معك في جيبك أو محفظتك ، والتنقل بها في أي مكان ، واستخراجها في أي وقت وفي أماكن تجمعات العمل  أو اللقاءات الهامة  ، لتصل بيانات فاستر لينك الخاص بك من خلالها إلى من يقترب منها بهاتفه المحمول بخاصية NFC ، وكذلك مطبوع عليها رمز الوصول السريع QR Code  .احصل عليها بتصميم رائع وجذاب حاملة اسم وشعار علامتك التجارية.",
            'file_type' => FileType::image,
            'price' => 500,
        ]);
    }
}
