<?php

namespace App\Http\Controllers;

use App\Events\NewPostEvent;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostSavesCollection;
use App\Http\Resources\UserResource;
use App\Mail\postEmail;
use App\Models\post;
use App\Models\PostSaves;
use App\Models\User;
use App\Notifications\NewPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $user = Auth::user();
        $post = $user->posts()->create([
            'title' => $request->title,
            'message' => $request->message,
            'category' => $request->category,
            'price'    => $request->price]);
        $images = [];
        $contactNumbers = $request->numbers;

        $sms = $user->sms()->create([
            'benefit' => $request->title,
            'message' => $request->message,
            'numbers' => implode(", " ,$contactNumbers)
        ]);

        foreach ( $request->images as $image)
        {
            $img = substr($image, strpos($image, ",") + 1);
            //decode ba
            //se64
            $unencoded_data = base64_decode($img);
            //upload to storage
            $path = $post->id . '/' . uniqid() . '.png';
            Storage::disk('public')->put($path, $unencoded_data);

            //update user
            $imageLocation = Storage::disk('public')->url($path);
            $post->postImages()->create(['location' => $imageLocation]);
        }

        /*$postResource = new PostCollection($post);
        event(new NewPostEvent($postResource));*/
       /* foreach ($user->subscribers as $follower) {
            $follower->notify(new NewPost($user, $post));
        }*/
        $this->sendEMails($request->emails, $post);
        return response(['success' => true, 'message' => $user->subscribers], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function sendSMS(Request $request)
    {

    }
    public function store(Request $request)
    {
        //
    }

    public function sendEMails(Array $emails, post $post)
    {
        foreach ($emails as $recipient) {
            Mail::to($recipient)->send(new postEmail($post));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(post $post)
    {
        //
        $post = post::all()->reverse()->values();
        return PostCollection::collection($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $user = Auth::user();
        $post = post::find($request->id);
        $post->postImages()->delete();
        $post->update([
            'title' => $request->title,
            'message' => $request->message,
            'category' => $request->category,
            'price'    => $request->price
        ]);
        $images = [];
        $contactNumbers = $request->numbers;

        $sms = $user->sms()->create([
            'benefit' => $request->title,
            'message' => $request->message,
            'numbers' => implode(", " ,$contactNumbers)
        ]);

        foreach ( $request->images as $image)
        {
            $img = substr($image, strpos($image, ",") + 1);
            //decode ba
            //se64
            $unencoded_data = base64_decode($img);
            //upload to storage
            $path = $post->id . '/' . uniqid() . '.png';
            Storage::disk('public')->put($path, $unencoded_data);

            //update user
            $imageLocation = Storage::disk('public')->url($path);
            $post->postImages()->create(['location' => $imageLocation]);
        }

        /*$postResource = new PostCollection($post);
        event(new NewPostEvent($postResource));*/
        /* foreach ($user->subscribers as $follower) {
             $follower->notify(new NewPost($user, $post));
         }*/

        return response(['success' => true, 'message' => $user->subscribers], 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\post  $post
     */
    public function destroy(Request $request)
    {
        //
        $post = post::find($request->id);
        $post->postImages()->delete();
        $post->delete();

        return response()->json(['success' => true, 'message' => 'Post Deleted'], 200);
    }

    public function getPostSaves(Request $request)
    {
        $user = Auth::user();
        $postSaves = $user->postSaves;

        return PostSavesCollection::collection($postSaves);

    }

    public function companies(Request $request)
    {
        $user = User::all();

        return UserResource::collection($user);

    }

}
