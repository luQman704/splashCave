<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactsController {


    public function index(Request $request)
    {
        $user = Auth::user();
        $contacts = $user->contacts->reverse()->values();

        return response()->json(['success' => true, 'contacts' =>$contacts]);
    }


    public function create(Request $request)
    {
        $user = Auth::user();


        $user->contacts()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'number' => $request->number
        ]);

        return response()->json(['success' => true]);
    }
}
