<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TasksControllerTest extends TestCase
{
   //test tasks create
   //method: POST
   //url:http://127.0.0.1:8000/api/tasks/1/addTask
   //10 times add tasks
   //data:{"title":"test", "content": "test", "duration": 5, "date":now()}
   public function testCreateTask()
   {
       for($i=0; $i<10; $i++)
       {
           $this->json('POST', 'http://127.0.0.1:8000/api/tasks/1/addTask', [
               'title' => 'test',
               'content' => 'test',
               'duration' => 5,
               'date' => date('Y-m-d H:i:s')
           ])->assertStatus(200);
       }
   }


   //test tasks update
   //method: PUT
   //url:http://127.0.0.1:8000/api/tasks/1/updateTask
   //10 times update tasks
   //data:{"title":"test", "content": "update", "duration": 5, "date":date('Y-m-d H:i:s')}
   public function testUpdateTask()
   {
       for($i=0; $i<10; $i++)
       {
           $this->json('PUT', 'http://127.0.0.1:8000/api/tasks/'.$i.'/update', [
               'title' => 'test',
               'content' => 'test',
               'duration' => 5,
               'date' => date('Y-m-d H:i:s')
           ])->assertStatus(200);
       }
   }





   //test set tasks as done
   //method: POST
   //url:http://127.0.0.1:8000/api/tasks/$i/done/1
   public function testSetTaskAsDone()
   {
       for($i=0; $i<10; $i++)
       {
           if($i%2==0)
           $this->json('POST', 'api/tasks/'.$i.'/done/1')
           ->assertStatus(200)
           ->assertJson(["response"=>true,"message"=>"Tache marquee comme fait","result"=>"Tache marquee comme fait"]);
           else
           $this->json('POST', 'api/tasks/'.$i.'/done/0')
           ->assertStatus(200)
           ->assertJson(["response"=>true,"message"=>"Tache marquee comme fait","result"=>"Tache marquee comme non fait"]);

       }
   }


   //test delete all tasks
   //method: DELETE
   //url:http://127.0.0.1:8000/api/tasks/1/deleteAll
//    public function testDeleteAllTask()
//    {
//        //$this->json('DELETE', 'api/tasks/1/deleteAll')->assertStatus(200);
//    }


}
