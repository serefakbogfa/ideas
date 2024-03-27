<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(User $users)
    {
        return view('users.show', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $users)
    {
        $editing =true;
        return view('users.show', compact('users','editing'));
    }
//11 dakikadan  
    /**
     * Update the specified resource in storage.
     */
    public function update(User $users)
    {
        return view('users.update', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
