<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        try {
            Feedback::create($request->all());
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }
}
