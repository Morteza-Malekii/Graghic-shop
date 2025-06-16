<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.users.create', compact('users'));

    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        DB::transaction(function () use($data){
            User::create($data);
        });
        return redirect()
                ->route('admin.users.index')
                ->with('success','user created successfully!');

    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()
        ->with('success', "User deleted successfully!");
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function update(UpdateRequest $request , User $user)
    {
        $data = $request->validated();
        if (!empty($data['password']))
        {
            $data['password'] = hash::make($data['password']);
        }else{
            unset($data['password']);
        }
        DB::transaction(function() use ($data,$user)
        {
            $user->update($data);
        });
        return redirect()
        ->route('admin.users.index')
        ->with('success', "User update successfully!");
    }

}
