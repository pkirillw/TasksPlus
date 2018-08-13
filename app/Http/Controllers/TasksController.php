<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 10.04.2018
 * Time: 22:44
 */

namespace App\Http\Controllers;


use App\Pipelines;
use App\Tasks;
use App\Types;
use Dotzero\LaravelAmoCrm\Facades\AmoCrm;
use Illuminate\Http\Request;
use MongoDB\BSON\Type;

class TasksController
{
    public function changePipeline(Request $request)
    {
        if (empty($request)) {
            return 'error';
        }
        $task = Tasks::where([['id', '=', $request->taskId]])->first();
        $task->pipeline_id = $request->newPipelineId;
        $task->save();
        return response()->json($task);
        //return redirect()->action(
        //    'BoardController@Board', ['id' => $request->user_id]
        //);
    }

    public function getTaskAPI($id = 0)
    {
        $response = [];
        $task = Tasks::where([['id', '=', $id]])->first();
        if (!empty($task)) {

            $temp = $task->toArray();

            unset($temp['type_id']);
            unset($temp['pipeline_id']);
            $typeTask = Types::where([['id', '=', $task->type_id]])->first();
            $temp['type'] = $typeTask->toArray();
            $pipelineTask = Pipelines::where([['id', '=', $task->pipeline_id]])->first();
            $temp['pipeline'] = $pipelineTask->toArray();
            $temp['created_task_format'] = date('d.m.Y', $temp['created_task']);
            $temp['complite_till_format'] = date('d.m.Y', $temp['complite_till']);
            if ($temp['complite_till'] < time()) {
                $temp['flag_expired'] = true;
            } else {
                $temp['flag_expired'] = false;
            }
            $response = $temp;
        }
        return response()->json($response);

    }

    public function addTaskAPI(Request $request)
    {
        $newTask = new Tasks();
        $newTask->pipeline_id = $request->pipeline_id;
        $newTask->type_id = $request->type_id;
        $newTask->user_id = $request->user_id;
        $newTask->amo_id = $request->amo_id;
        $newTask->number_request = $request->number_request;
        $newTask->position = $request->position;
        $newTask->comment = $request->comment;
        $newTask->created_task = time();
        $newTask->complite_till = \DateTime::createFromFormat('d.m.Y', $request->complite_till)->format('U');
        $newTask->status = 0;
        $newTask->save();
        return response()->json($newTask->toArray());
    }

    public function editTaskAPI(Request $request)
    {
        $task = Tasks::where([['id', '=', $request->task_id]])->first();
        $task->pipeline_id = $request->pipeline_id;
        $task->type_id = $request->type_id;
        $task->user_id = $request->user_id;
        $task->amo_id = $request->amo_id;
        $task->number_request = $request->number_request;
        $task->position = $request->position;
        $task->comment = $request->comment;
        $task->created_task = time();
        $task->complite_till = \DateTime::createFromFormat('d.m.Y', $request->complite_till)->format('U');
        $task->status = 0;
        $task->save();
        return response()->json($task->toArray());
    }

    public function endTask($taskId)
    {
        if (empty($taskId)) {
            return 'error';
        }
        $task = Tasks::where([['id', '=', $taskId]])->first();
        $task->status = 1;
        $task->save();
        return response()->json([$taskId]);
    }

    public function changeStatus(Request $request)
    {
        if (empty($request->task_id)) {
            return 'error';
        }
        $task = Tasks::where([['id', '=', $request->task_id]])->first();
        $task->type_id = $request->type_id;
        $task->save();
        return redirect()->action(
            'BoardController@Board', ['id' => $request->user_id]
        );
    }

    public function changeTimer(Request $request)
    {
        if (empty($request->task_id)) {
            return 'error';
        }
        $task = Tasks::where([['id', '=', $request->task_id]])->first();
        $task->complite_till = \DateTime::createFromFormat('d.m.Y H:i', $request->complite_till)->format('U');
        $task->save();
        return redirect()->action(
            'BoardController@Board', ['id' => $request->user_id]
        );
    }

    public function changeText(Request $request)
    {
        if (empty($request)) {
            return 'error';
        }
        $task = Tasks::where([['id', '=', $request->taskId]])->first();
        $task->comment = $request->text;
        $task->save();

    }

    public function add(Request $request)
    {
        $newTask = new Tasks();
        $newTask->pipeline_id = $request->pipeline_id;
        $newTask->type_id = $request->type_id;
        $newTask->user_id = $request->user_id;
        $newTask->amo_id = $request->lead_id;
        $newTask->number_request = $request->number_request;
        $newTask->position = 0;
        $newTask->comment = $request->comment;
        $newTask->created_task = time();
        $newTask->complite_till = \DateTime::createFromFormat('d.m.Y', $request->complite_till)->format('U');
        $newTask->status = 0;
        $newTask->save();
        return redirect()->action(
            'BoardController@Board', ['id' => $request->user_id]
        );
        dd($request->all());
    }
    public function edit(Request $request)
    {

        $task = Tasks::where([['id', '=', $request->task_id]])->first();
        $task->pipeline_id = $request->pipeline_id;
        $task->type_id = $request->type_id;
        $task->user_id = $request->user_id;
        $task->number_request = $request->number_request;
        $task->position = 0;
        $task->comment = $request->comment;
        $task->created_task = time();
        $task->complite_till = \DateTime::createFromFormat('d.m.Y', $request->complite_till)->format('U');
        $task->status = 0;
        $task->save();
        return redirect()->action(
            'BoardController@Board', ['id' => $request->user_id]
        );
        dd($request->all());
    }

    public function getLeadTask($leadId = 0)
    {
        $response = [];
        $task = Tasks::where([['amo_id', '=', $leadId], ['status', '=', 0]])->get();
        if (!empty($task)) {
            foreach ($task as $item) {
                $temp = $item->toArray();

                unset($temp['type_id']);
                unset($temp['pipeline_id']);
                $typeTask = Types::where([['id', '=', $item->type_id]])->first();
                $temp['type'] = $typeTask->toArray();
                $pipelineTask = Pipelines::where([['id', '=', $item->pipeline_id]])->first();
                $temp['pipeline'] = $pipelineTask->toArray();
                $temp['created_task_format'] = date('d.m.Y', $temp['created_task']);
                $temp['complite_till_format'] = date('d.m.Y', $temp['complite_till']);
                if ($temp['complite_till'] < time()) {
                    $temp['flag_expired'] = true;
                } else {
                    $temp['flag_expired'] = false;
                }
                $response[] = $temp;
            }

        }
        return response()->json($response);
    }

    public function getLeads($text = '')
    {
        $client = AmoCrm::getClient();
        return response()->json(($client->lead->apiList([
            'query' => $text,
        ])));
    }
}