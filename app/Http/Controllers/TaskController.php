<?php

namespace App\Http\Controllers;

use App\Models\Task;
use DateTime;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $token)
    {
        if(!is_null($token)){
            $tasks = Task::Where('user_id', $this->getIdFromToken($token))->get();
            return response()->json(["response"=>true,"message"=>"Taches selectionnes","result"=>$tasks->toArray()]);
        }else
           return $this->error("Pas authentifier");

    }


    public function exportUserTasks(int $userId)
    {
        #
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,int $token)
    {
        $request->validate([
            'title' =>'required',
            'duration'=>'numeric|required',
            'content'=>'required',
            'date'=>'required|date'
        ]);
        $task = Task::create([
            "date"=> $request->input("date"),
            "duration"=>$request->input("duration"),
            "content"=>$request->input("content"),
            "title"=>$request->input("title"),
            "user_id"=>$this->getIdFromToken($token)
        ]);
        if(is_null($task)) return $this->error("Creation de la tache impossible");
        return response()->json(["response"=>true,"message"=>"Tache creee avec succes","result"=>$task]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function setStatus(int $id,int $status)
    {
        if($status == 1)
            if(Task::where("id",$id)->update([
                'done'=>true
            ]))return response()->json(["response"=>true,"message"=>"Tache marquee comme fait","result"=>"Tache marquee comme fait"]);
        if(Task::where("id",$id)->update([
            'done'=>false
        ]))return response()->json(["response"=>true,"message"=>"Tache marquee comme non fait","result"=>"Tache marquee comme non fait"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $taskId)
    {
        $request->validate([
            'title' =>'required',
            'duration'=>'numeric|required',
            'content'=>'required',
            'date'=>'required|date'
        ]);
        $task = Task::find($taskId);
        if(is_null($task)) return $this->error("La tache n'existe plus");
        $task->title = $request->input('title');
        $task->date = $request->input("date");
        $task->duration = $request->input("duration");
        $task->content = $request->input("content");
        $task->save();
        return response()->json(["response"=>true,"message"=>"Tache mis a jour","result"=>$task]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function delete(int $id)
    {
        if(Task::destroy($id)) return response()->json(["response"=>true,"message"=>"Tache supprimee","result"=>"Tache supprimee"]);
        return $this->error("La tache n'a pas pu etre supprimee");
    }


    /**
     *
     */
    public function deleteAllUserTasks(int $userId)
    {
        # code...
    }
}
