<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
     

   
    public function store()
    {
    }

  
    public function show(User $user)
    {
        $ideas = $user->ideas()->paginate(5);
        return view('users.show', compact('user', 'ideas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $editing = true;
        $ideas = $user->ideas()->paginate(5);

        return view('users.edit', compact('user', 'editing', 'ideas'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(User $user)
    {
        $validated = request()->validate([
            'name' => 'required|min:5|max:40',
            'bio' => 'nullable|min:5|max:240',
            'image' => 'image'
        ]);
        if (request()->has('image')) {

            $imagePath = request()->file('image')->store('profile', 'public');
            $validated['image'] = $imagePath;

            Storage::disk('public')->delete($user->image);
        }

        $user->update($validated);

        return redirect()->route('profile');
        // return view('users.update', compact('user'));
    }
   

    public function profile()
    {
        return $this->show(auth()->user());
    }
  
}
