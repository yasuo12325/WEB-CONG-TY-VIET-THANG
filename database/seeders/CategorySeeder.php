<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * 7 nhóm danh mục theo đúng cấu trúc tài liệu nguồn
     * "DANH MỤC TRANG THIẾT BỊ" (nhóm A-G).
     */
    public function run(): void
    {
        $categories = [
            [
                'group_code' => 'A',
                'name' => 'Soi chiếu, phát hiện vũ khí, hàng lậu, chất nổ, chất phóng xạ',
                'name_en' => 'Detection & Screening of Weapons, Contraband, Explosives and Radioactive Materials',
                'icon' => 'viewfinder-circle',
                'description' => 'Thiết bị soi chiếu X-quang, tán xạ ngược, cổng phát hiện chất nổ - vũ khí, máy dò chất độc, chất phóng xạ và hàng cấm.',
                'description_en' => 'X-ray and backscatter screening equipment, walk-through explosives/weapons detection gates, and chemical, radiation and contraband detectors.',
            ],
            [
                'group_code' => 'B',
                'name' => 'Hệ thống, phần mềm sinh trắc học, pháp y âm thanh, hình ảnh',
                'name_en' => 'Biometric Systems & Software, Audio and Image Forensics',
                'icon' => 'finger-print',
                'description' => 'Giải pháp giám định âm thanh, nhận diện khuôn mặt, phân tích vân tay và dữ liệu điện tử phục vụ điều tra.',
                'description_en' => 'Voice forensics, facial recognition, fingerprint analysis and digital data forensics solutions for investigation support.',
            ],
            [
                'group_code' => 'C',
                'name' => 'Hệ thống thiết bị phát hiện nghe lén, bảo vệ thông tin',
                'name_en' => 'Eavesdropping Detection & Information Security Equipment',
                'icon' => 'signal-slash',
                'description' => 'Thiết bị dò thiết bị nghe lén trên đường dây, sóng RF, ống kính quang học và bảo vệ an ninh thông tin.',
                'description_en' => 'Detectors for wiretaps on cabling, RF eavesdropping devices and hidden camera lenses, protecting information security.',
            ],
            [
                'group_code' => 'D',
                'name' => 'Thiết bị trinh sát kỹ thuật',
                'name_en' => 'Technical Reconnaissance Equipment',
                'icon' => 'signal',
                'description' => 'Thiết bị quan sát ngày/đêm, ghi âm - ghi hình định hướng, định vị thuê bao di động và trinh sát kỹ thuật.',
                'description_en' => 'Day/night observation, directional audio/video recording, mobile-subscriber locating and technical reconnaissance equipment.',
            ],
            [
                'group_code' => 'E',
                'name' => 'Các công cụ hỗ trợ, bảo vệ mục tiêu, trấn áp tội phạm',
                'name_en' => 'Support Tools for Target Protection & Crime Suppression',
                'icon' => 'shield-check',
                'description' => 'Súng chế áp Drone/UAV, đèn chiếu, khiên chống bạo động và công cụ hỗ trợ trấn áp tội phạm.',
                'description_en' => 'Drone/UAV suppression guns, illuminators, anti-riot shields and other tools supporting crime suppression.',
            ],
            [
                'group_code' => 'F',
                'name' => 'Giải pháp sao chép, chế tạo mẫu',
                'name_en' => 'Reverse-Engineering & Rapid Prototyping Solutions',
                'icon' => 'printer',
                'description' => 'Hệ thống quét 3D laser cầm tay, in 3D kim loại và in 3D nhựa công nghệ FDM.',
                'description_en' => 'Handheld 3D laser scanning systems, metal 3D printing and FDM plastic 3D printing.',
            ],
            [
                'group_code' => 'G',
                'name' => 'Các hệ thống, thiết bị khác',
                'name_en' => 'Other Systems & Equipment',
                'icon' => 'squares-2x2',
                'description' => 'Kính hiển vi giám định, hệ thống camera an ninh, phòng Lab phục hồi dữ liệu số và các thiết bị chuyên dụng khác.',
                'description_en' => 'Forensic microscopes, security camera systems, digital data recovery labs and other specialized equipment.',
            ],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['group_code' => $category['group_code']],
                [
                    'name' => $category['name'],
                    'name_en' => $category['name_en'],
                    'description' => $category['description'],
                    'description_en' => $category['description_en'],
                    'icon' => $category['icon'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }

        // Loại bỏ danh mục cũ không còn thuộc cấu trúc A-G (an toàn vì chưa có sản phẩm nào gắn vào các danh mục này).
        Category::whereNull('group_code')->whereDoesntHave('products')->delete();
    }
}
