<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    public function index()
    {
        return Task::all();
    }
    public function show($task)
    {
        return Task::find($task);
    }
    public function create(Request $req)
    {
        if($req->role != '2'){
            return 'You must be an PRODUCT_OWNER to create tasks.';
        }
        else {
            $task = new Task;
            $task->title=$req->title;
            $task->description=$req->description;
            $task->project_id=$req->project_id;
            $task->user_id=$req->user_id;
            $result=$task->save();
            if($result) {
              return 'file created';
            }
            else {
              return 'failed';
            }
        }
    }
    public function update(Request $req, Task $task)
    {
        $task = Task::find($task);
        $task->title=$req->title;
        $task->description=$req->description;
        $task->status=$req->status;
        $task->project_id=$req->project_id;
        $task->user_id=$req->user_id;
        $result=$task->save();
        if($result) {
          return 'file updated';
        }
        else {
          return 'failed';
        }
    }
    public function patch(Request $req, $task)
    {
        $task = Task::find($task);
        if(!in_array($req->status, ['IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'])){
            return "You must provide task status from following ['IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED']";
        }
        else{
            $task->status=$req->status;
            $result=$task->save();
            if($result) {
              return 'file updated';
            }
            else {
              return 'failed';
            }
        }
    }
    public function destroy(Task $task)
    {
        $user = Task::find($task);
        $result = $task->delete();
        if($result){
          return "records has been deleted";
        }
        else {
          return "error";
        }
    }
}
