<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProcessImageUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempPath;
    protected $folder;

    public function __construct($tempPath, $folder)
    {
        $this->tempPath = $tempPath;
        $this->folder = $folder;
    }

    public function handle()
    {
        // Process the image in background
        $image = Image::make($this->tempPath);
        
        $image->fit(800, 800);
        
        $filename = 'profile_' . time() . '_' . uniqid() . '.jpg';
        $finalPath = storage_path('app/public/' . $this->folder . '/' . $filename);
        
        $image->save($finalPath, 80);
        
        // Clean up temp file
        unlink($this->tempPath);
        
        // Update database record if needed
        // User::where('profile_image', 'like', 'temp/%')->update(['profile_image' => $this->folder . '/' . $filename]);
    }
}