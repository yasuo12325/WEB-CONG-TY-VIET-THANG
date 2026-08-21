<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'FARO', 'country' => 'Mỹ', 'country_en' => 'USA', 'specialty' => 'Thiết bị quét, dựng hiện trường 3D', 'specialty_en' => '3D scene scanning & reconstruction equipment'],
            ['name' => 'LLC Modus', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Thiết bị dò tìm ma túy, chất nổ, chất hóa học', 'specialty_en' => 'Narcotics, explosives and chemical detection equipment'],
            ['name' => 'Vision', 'country' => 'Hàn Quốc', 'country_en' => 'South Korea', 'specialty' => 'Camera giám sát an ninh', 'specialty_en' => 'Security surveillance cameras'],
            ['name' => 'Panasonic', 'country' => 'Nhật Bản', 'country_en' => 'Japan', 'specialty' => 'Camera giám sát an ninh', 'specialty_en' => 'Security surveillance cameras'],
            ['name' => 'Bosch', 'country' => 'Đức', 'country_en' => 'Germany', 'specialty' => 'Camera giám sát an ninh', 'specialty_en' => 'Security surveillance cameras'],
            ['name' => 'Axis', 'country' => 'Mỹ', 'country_en' => 'USA', 'specialty' => 'Camera giám sát an ninh', 'specialty_en' => 'Security surveillance cameras'],
            ['name' => 'Sens-Őr Solutions', 'country' => 'EU', 'country_en' => 'EU', 'specialty' => 'Hàng rào vô tuyến phát hiện xâm nhập (RF)', 'specialty_en' => 'RF perimeter intrusion detection systems'],
            ['name' => 'Nikon', 'country' => 'Nhật Bản', 'country_en' => 'Japan', 'specialty' => 'Kính hiển vi', 'specialty_en' => 'Microscopes'],
            ['name' => 'MEGARAY', 'country' => null, 'country_en' => null, 'specialty' => 'Đèn chiếu xa chống bạo loạn, giải tán đám đông', 'specialty_en' => 'Long-range anti-riot & crowd-dispersal illuminators'],
            ['name' => 'Astrophysics', 'country' => 'Mỹ', 'country_en' => 'USA', 'specialty' => 'Hệ thống máy soi chiếu, xe soi chiếu', 'specialty_en' => 'X-ray screening systems & mobile screening vehicles'],
            ['name' => 'Ceia', 'country' => 'Ý', 'country_en' => 'Italy', 'specialty' => 'Cổng từ an ninh', 'specialty_en' => 'Security walk-through metal detectors'],
            ['name' => 'TSNK', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Máy soi, cổng từ, thiết bị phát hiện chất nổ', 'specialty_en' => 'X-ray scanners, metal detectors & explosives detection equipment'],
            ['name' => 'Speech Technology Center', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Nhận dạng khuôn mặt, sinh trắc học âm thanh', 'specialty_en' => 'Facial recognition & voice biometrics'],
            ['name' => 'Polimaster', 'country' => 'Belarus', 'country_en' => 'Belarus', 'specialty' => 'Thiết bị phát hiện chất phóng xạ, chất độc', 'specialty_en' => 'Radiation & toxic chemical detection equipment'],
            ['name' => 'Phantom', 'country' => 'Israel', 'country_en' => 'Israel', 'specialty' => 'Máy phá sóng', 'specialty_en' => 'Signal jammers'],
            ['name' => 'Lavanda-U', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Thiết bị dò tìm chất nổ', 'specialty_en' => 'Explosives detection equipment'],
            ['name' => 'AVK', 'country' => null, 'country_en' => null, 'specialty' => 'Thiết bị phát hiện chất nổ lỏng (LQ test)', 'specialty_en' => 'Liquid explosives detection equipment (LQ test)'],
            ['name' => 'Cellebrite', 'country' => null, 'country_en' => null, 'specialty' => 'Phân tích, điều tra kỹ thuật số & di động', 'specialty_en' => 'Digital & mobile forensic analysis'],
            ['name' => 'Rigma', 'country' => 'Litva', 'country_en' => 'Lithuania', 'specialty' => 'Hệ thống viễn thông đặc biệt', 'specialty_en' => 'Specialized telecommunications systems'],
            ['name' => 'Telesystems', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Máy ghi âm chuyên dụng siêu nhỏ', 'specialty_en' => 'Ultra-miniature specialized voice recorders'],
            ['name' => 'Nelk / Evraas', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Thiết bị chống ghi âm, phát hiện thiết bị nghe lén', 'specialty_en' => 'Anti-recording & eavesdropping-device detection equipment'],
            ['name' => 'Dors', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Thiết bị kiểm tra tiền, giấy tờ, hồ sơ', 'specialty_en' => 'Currency, document and paper authentication equipment'],
            ['name' => 'Set-1', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Thiết bị ghi, thu phát tiếng/hình chuyên dụng', 'specialty_en' => 'Specialized audio/video recording & transceiver equipment'],
            ['name' => 'Universal System', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Ống nhòm, ống kính hồng ngoại', 'specialty_en' => 'Binoculars & infrared optics'],
            ['name' => 'METREL', 'country' => 'Slovenia', 'country_en' => 'Slovenia', 'specialty' => 'Hệ thống đo và phân tích môi trường', 'specialty_en' => 'Environmental measurement & analysis systems'],
            ['name' => 'ELECTROL STANDARD', 'country' => 'Nga', 'country_en' => 'Russia', 'specialty' => 'Hệ thống đo và phân tích môi trường', 'specialty_en' => 'Environmental measurement & analysis systems'],
        ];

        foreach ($partners as $index => $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                [
                    'country' => $partner['country'],
                    'country_en' => $partner['country_en'],
                    'specialty' => $partner['specialty'],
                    'specialty_en' => $partner['specialty_en'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
