<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = User::orderBy('role', 'ASC')->orderBy('id', 'DESC')->get();
        return view('content.admin.member.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register');
    }

    public function createInAdmin()
    {
        return view('content.admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login.index')
            ->with('success', 'Register berhasil');
    }

    public function storeInAdmin(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        User::create([
            'role' => $request->role,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('member.index')->with('success', 'Berhasil ditambah!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = User::find($id);
        return view('content.admin.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'role' => 'nullable|in:admin,user',
            'name' => 'nullable|string|max:100',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'confirm_password' => 'nullable|same:password'
        ]);

        $user = User::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        unset($data['confirm_password']);

        $user->update($data);

        return redirect()->route('member.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = User::find($id);
        $member->delete();

        return redirect()->route('member.index')->with('success', 'Delete Berhasil!');
    }
}
