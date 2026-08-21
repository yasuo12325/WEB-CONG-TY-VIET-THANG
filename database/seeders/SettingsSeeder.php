<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedLogo();

        $settings = [
            'company_name' => 'CÔNG TY CỔ PHẦN THIẾT BỊ CÔNG NGHIỆP VÀ CHUYỂN GIAO CÔNG NGHỆ VIỆT THẮNG',
            'company_name_intl' => 'VIET THANG INDUSTRIAL EQUIPMENT AND TECHNOLOGY TRANSFER JOINT STOCK COMPANY',
            'company_short_name' => 'VIETTC., JSC',
            'founded_year' => '2003',
            'charter_capital' => '20.000.000.000 VNĐ',
            'employee_count' => '31',
            'partner_count' => '25',
            'ceo_name' => 'Phí Bá Linh',
            'headquarters_address' => 'Số 19, ngõ 159 Pháo Đài Láng, phường Láng, Hà Nội',
            'office_address' => 'Tầng 8, tòa nhà Diamond Flower (Handico 6), đường Lê Văn Lương, phường Thanh Xuân, Hà Nội',
            'phone' => '024.66665511 / 024.66665522',
            'fax' => '024.66665577',
            'email' => 'info@vietthang.vn',
            'website' => 'https://www.vietthang.vn',
            'logo_path' => 'settings/logo.png',
            'hero_headline' => 'CÔNG NGHỆ TIÊN TIẾN. GIẢI PHÁP TIN CẬY.',
            'hero_headline_en' => 'ADVANCED TECHNOLOGY. TRUSTED SOLUTIONS.',
            'hero_subheadline' => 'Cung cấp các giải pháp và thiết bị công nghệ cao cho an ninh, quốc phòng và hạ tầng trọng yếu.',
            'hero_subheadline_en' => 'Providing high-technology solutions and equipment for security, defense and critical infrastructure.',
            'about_summary' => 'Công ty Cổ phần Thiết bị Công nghiệp và Chuyển giao Công nghệ Việt Thắng (VIETTC., JSC) thành lập năm 2003, là nhà nhập khẩu, phân phối độc quyền và nhà sản xuất các trang thiết bị nghiệp vụ đặc biệt phục vụ an ninh - quốc phòng tại Việt Nam.',
            'about_summary_en' => 'Viet Thang Industrial Equipment and Technology Transfer Joint Stock Company (VIETTC., JSC), founded in 2003, is an importer, exclusive distributor and manufacturer of specialized equipment for the security and defense sector in Vietnam.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value, 'type' => 'string']);
        }
    }

    /**
     * Nạp logo chính thức của công ty (Logo VT.png) vào storage để header/footer hiển thị.
     */
    private function seedLogo(): void
    {
        $source = database_path('seeders/data/branding/logo.png');

        if (! file_exists($source)) {
            return;
        }

        Storage::disk('public')->put('settings/logo.png', file_get_contents($source));
    }
}
