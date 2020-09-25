<?php

namespace App\Services;

use App\Contracts\PhotoServiceInterface;
use Illuminate\Http\Request;
use App\Exceptions\PhotoExtensionNotAllowedException;

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
        foreach ($this->request->file('img') as $file) {

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
        return $this->getStoredFilesNames();
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