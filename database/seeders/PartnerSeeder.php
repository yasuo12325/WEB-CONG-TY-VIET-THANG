<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['name' => 'FARO', 'country' => 'Mỹ', 'specialty' => 'Thiết bị quét, dựng hiện trường 3D'],
            ['name' => 'LLC Modus', 'country' => 'Nga', 'specialty' => 'Thiết bị dò tìm ma túy, chất nổ, chất hóa học'],
            ['name' => 'Vision', 'country' => 'Hàn Quốc', 'specialty' => 'Camera giám sát an ninh'],
            ['name' => 'Panasonic', 'country' => 'Nhật Bản', 'specialty' => 'Camera giám sát an ninh'],
            ['name' => 'Bosch', 'country' => 'Đức', 'specialty' => 'Camera giám sát an ninh'],
            ['name' => 'Axis', 'country' => 'Mỹ', 'specialty' => 'Camera giám sát an ninh'],
            ['name' => 'Sens-Őr Solutions', 'country' => 'EU', 'specialty' => 'Hàng rào vô tuyến phát hiện xâm nhập (RF)'],
            ['name' => 'Nikon', 'country' => 'Nhật Bản', 'specialty' => 'Kính hiển vi'],
            ['name' => 'MEGARAY', 'country' => null, 'specialty' => 'Đèn chiếu xa chống bạo loạn, giải tán đám đông'],
            ['name' => 'Astrophysics', 'country' => 'Mỹ', 'specialty' => 'Hệ thống máy soi chiếu, xe soi chiếu'],
            ['name' => 'Ceia', 'country' => 'Ý', 'specialty' => 'Cổng từ an ninh'],
            ['name' => 'TSNK', 'country' => 'Nga', 'specialty' => 'Máy soi, cổng từ, thiết bị phát hiện chất nổ'],
            ['name' => 'Speech Technology Center', 'country' => 'Nga', 'specialty' => 'Nhận dạng khuôn mặt, sinh trắc học âm thanh'],
            ['name' => 'Polimaster', 'country' => 'Belarus', 'specialty' => 'Thiết bị phát hiện chất phóng xạ, chất độc'],
            ['name' => 'Phantom', 'country' => 'Israel', 'specialty' => 'Máy phá sóng'],
            ['name' => 'Lavanda-U', 'country' => 'Nga', 'specialty' => 'Thiết bị dò tìm chất nổ'],
            ['name' => 'AVK', 'country' => null, 'specialty' => 'Thiết bị phát hiện chất nổ lỏng (LQ test)'],
            ['name' => 'Cellebrite', 'country' => null, 'specialty' => 'Phân tích, điều tra kỹ thuật số & di động'],
            ['name' => 'Rigma', 'country' => 'Litva', 'specialty' => 'Hệ thống viễn thông đặc biệt'],
            ['name' => 'Telesystems', 'country' => 'Nga', 'specialty' => 'Máy ghi âm chuyên dụng siêu nhỏ'],
            ['name' => 'Nelk / Evraas', 'country' => 'Nga', 'specialty' => 'Thiết bị chống ghi âm, phát hiện thiết bị nghe lén'],
            ['name' => 'Dors', 'country' => 'Nga', 'specialty' => 'Thiết bị kiểm tra tiền, giấy tờ, hồ sơ'],
            ['name' => 'Set-1', 'country' => 'Nga', 'specialty' => 'Thiết bị ghi, thu phát tiếng/hình chuyên dụng'],
            ['name' => 'Universal System', 'country' => 'Nga', 'specialty' => 'Ống nhòm, ống kính hồng ngoại'],
            ['name' => 'METREL', 'country' => 'Slovenia', 'specialty' => 'Hệ thống đo và phân tích môi trường'],
            ['name' => 'ELECTROL STANDARD', 'country' => 'Nga', 'specialty' => 'Hệ thống đo và phân tích môi trường'],
        ];

        foreach ($partners as $index => $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                [
                    'country' => $partner['country'],
                    'specialty' => $partner['specialty'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
