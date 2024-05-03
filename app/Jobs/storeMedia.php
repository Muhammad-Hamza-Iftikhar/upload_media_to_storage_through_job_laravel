<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class storeMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $media;
    protected $mediaService;
    protected $extension;

    public function __construct($media, $mediaService, $extension)
    {
        $this->media = $media;
        $this->mediaService = $mediaService;
        $this->extension = $extension;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Reconstruct UploadedFile instance from the media path
        $media = new \Illuminate\Http\UploadedFile($this->media, basename($this->media));
        // Call the fileService method with the UploadedFile instance
        $this->mediaService->uploadPost($media, $this->extension);
    }
}
