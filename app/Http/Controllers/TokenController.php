<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'token' => ['nullable','max:255', 'min:16'],
            'save_posters' => ['nullable', 'boolean'],
        ]);

        auth()->user()->update([
            'save_posters' => $request->get('save', false),
            'token' => $request->get('token'),
        ]);

        return back();
    }
}
