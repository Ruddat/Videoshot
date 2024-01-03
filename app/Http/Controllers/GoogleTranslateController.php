<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleTranslateController extends Controller
{

    public function change(Request $request): \Illuminate\Http\RedirectResponse
    {
        session()->put('locale', $request->lang);

        return back();
    }
}
