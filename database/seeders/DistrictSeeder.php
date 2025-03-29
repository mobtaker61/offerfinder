<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DistrictSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        $districts = [
            ['id' => 1,'name' => 'Deira','local_name' => 'دیره','emirate_id' => 3,'latitude' => 25.2743,'longitude' => 55.3097,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 2,'name' => 'Mushrif','local_name' => 'مشرف','emirate_id' => 3,'latitude' => 24.4539,'longitude' => 54.3773,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 3,'name' => 'Bur Dubai','local_name' => 'بر دوبی','emirate_id' => 3,'latitude' => 25.2532,'longitude' => 55.2867,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 4,'name' => 'Ras Al Khor','local_name' => 'راس الخور','emirate_id' => 3,'latitude' => 25.1852,'longitude' => 55.3738,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 5,'name' => 'Jabal Ali','local_name' => 'جبل علی','emirate_id' => 3,'latitude' => 24.9857,'longitude' => 55.0096,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 6,'name' => 'Hadaeq Sheikh Mohammed Bin Rashid','local_name' => 'حدایق شیخ محمد بن راشید','emirate_id' => 3,'latitude' => 25.2188,'longitude' => 55.3698,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 7,'name' => 'Al Awir','local_name' => 'العویر','emirate_id' => 3,'latitude' => 25.1757,'longitude' => 55.4826,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 8,'name' => 'Hatta','local_name' => 'حتا','emirate_id' => 3,'latitude' => 24.7914,'longitude' => 56.1339,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 9,'name' => 'Al Marmoom','local_name' => 'المارون','emirate_id' => 3,'latitude' => 24.8175,'longitude' => 55.3527,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 10,'name' => 'Abu Dhabi Central','local_name' => 'أبوظبي المركزية','emirate_id' => 1,'latitude' => 24.4539,'longitude' => 54.3773,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 11,'name' => 'Al Dhafra','local_name' => 'الظفرة','emirate_id' => 1,'latitude' => 23.65,'longitude' => 53.7,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 12,'name' => 'Al-Ain','local_name' => 'العين','emirate_id' => 1,'latitude' => 24.2075,'longitude' => 55.7447,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 13,'name' => 'Sharjah','local_name' => 'الشارقة','emirate_id' => 6,'latitude' => 25.3463,'longitude' => 55.4209,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 14,'name' => 'Al Hamriyah','local_name' => 'الحمرية','emirate_id' => 6,'latitude' => 25.47,'longitude' => 55.525,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 15,'name' => 'Al Bataeh','local_name' => 'البطائح','emirate_id' => 6,'latitude' => 25.2139,'longitude' => 55.6189,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 16,'name' => 'Al Madam','local_name' => 'المدام','emirate_id' => 6,'latitude' => 24.9812,'longitude' => 55.7805,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 17,'name' => 'Mleiha','local_name' => 'مليحة','emirate_id' => 6,'latitude' => 25.1406,'longitude' => 55.8439,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 18,'name' => 'Dhaid','local_name' => 'الذيد','emirate_id' => 6,'latitude' => 25.2885,'longitude' => 55.8818,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 19,'name' => 'Kalba','local_name' => 'كلباء','emirate_id' => 6,'latitude' => 25.0657,'longitude' => 56.3572,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 20,'name' => 'Khor Fakkan','local_name' => 'خورفكان','emirate_id' => 6,'latitude' => 25.3454,'longitude' => 56.3629,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 21,'name' => 'Dibba Al-Hisn','local_name' => 'دبا الحصن','emirate_id' => 6,'latitude' => 25.6199,'longitude' => 56.2725,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 22,'name' => 'Ajman','local_name' => 'عجمان','emirate_id' => 2,'latitude' => 25.4052,'longitude' => 55.5136,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 23,'name' => 'Manama','local_name' => 'المنامة','emirate_id' => 2,'latitude' => 25.3869,'longitude' => 56.0371,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 24,'name' => 'Masfout','local_name' => 'مصفوت','emirate_id' => 2,'latitude' => 24.8189,'longitude' => 56.0572,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 25,'name' => 'Ras Al Khaimah City','local_name' => 'رأس الخيمة','emirate_id' => 5,'latitude' => 25.8007,'longitude' => 55.9762,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 26,'name' => 'Al Jazirah Al Hamra','local_name' => 'الجزيرة الحمراء','emirate_id' => 5,'latitude' => 25.6719,'longitude' => 55.7586,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 27,'name' => 'Rams','local_name' => 'رمس','emirate_id' => 5,'latitude' => 25.9068,'longitude' => 56.0467,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 28,'name' => 'Khor Khwair','local_name' => 'خور خوير','emirate_id' => 5,'latitude' => 25.9835,'longitude' => 56.0554,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 29,'name' => 'Digdagah','local_name' => 'دقداقة','emirate_id' => 5,'latitude' => 25.6019,'longitude' => 55.8913,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 30,'name' => 'Khatt','local_name' => 'خت','emirate_id' => 5,'latitude' => 25.7133,'longitude' => 56.0562,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 31,'name' => 'Masafi','local_name' => 'مسافي','emirate_id' => 5,'latitude' => 25.3147,'longitude' => 56.1649,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 32,'name' => 'Huwaylat','local_name' => 'حويلات','emirate_id' => 5,'latitude' => 25.8327,'longitude' => 56.0359,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 33,'name' => "Sha'am",'local_name' => 'شعم','emirate_id' => 5,'latitude' => 26.049,'longitude' => 56.058,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 34,'name' => 'Fujairah','local_name' => 'الفجيرة','emirate_id' => 4,'latitude' => 25.4111,'longitude' => 56.2482,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 35,'name' => 'Umm Al Quwain','local_name' => 'أم القيوين','emirate_id' => 7,'latitude' => 25.5869,'longitude' => 55.5763,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 36,'name' => 'Falaj Al Mualla','local_name' => 'فلج المعلا','emirate_id' => 7,'latitude' => 25.3214,'longitude' => 55.8812,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 37,'name' => 'Siniyah Island','local_name' => 'جزيرة الصنية','emirate_id' => 7,'latitude' => 25.593,'longitude' => 55.588,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 38,'name' => 'Al Rafaah','local_name' => 'الرفاعة','emirate_id' => 7,'latitude' => 25.502,'longitude' => 55.644,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 39,'name' => 'Al Salamah','local_name' => 'السلمة','emirate_id' => 7,'latitude' => 25.518,'longitude' => 55.635,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 40,'name' => 'Al Darer','local_name' => 'الدرر','emirate_id' => 7,'latitude' => 25.512,'longitude' => 55.63,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 41,'name' => 'Al Suehat','local_name' => 'السويحات','emirate_id' => 7,'latitude' => 25.52,'longitude' => 55.61,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 42,'name' => 'Tell Abraq','local_name' => 'تل أبرق','emirate_id' => 7,'latitude' => 25.494,'longitude' => 55.654,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 43,'name' => 'Ramla','local_name' => 'رملة','emirate_id' => 7,'latitude' => 25.5,'longitude' => 55.64,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 44,'name' => 'Labsh','local_name' => 'اللبسة','emirate_id' => 7,'latitude' => 25.509,'longitude' => 55.62,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 45,'name' => 'Al Rashidiya','local_name' => 'الرشيدية','emirate_id' => 7,'latitude' => 25.525,'longitude' => 55.615,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 46,'name' => 'Biyatah','local_name' => 'بياتة','emirate_id' => 7,'latitude' => 25.53,'longitude' => 55.61,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 47,'name' => 'Al Atheab','local_name' => 'الذيب','emirate_id' => 7,'latitude' => 25.536,'longitude' => 55.603,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 48,'name' => 'Khor Al Beidah','local_name' => 'خور البيضا','emirate_id' => 7,'latitude' => 25.548,'longitude' => 55.599,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 49,'name' => 'Al Serra','local_name' => 'الصرة','emirate_id' => 7,'latitude' => 25.543,'longitude' => 55.605,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 50,'name' => 'Mohadub','local_name' => 'محضب','emirate_id' => 7,'latitude' => 25.54,'longitude' => 55.62,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 51,'name' => 'Kabir','local_name' => 'كابر','emirate_id' => 7,'latitude' => 25.545,'longitude' => 55.626,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 52,'name' => 'Jazirat Al Aki\'ab','local_name' => 'جزيرة الأكياب','emirate_id' => 7,'latitude' => 25.552,'longitude' => 55.595,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
            ['id' => 53,'name' => 'Jazirat al Ghallah','local_name' => 'جزيرة الغلة','emirate_id' => 7,'latitude' => 25.547,'longitude' => 55.597,'is_active' => 1,'created_at' => $now,'updated_at' => $now],
        ];

        foreach ($districts as $district) {
            District::updateOrCreate(
                [
                    'id' => $district['id']
                ],
                $district
            );
        }
    }
} 