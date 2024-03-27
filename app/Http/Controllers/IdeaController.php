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
        // Idea::create(

        //     [
        //         'content' => request()->get('content', ''),
        //     ]
        // );
        return redirect()->route('dashboard')->with('success', ' Idea created Successfully!');
    }


    public function destroy(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, "");
        }
        $idea->delete();

        return redirect()->route('dashboard')->with('success', ' Idea DELETED Successfully!');
    }


    public function edit(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, "");
        }
        $editing = true;
        return view('ideas.show', compact('idea', 'editing'));
    }


    public function update(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            abort(404, "");
        }
        $validated = request()->validate([
            'content' => 'required|min:5|max:50'
        ]);
        $idea->update($validated);
        return redirect()->route('ideas.show', $idea->id)->with('success', ' Idea update Successfully!');
    }
}
