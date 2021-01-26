<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\userSavedCompaniesCollection;
use App\Http\Resources\UserSubscriptionCollection;
use App\Models\Account;
use App\Models\PostSaves;
use App\Models\User;
use App\Models\userSavedCompanies;
use App\Models\userSubscription;
use App\Notifications\UserSubscribed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $allUsers = Account::all();
        return UserResource::collection($allUsers);

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
            'phone_number' => ['required'],
            'location'    => ['required']
        ]);



        $user = User::create([
                    'user_name' => $data['user_name'],
                    'company_name' => $data['company_name'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'phone_number' => $data['phone_number'],
                    'location'   => $data['location']
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
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        //

        $user = Auth::user();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPhoneNumber(Request $request)
    {
        //
        $user = Auth::user();
        $user->phone_number = $request->phone_number;
        $user->save();

        return response()->json(['success' => true, 'user' => $user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editPassword(Request $request)
    {
        //
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => true, 'user' => $user], 200);
    }


    public function editImage(Request $request)
    {
        $user = Auth::user();
        $image = $request->image;
        $filtered_data = substr($image, strpos($image, ",") + 1);
        //decode base64
        $unencoded_data = base64_decode($filtered_data);
        //upload to storage
        $path = $user->id . '/' . time() . '.png';
        Storage::disk('public')->put($path, $unencoded_data);

        //update user
        $user->avatar = Storage::disk('public')->url($path);
        $user->save();

        return response()->json(['success' => true, 'user' => $user]);
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

    public function logUserIn(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('user_name', $request->user_name)->first();

        if (!$user ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token =  $user->createToken($request->device_name)->plainTextToken;

        return response(['user' => $user, 'token' => $token], 201);

    }

    public function posts(Request $request)
    {
        $user = Auth::user();
        $posts = $user->posts;

        return PostCollection::collection($posts);
    }

    public function getAllSubscribedUsers(Request $request)
    {
        $user = Auth::user();
        $subscribedUser = $user->subscribeTo;

        return UserResource::collection($subscribedUser);

    }

    public function subCompany(Request $request)
    {
        $sub_id = $request->user_id;
        $user = Auth::user();

        $subUser = User::find($sub_id);

        $sub = $user->subscribe($sub_id);

        $subUser->notify(new UserSubscribed($user));

        return response()->json(['success' => true, 'subId' => $sub_id]);
    }

    public function undoSubCompany(Request $request)
    {
        $company_id = $request->company_save;
        $user = Auth::user();

        $user->unSubscribe($company_id);

        return response()->json(['success' => true]);
    }


    public function getAllSavedCompanies(Request $request)
    {
        $user = Auth::user();
        $savedUsers = $user->userSaves;

        return userSavedCompaniesCollection::collection($savedUsers);

    }

    public function saveCompanyToUser(Request $request)
    {
        $user_id = $request->user_id;
        $user = Auth::user();

        $postSave = $user->userSaves()->create([
            'saved_user_id' => $user_id
        ]);

        return response()->json(['success' => true, 'saveId' => $postSave->id]);
    }

    public function undoSaveCompanyToUser(Request $request)
    {
        $company_id = $request->company_save;
        $user = Auth::user();

        $userSubscription = userSavedCompanies::find($company_id);
        $userSubscription->delete();

        return response()->json(['success' => true]);
    }

    public function sms(Request $request)
    {
        $user = Auth::user();
        $sms = $user->sms;

        return response()->json(['success' => true, 'sms' => $sms]);
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications()->get()->toArray();
        return response()->json(['success' => true, 'data' => $notifications], 200);
    }

}
