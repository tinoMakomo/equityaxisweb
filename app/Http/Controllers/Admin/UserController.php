<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Preference;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\ChangeUserPasswordRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $itemsPerPage = auth()->user()->preferences->items_per_page;
        $users = User::paginate($itemsPerPage);
        return view('admin.users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'bio' => $request->input('bio'),
            'linkedin' => $request->input('linkedin'),
            'twitter' => $request->input('twitter'),
            'phone' => $request->input('phone'),
            'user_type_id' => $request->input('user_type_id'),
            'password' => Hash::make($request->input('password'))
        ]);

        Preference::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin_users.index')->with(['success-message' => "User created successfully."]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $user = User::find($id);
        return view('admin.users.show')->withUser($user);
    }


    public function changeUserPassword(int $id)
    {
        $user = User::find($id);
        return view('admin.users.change_user_password')->withUser($user);
    }

    public function updateUserPassword(ChangeUserPasswordRequest $request, int $id)
    {
        $user = User::find($id);
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        return redirect()->route('admin.change_user_password', $id)->with(['success-message' => "Password updated successfully."]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::find($id);
        $user->update($request->except('_token'));

        return redirect()->route('admin_users.index')->with(['success-message' => "User updated successfully."]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $user = User::destroy($id);
        return redirect()->route('admin_users.index')->with(['success-message' => "User deleted successfully."]);
    }
}
