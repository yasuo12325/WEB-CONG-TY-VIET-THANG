<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Nhóm sản phẩm nổi bật hiển thị trên trang chủ (mỗi nhóm A-G chọn 1 sản phẩm tiêu biểu
     * để phần "Sản phẩm nổi bật" có đại diện đa dạng các lĩnh vực hoạt động).
     */
    private const FEATURED = [
        'Thiết bị soi chiếu Xray cầm tay',
        'Máy soi chiếu thế hệ mới',
        'Hệ thống nhận diện khuôn mặt',
        'Thiết bị phát hiện thiết bị nghe lén lợi dụng sóng RF',
        'Hệ thống phát hiện bắn tỉa',
        'Hệ thống phát hiện, chế áp UAV',
        'Hệ thống quét 3D laser cầm tay',
        'Hệ thống camera giám sát an ninh',
    ];

    public function run(): void
    {
        $dataPath = database_path('seeders/data/catalog.json');
        $imagesPath = database_path('seeders/data/products');

        if (! file_exists($dataPath)) {
            $this->command?->warn('catalog.json không tồn tại, bỏ qua seed sản phẩm.');

            return;
        }

        $catalog = json_decode(file_get_contents($dataPath), true, flags: JSON_THROW_ON_ERROR);
        $categoriesByCode = Category::whereNotNull('group_code')->get()->keyBy('group_code');

        $sortOrderPerCategory = [];

        foreach ($catalog['products'] as $item) {
            $category = $categoriesByCode->get($item['cat']);

            if (! $category) {
                $this->command?->warn("Không tìm thấy category cho nhóm {$item['cat']}, bỏ qua sản phẩm: {$item['name']}");

                continue;
            }

            $slug = Str::slug($item['name']);
            $sortOrderPerCategory[$item['cat']] = ($sortOrderPerCategory[$item['cat']] ?? -1) + 1;

            $shortDescription = Str::limit($item['desc'], 200, '…');

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'model_number' => null,
                    'short_description' => $shortDescription,
                    'description' => '<p>'.e($item['desc']).'</p>',
                    'status' => Product::STATUS_PUBLISHED,
                    'is_featured' => in_array($item['name'], self::FEATURED, true),
                    'sort_order' => $sortOrderPerCategory[$item['cat']],
                    'published_at' => now(),
                ]
            );

            $sourceImage = "{$imagesPath}/".sprintf('%03d.png', $item['img']);

            if (! file_exists($sourceImage)) {
                continue;
            }

            $storedPath = "products/images/{$slug}.png";
            Storage::disk('public')->put($storedPath, file_get_contents($sourceImage));

            ProductImage::updateOrCreate(
                ['product_id' => $product->id, 'sort_order' => 0],
                [
                    'disk' => 'public',
                    'path' => $storedPath,
                    'is_primary' => true,
                    'alt_text' => $item['name'],
                ]
            );
        }

        $this->command?->info('Đã seed '.count($catalog['products']).' sản phẩm theo '.count($catalog['categories']).' nhóm A-G.');
    }
}
