<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with('user')
            ->where('user_id', '!=', Auth::id())
            ->latest()
            ->get();

        return Inertia::render('Marketplace', ['skills' => $skills]);
    }


    // public function index1(){
    //     $skills=Skill::with('user')->where('user_id' , '!=', Auth::id())->latest()->get();
    //     return  Inertia::render('marketplace',['skills' => $skills]);
    // }

    public function create()
    {
        return Inertia::render('Skills/Create');
    }

    public function store(Request $request)
    {
        $validated=$request->validate([
            'title' => 'required|max:255|string',
            'description' => 'required',
            'category' => 'required',
            'type' => 'required|in:offering,seeking',
        ]);

        Auth::user()->skills()->create($validated);

        return redirect()->route('skills.my')->with('message', 'Skill added successfully');
    }
    public function edit(Skill $skill)
    {
        abort_if(Auth::id() !== $skill->user_id, 403);

        return Inertia::render('Skills/Update', [
            'skill' => $skill,
        ]);
    }

    public function update(Request $request, Skill $skill)
    {
        abort_if(Auth::id() !== $skill->user_id, 403);

        $validated = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10',
            'category' => 'required',
            'type' => 'required|in:offering,seeking',
        ]);

        $skill->update($validated);

        return redirect()->route('skills.my')->with('message', 'Skill updated successfully');
    }

















    // public function store1(Request $request){
    //   $request->validate([
    //     'title' => 'required|max:255|string',
    //     'description' => 'required',
    //     'category' => 'required',
    //     'type' => 'required|in:offering,seeking', 
    //   ]);

    //   Auth::user()->skills()->create($request->validated());
    //    return redirect()->route('skills.my')->with('message','skills added successfully');
    // }

    public function mySkills()
    {
        $skills = Auth::user()->skills()->latest()->get();

        return Inertia::render('Skills/MySkills', ['skills' => $skills]);
    }
    // public function myskills1(){
    //    $skills= Auth::user()->skills()->latest()->get();
    //     return  Inertia::render('Skills/MySkills',['skills' => $skills]);
    // }


    //Gate in controller Practice Code

    // public function gate(){
      
    // if(Auth::user())
    //     {
    //           $skills=Skill::with('user')->latest()->get();

    //     return $skills;
    //     }
    //     else
    //         {
    //             return 403;
    //         }
    // }
       public function gate(){
      
  
        
          $skills=Skill::with('user')->latest()->get();

        return $skills;
      
    }
}
