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
                'icon' => 'viewfinder-circle',
                'description' => 'Thiết bị soi chiếu X-quang, tán xạ ngược, cổng phát hiện chất nổ - vũ khí, máy dò chất độc, chất phóng xạ và hàng cấm.',
            ],
            [
                'group_code' => 'B',
                'name' => 'Hệ thống, phần mềm sinh trắc học, pháp y âm thanh, hình ảnh',
                'icon' => 'finger-print',
                'description' => 'Giải pháp giám định âm thanh, nhận diện khuôn mặt, phân tích vân tay và dữ liệu điện tử phục vụ điều tra.',
            ],
            [
                'group_code' => 'C',
                'name' => 'Hệ thống thiết bị phát hiện nghe lén, bảo vệ thông tin',
                'icon' => 'signal-slash',
                'description' => 'Thiết bị dò thiết bị nghe lén trên đường dây, sóng RF, ống kính quang học và bảo vệ an ninh thông tin.',
            ],
            [
                'group_code' => 'D',
                'name' => 'Thiết bị trinh sát kỹ thuật',
                'icon' => 'signal',
                'description' => 'Thiết bị quan sát ngày/đêm, ghi âm - ghi hình định hướng, định vị thuê bao di động và trinh sát kỹ thuật.',
            ],
            [
                'group_code' => 'E',
                'name' => 'Các công cụ hỗ trợ, bảo vệ mục tiêu, trấn áp tội phạm',
                'icon' => 'shield-check',
                'description' => 'Súng chế áp Drone/UAV, đèn chiếu, khiên chống bạo động và công cụ hỗ trợ trấn áp tội phạm.',
            ],
            [
                'group_code' => 'F',
                'name' => 'Giải pháp sao chép, chế tạo mẫu',
                'icon' => 'printer',
                'description' => 'Hệ thống quét 3D laser cầm tay, in 3D kim loại và in 3D nhựa công nghệ FDM.',
            ],
            [
                'group_code' => 'G',
                'name' => 'Các hệ thống, thiết bị khác',
                'icon' => 'squares-2x2',
                'description' => 'Kính hiển vi giám định, hệ thống camera an ninh, phòng Lab phục hồi dữ liệu số và các thiết bị chuyên dụng khác.',
            ],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['group_code' => $category['group_code']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
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
