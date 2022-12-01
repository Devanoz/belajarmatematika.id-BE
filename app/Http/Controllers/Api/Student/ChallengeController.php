<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChallengeResource;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get challenge
        $challenge = Challenge::when(request()->title, function ($challenge) {
            $challenge = $challenge->where('title', 'like', '%' . request()->title . '%');
        })->latest()->get();

        //return with Api Resource
        return new ChallengeResource(true, 'List Data Challenge', $challenge);
    }
}
