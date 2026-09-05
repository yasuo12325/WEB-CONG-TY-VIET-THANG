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

            // "Giới thiệu công ty" page — one free-form content block,
            // editable via /admin/manage-settings instead of being
            // hardcoded in lang files. Seeded with the text that used to
            // live in lang/{vi,en}/pages.php (merged into one block) so the
            // page renders unchanged until an admin replaces it.
            'about_content' => "Tháng 04 năm 2003, CÔNG TY CỔ PHẦN THIẾT BỊ CÔNG NGHIỆP VÀ CHUYỂN GIAO CÔNG NGHỆ VIỆT THẮNG chính thức khai trương và đi vào hoạt động, với tên giao dịch quốc tế VIET THANG INDUSTRIAL EQUIPMENT AND TECHNOLOGY TRANSFER JOINT STOCK COMPANY (VIETTC., JSC).\n\nTiền thân là một công ty chuyên hoạt động trong lĩnh vực kinh doanh xuất nhập khẩu các mặt hàng máy móc, thiết bị và công nghệ phục vụ ngành an ninh – quốc phòng. Đến nay, ngoài khả năng cung cấp các thiết bị máy móc đặc chủng, công ty còn phối hợp với các viện nghiên cứu, đơn vị nghiệp vụ trong và ngoài nước để thực hiện các giải pháp tư vấn, chuyển giao công nghệ.\n\nCông ty đã tự sản xuất một số trang thiết bị nghiệp vụ đặc biệt có chất lượng công nghệ cao phục vụ an ninh – quốc phòng. Với đội ngũ chuyên gia hàng đầu, được đào tạo bài bản trong và ngoài nước, công ty luôn tự hào là đơn vị bảo hành, bảo trì tốt nhất, kịp thời nhất và trách nhiệm nhất đối với các trang thiết bị, hệ thống đã cung cấp cho chủ đầu tư. Trải qua hơn 20 năm xây dựng và phát triển, công ty đã được nhiều cơ quan tín nhiệm và trao tặng bằng khen.\n\nVIETTC., JSC được tổ chức gồm 5 phòng ban chịu sự quản lý trực tiếp của Ban Giám đốc: Phòng Dự án & Thương mại (nghiên cứu, tư vấn lập hồ sơ, triển khai dự án, phát triển thị trường và sản phẩm mới); Phòng Tài chính - Hành chính, Nhân sự (quản lý tài chính, kế toán và nhân sự công ty); Phòng Kỹ thuật & Giải pháp (nghiên cứu, đánh giá chất lượng thiết bị, phối hợp chuyển giao công nghệ); Phòng Nghiên cứu chế tạo (nghiên cứu và chế tạo các sản phẩm phục vụ dự án của công ty); Phòng Bảo hành & Bảo trì (chịu trách nhiệm bảo hành, bảo trì sản phẩm sau bán hàng).",
            'about_content_en' => "In April 2003, VIET THANG INDUSTRIAL EQUIPMENT AND TECHNOLOGY TRANSFER JOINT STOCK COMPANY (VIETTC., JSC) officially launched operations, registered under the Vietnamese legal name \"CÔNG TY CỔ PHẦN THIẾT BỊ CÔNG NGHIỆP VÀ CHUYỂN GIAO CÔNG NGHỆ VIỆT THẮNG\".\n\nOriginally a company specializing in the import-export of machinery, equipment and technology for the security and defense sector, today the company also supplies specialized machinery and equipment while partnering with research institutes and operational units, both domestic and international, to deliver consulting and technology-transfer solutions.\n\nThe company manufactures a number of specialized, high-technology equipment items for the security and defense sector in-house. With a team of leading experts trained both domestically and abroad, the company takes pride in providing the best, most responsive and most responsible warranty and maintenance service for the equipment and systems it has supplied to its clients. Over more than 20 years of growth, the company has earned the trust of, and received commendations from, numerous agencies.\n\nVIETTC., JSC is organized into 5 departments reporting directly to the Board of Directors: Projects & Commercial Department (research, proposal and bid preparation, project implementation, market and new-product development); Finance, Administration & HR Department (financial management, accounting and human resources); Technical & Solutions Department (equipment research and quality evaluation, technology-transfer coordination); R&D and Manufacturing Department (research and manufacturing of products for the company's projects); Warranty & Maintenance Department (responsible for after-sales warranty and maintenance service).",

            // "Công nghệ" page — a single rich-text block (admin can type
            // text and drop images into the same field, unlike the plain
            // about_content textarea) rendered as-is via {!! !!}. Seeded
            // with the HTML equivalent of the previous hardcoded lang
            // strings so the page is unchanged until edited.
            'technology_content' => "<p>Bên cạnh việc nhập khẩu và phân phối các thiết bị An ninh - Quốc phòng đặc chủng, VIETTC., JSC còn phối hợp với các viện nghiên cứu, đơn vị nghiệp vụ và nhà sản xuất uy tín trong và ngoài nước để thực hiện tư vấn, chuyển giao công nghệ và tự sản xuất một số trang thiết bị nghiệp vụ đặc biệt.</p><h2>Công nghệ và dây chuyền sản xuất</h2><ul><li>Công nghệ và dây chuyền sản xuất các trang thiết bị nghiệp vụ đặc biệt phục vụ an ninh - quốc phòng.</li><li>Công nghệ lắp ráp Camera CCTV giám sát.</li></ul><h2>Đội ngũ kỹ thuật</h2><p>Đội ngũ chuyên gia được đào tạo bài bản trong và ngoài nước, có văn bằng, chứng chỉ do các nhà sản xuất cấp — đảm bảo năng lực tư vấn kỹ thuật, tích hợp hệ thống, lắp đặt, bảo hành và bảo trì tốt nhất, kịp thời nhất cho khách hàng.</p>",
            'technology_content_en' => "<p>In addition to importing and distributing specialized security and defense equipment, VIETTC., JSC partners with research institutes, operational units and reputable manufacturers — both domestic and international — to provide consulting, technology transfer, and in-house manufacturing of specialized equipment.</p><h2>Technology &amp; Manufacturing Lines</h2><ul><li>Technology and manufacturing lines for specialized security and defense equipment.</li><li>CCTV surveillance camera assembly technology.</li></ul><h2>Technical Team</h2><p>A team of experts trained both domestically and abroad, holding qualifications and certifications issued by manufacturers — ensuring the best and most responsive technical consulting, systems integration, installation, warranty and maintenance capability for customers.</p>",
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
