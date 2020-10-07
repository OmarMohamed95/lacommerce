<?php

namespace App\Services;

use App\Contracts\PhotoServiceInterface;
use Illuminate\Http\Request;
use App\Exceptions\PhotoExtensionNotAllowedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class PhotoService implements PhotoServiceInterface
{
    const STORAGE_DIR = 'uploads';

    /**
     * Store path
     *
     * @var string
     */
    private $storePath;

    /**
     * Stored files names
     *
     * @var array
     */
    private $storedFilesNames = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Store photo in disk storage
     *
     * @return array
     *
     * @throws PhotoExtensionNotAllowedException
     */
    public function store(): array
    {
        $files = $this->request->file('img');
        if (is_array($files)) {
            $this->storeMultipleFiles($files);
        } else {
            $this->storeSingleFile($files);
        }
        
        return $this->getStoredFilesNames();
    }

    /**
     * Delete photos from disk storage
     *
     * @param Collection $photos
     *
     * @return void
     *
     * @throws \Exception
     */
    public function delete(Collection $photos): void
    {
        $storePath = $this->getStorePath();
        if (!$storePath) {
            throw new \Exception('Store path is not set yet!');
        }

        foreach ($photos as $photo) {
            storage::disk(self::STORAGE_DIR)
                ->delete("$storePath/$photo->img");
        }
    }

    /**
     * Store multiple files
     *
     * @param array $files
     * 
     * @return void
     *
     * @throws PhotoExtensionNotAllowedException
     */
    private function storeMultipleFiles(array $files)
    {
        foreach ($files as $file) {
            $this->handleStoring($file);
        }
    }

    /**
     * Store single file
     *
     * @param UploadedFile $file
     * 
     * @return void
     *
     * @throws PhotoExtensionNotAllowedException
     */
    private function storeSingleFile(UploadedFile $file)
    {
        $this->handleStoring($file);
    }

    /**
     * Handle storing the files
     *
     * @param UploadedFile $file
     * 
     * @return void
     *
     * @throws PhotoExtensionNotAllowedException
     */
    private function handleStoring(UploadedFile $file)
    {
        $fullName = $file->getClientOriginalName();
        $nameWithoutExt = pathinfo($fullName, PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();

        if ($this->isValidExtension($ext)) {
            $uniqueName = $nameWithoutExt . '-' . time() . '.' .  $ext;
            $storePath = $this->getStorePath();

            if (!$storePath) {
                throw new \Exception('Store path is not set yet!');
            }

            $file->storePubliclyAs($storePath, $uniqueName, self::STORAGE_DIR);
            $this->saveStoredFileName($uniqueName);
        } else {
            throw new PhotoExtensionNotAllowedException($ext);
        }
    }

    /**
     * Get store path
     *
     * @return string
     */
    public function getStorePath(): string
    {
        return $this->storePath;
    }

    /**
     * Set store path
     *
     * @param string $path 
     * 
     * @return self
     */
    public function setStorePath(string $path): self
    {
        $this->storePath = $path;

        return $this;
    }

    /**
     * Get stored file name
     *
     * @return array
     */
    private function getStoredFilesNames(): array
    {
        return $this->storedFilesNames;
    }
    
    /**
     * Check if extension is valid
     *
     * @param mixed $ext 
     * 
     * @return boolean
     */
    private function isValidExtension($ext)
    {
        if (in_array($ext, $this->getValidExtensions())) {
            return true;
        }
        return false;
    }

    /**
     * Get valid extensions
     * 
     * @return array
     */
    private function getValidExtensions(): array
    {
        return [
            'png',
            'jpg',
            'jpe',
            'jpeg',
        ];
    }

    /**
     * Save stored file name
     *
     * @param string $fileName
     *
     * @return array
     */
    private function saveStoredFileName(string $fileName): void
    {
        array_push($this->storedFilesNames, $fileName);
    }
}