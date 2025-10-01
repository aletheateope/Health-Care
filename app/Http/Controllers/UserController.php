<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        $users = User::where('id', '!=', $currentUser->id)
                   ->with('profile')
                   ->get();

        return UserResource::collection($users);
    }

    public function currentUser(Request $request)
    {
        return new UserResource($request->user()->load('profile'));
    }

    public function store(Request $request, CreateNewUser $creator)
    {
        $this->authorize('create', User::class);

        $user = $creator->create($request->all());

        return new UserResource($user->load('profile'));
    }
}
