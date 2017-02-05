<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Examples extends Controller
{
    /**
     * @param  int  $id
     * @return Response
     */
    public function show($lessonid = 0)
    {
        return view('vuejs/lessons/lesson'.$lessonid, [
            'lesson_id' => $lessonid
        ]);
    }
}
