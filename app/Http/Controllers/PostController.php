<?php

namespace App\Http\Controllers;

use App\Jobs\storeMedia;
use App\Services\MediaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'caption' => 'nullable|string',
                'media' => 'required|file|mimes:jpeg,jpg,png,mp4',
            ]);

            // Retrieve necessary data from the request
            $extension = $request->file('media')->getClientOriginalExtension();
            $mediaPath = $request->file('media')->getRealPath();

            // Dispatch the job with necessary data
            storeMedia::dispatch($mediaPath, $this->mediaService , $extension);

            return response()->json(['message' => 'media uploading in progress...', 'status' => true]);
        } catch (ValidationException $exception) {
            $validator = $exception->validator;
            return response()->json([
                'message' => $validator->errors()->getMessages()[array_key_first($validator->errors()->getMessages())][0],
                'status' => false
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => gettype($exception) == 'string' ? $exception : $exception->getMessage(), 'status' => false]);
        }
    }
}
