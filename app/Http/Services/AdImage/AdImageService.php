<?php declare(strict_types = 1);

namespace App\Http\Services\AdImage;

use App\Http\Repositories\AdImage\AdImageRepository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AdImageService implements IAdImageService
{
    private const DISK_FOLDER = 'public';

    private const FILE_PREFIX = 'ad_images';

    private const ALLOWED_MIME_TYPES = [
        "image/png",
        "image/gif",
        "image/jpeg",
    ];

    private AdImageRepository $adImageRepository;

    private Filesystem $storage;

    /**
     * AdImageService constructor.
     *
     * @param AdImageRepository $adImageRepository
     * @param Filesystem $storage
     */
    public function __construct(AdImageRepository $adImageRepository, Filesystem $storage)
    {
        $this->adImageRepository = $adImageRepository;
        $this->storage = $storage;
    }

    /**
     * Upload multiple files as save their data into the database.
     *
     * @param UploadedFile[] $images
     * @param string $folder
     *
     * @return array
     */
    public function storeImages(array $images, string $folder = ''): array
    {
        $files = [];

        foreach ($images as $image) {
            if (!in_array($image->getMimeType(), self::ALLOWED_MIME_TYPES, true)) {
                continue;
            }

            $ext = $image->getClientOriginalExtension();
            $filename = self::FILE_PREFIX . '/' . Str::random(100) . '.' . $ext;
            $path = self::DISK_FOLDER  . '/' . $filename;

            $this->storage->put($path, $image->getContent(), [ 'disk' => 'local']);

            $stored = $this->storage->put($path, $image->getContent());

            if ($stored) {
                $files[] = $this->adImageRepository->createAdImage($filename);
            }
        }

        return $files;
    }

    /**
     * @param array $ids
     *
     * @return bool
     */
    public function deleteImagesByIds(array $ids): bool
    {
        $images = $this->adImageRepository->getByIds($ids);

        if ($images) {
            foreach ($images as $image) {
                $path = storage_path('app/' . self::DISK_FOLDER . '/' . $image->src);

                if (file_exists($path)) {
                    $deleted = unlink($path);

                    if ($deleted) {
                        $image->delete();
                    }
                }
            }
        }

        return false;
    }
}
