<?php declare(strict_types = 1);

namespace App\Http\Services\AdImage;

interface IAdImageService
{
    public function storeImages(array $images, string $folder = ''): array;

    public function deleteImagesByIds(array $ids): bool;
}
