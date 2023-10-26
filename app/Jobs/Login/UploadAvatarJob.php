<?php

namespace App\Jobs\Login;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class UploadAvatarJob implements ShouldQueue
{
    protected $userId;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId, $user)
    {
        $this->userId = $userId;
        $this->user = $user;
    }

    public function deleteAvatars($paths)
    {
        foreach ($paths as $path) {
            $path = str_replace('/storage/', '', $path);

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Upload user avatar image.
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
        Storage::disk('public')->put('/assets/avatar/' . $this->user . '/' . $this->userId . $fileName, $canvasData);

        return config('filesystems.path.localhost') . 'assets/avatar/' . $this->user . '/' . $this->userId . $fileName;
    }

}
