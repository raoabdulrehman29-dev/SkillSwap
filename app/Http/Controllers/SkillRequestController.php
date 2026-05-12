<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\SkillRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillRequestController extends Controller
{
    public function store(Request $request,Skill $skill){
        if(Auth::id() == $skill->user_id)
        {
           return back()->with('ypu can not request you own skill');
         }
         else{
         $exists=SkillRequest::where('user_id',Auth::id())->where('skill_id',$skill->id);
         if($exists)
            {
                return back()->with('abort','you  have already made the request');
            }
        SkillRequest::create([
            'user_id' => Auth::id(),
            'skill_id' => $skill->id,
            ]);

            return back()->with('success','request ');
         }

    }
}
