<?php

namespace App\Jobs\Login;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class UploadAvatarJob implements ShouldQueue
{
    protected $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function deleteAvatars($paths)
    {
        foreach ($paths as $path) {
            if (Storage::exists("public/" . $path)) {
                Storage::delete("public/" . $path);
            }
        }
    }

    /**
     * Upload avatar image.
     *
     * @return void
     */
    public function uploadAvatar($canvasDataUrl) : string
    {
        // извлекаем тип файла из dataUrl
        $fileExtension = explode('/', mime_content_type($canvasDataUrl))[1];

        // удаляем ненужную информацию из dataUrl
        $canvasDataParts = explode(',', $canvasDataUrl);
        $canvasData = base64_decode($canvasDataParts[1]);

        // сохраняем данные в новый файл на сервере
        $fileName = uniqid('/') . '.' . $fileExtension;
        Storage::disk('public')->put('/assets/avatar/' . $this->userId . $fileName, $canvasData);

        return config('filesystems.path.localhost') . 'assets/avatar/' . $this->userId . $fileName;
    }
}
