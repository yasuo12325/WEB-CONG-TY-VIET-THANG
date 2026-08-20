<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Camera & Hệ thống giám sát',
                'icon' => 'video-camera',
                'description' => 'Hệ thống theo dõi thông minh Camera CCTV giám sát an ninh.',
            ],
            [
                'name' => 'Thiết bị xử lý tài liệu chuyên dụng',
                'icon' => 'document-magnifying-glass',
                'description' => 'Hệ thống xử lý kỹ thuật tài liệu chuyên dụng phục vụ công tác nghiệp vụ.',
            ],
            [
                'name' => 'Thiết bị phát hiện & tìm kiếm',
                'icon' => 'magnifying-glass',
                'description' => 'Các thiết bị phục vụ cho công tác nghiệp vụ phát hiện và tìm kiếm.',
            ],
            [
                'name' => 'Thiết bị an toàn & chống khủng bố',
                'icon' => 'shield-exclamation',
                'description' => 'Thiết bị an toàn phòng chống cháy nổ, phát hiện vật liệu cất giấu, phòng chống khủng bố.',
            ],
            [
                'name' => 'Thiết bị quét hiện trường & giám định',
                'icon' => 'cube',
                'description' => 'Thiết bị quét, dựng hiện trường 3D và vật tư tiêu hao trong quá trình giám định.',
            ],
            [
                'name' => 'Thiết bị sinh trắc học & phân tích số',
                'icon' => 'finger-print',
                'description' => 'Giải pháp nhận dạng khuôn mặt, sinh trắc học âm thanh, phân tích điều tra kỹ thuật số.',
            ],
            [
                'name' => 'Thiết bị đo lường & phân tích môi trường',
                'icon' => 'beaker',
                'description' => 'Hệ thống đo và phân tích môi trường, kiểm tra tiền và giấy tờ.',
            ],
            [
                'name' => 'Chuyển giao công nghệ',
                'icon' => 'cog-6-tooth',
                'description' => 'Công nghệ và dây chuyền sản xuất thiết bị nghiệp vụ đặc biệt, công nghệ lắp ráp CCTV.',
            ],
        ];

        foreach ($categories as $index => $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'icon' => $category['icon'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
