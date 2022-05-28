<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        $name = $request->input('name');

        // todo send email event fire in queue

        return response()->json("Thanks $name for contacting us, we will text you soon.",200);
    }
}
