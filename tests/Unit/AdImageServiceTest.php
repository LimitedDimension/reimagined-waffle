<?php

namespace Tests\Unit;

use App\Http\Services\AdImage\AdImageService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\TestCase;

class AdImageServiceTest extends TestCase
{
    private AdImageService $adImageService;

    public function setUp(): void
    {

        $fileSystemMock = $this->createMock(Filesystem::class);
        $fileSystemMock->method('put')->willReturn(true);

        app()->instance(Filesystem::class, $fileSystemMock);

        $this->adImageService = app()->make(AdImageService::class);
    }

    /**
     * @large
     */
    public function testNonImageFilesUpload()
    {
        $audioFile = $this->createMock(UploadedFile::class);
        $docFile = $this->createMock(UploadedFile::class);
        $videoFile = $this->createMock(UploadedFile::class);

        $audioFile->method('getClientOriginalExtension')->willReturn('.aac');
        $audioFile->method('getMimeType')->willReturn('audio/aac');

        $docFile->method('getClientOriginalExtension')->willReturn('.jpg');
        $docFile->method('getMimeType')->willReturn('image/jpeg');

        $videoFile->method('getClientOriginalExtension')->willReturn('.avi');
        $videoFile->method('getMimeType')->willReturn('video/x-msvideo');

        $images = [ $audioFile, $docFile, $videoFile ];

        $this->assertCount(1, $this->adImageService->storeImages($images));
    }
}
