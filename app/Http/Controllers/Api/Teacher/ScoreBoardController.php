<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\ScoreBoardResource;
use App\Models\StudentChallenge;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScoreBoardController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get scoreBoard
        $scoreBoard = 
        DB::select("SELECT * FROM (
        	SELECT ROW_NUMBER() OVER(ORDER BY sum(sc.score) desc, sum(sc.created_at) asc) AS ranking, sum(sc. score) as score, sc.student_id, s.name, s.image
            FROM students s LEFT JOIN student_challenges sc ON(s.id = sc.student_id)
            GROUP By s.id
        ) AS a
        WHERE a.name LIKE '%" . request()->name . "%'
        LIMIT 10");

        //return with Api Resource
        return new ScoreBoardResource(true, 'List Data ScoreBoard', $scoreBoard);
    }
}

