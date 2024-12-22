<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

/**
 * @group Media Management
 *
 * APIs for managing media uploads (images, videos)
 */
class MediaController extends Controller
{
    use ApiResponse;

    /**
     * Upload a file
     *
     * Upload an image or video file. Supported formats: jpg, jpeg, png, gif, mp4
     *
     * @bodyParam file file required The file to upload. Must be an image (jpg, jpeg, png, gif) or video (mp4). Maximum size: 10MB.
     *
     * @response 201 {
     *  "status": "success",
     *  "message": "File uploaded successfully",
     *  "data": {
     *    "path": "media/abc123.jpg",
     *    "url": "http://localhost/storage/media/abc123.jpg"
     *  }
     * }
     * 
     * @response 422 {
     *  "status": "error",
     *  "message": "The file must be an image or video file"
     * }
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,mp4|max:10240' // 10MB max
        ]);

        $path = $request->file('file')->store('public/media');

        $path = str_replace('public/', '', $path);

        // Cache'i temizle
        Cache::tags(['user', 'media'])->forget("user:" . auth()->id() . ":media");

        return $this->successResponse([
            'path' => $path,
            'url' => Storage::url($path)
        ], 'File uploaded successfully', 201);
    }

    /**
     * Delete a file
     *
     * @urlParam filename required The name of the file to delete. Example: abc123.jpg
     *
     * @response {
     *  "status": "success",
     *  "message": "File deleted successfully"
     * }
     * 
     * @response 404 {
     *  "status": "error",
     *  "message": "File not found"
     * }
     */
    public function destroy($filename)
    {
        if (Storage::disk('public')->exists('media/' . $filename)) {
            Storage::disk('public')->delete('media/' . $filename);
            
            // Cache'i temizle
            Cache::tags(['user', 'media'])->forget("user:" . auth()->id() . ":media");
            
            return $this->successResponse(null, 'File deleted successfully');
        }

        return $this->errorResponse('File not found', 404);
    }
}
