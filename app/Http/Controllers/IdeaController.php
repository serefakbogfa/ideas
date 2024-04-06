<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        return view('ideas.show', compact('idea'));
    }

    public function store()
    {
        $validated = request()->validate([
            'content' => 'required|min:5|max:50'
        ]);
        $validated['user_id'] = auth()->id();

        Idea::create($validated);

        return redirect()->route('dashboard')->with('success', ' Idea created Successfully!');
    }


    public function destroy(Idea $idea)
    {
        $this->authorize('idea.delete', $idea);
        $idea->delete();

        return redirect()->route('dashboard')->with('success', ' Idea DELETED Successfully!');
    }


    public function edit(Idea $idea)
    {
        $this->authorize('idea.edit', $idea);
        $editing = true;
        return view('ideas.show', compact('idea', 'editing'));
    }


    public function update(Idea $idea)
    {
        $this->authorize('idea.edit', $idea);
        $validated = request()->validate([
            'content' => 'required|min:5|max:50'
        ]);
        $idea->update($validated);
        return redirect()->route('ideas.show', $idea->id)->with('success', ' Idea update Successfully!');
    }
}
