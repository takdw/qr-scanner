<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanResultController extends Controller
{
    public function store()
    {
        $validated = request()->validate([
            'result' => ['required'],
        ]);

        $result = request()->get('result');

        // Do something with the scan result

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Received!',
            ], 200);
        }

        return redirect()->back();
    }
}
