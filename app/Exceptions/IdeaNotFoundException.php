<?php

namespace App\Exceptions;

use Exception;

class IdeaNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => 'İçerik bulunamadı.'
        ], 404);
    }
} 