<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

        $data = $request->validate([
            'user_name' => ['required', 'string'],
            'company_name' => ['required', 'string'],
            'avatar' => ['required', 'string'],
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
            'phone_number' => ['required', 'integer'],
        ]);



        $user = User::create([
                    'user_name' => $data['user_name'],
                    'company_name' => $data['company_name'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'phone_number' => $data['phone_number'],
                ]);

                $filtered_data = substr($data['avatar'], strpos($data['avatar'], ",") + 1);
                //decode base64
                $unencoded_data = base64_decode($filtered_data);
                //upload to storage
                $path = $user->id . '/' . time() . '.png';
                Storage::disk('public')->put($path, $unencoded_data);

                //update user
                $user->avatar = Storage::disk('public')->url($path);
                $user->save();
        return response()->json([
            'success' => true,
            'user' =>$user,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
