<?php
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 10.04.2018
 * Time: 23:02
 */

namespace App\Http\Controllers;


use App\Pipelines;
use App\Tasks;
use App\Types;

class BoardController extends Controller
{

    public function board($id = 0)
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 0]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
            } else {
                $task['flag_expired'] = false;
            }
            $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;

        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }

    public function ends($id = 0)
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 1]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
            } else {
                $task['flag_expired'] = false;
            }
            $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;

        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }

    public function openBoard($id = 0)
    {
        return redirect()->action(
            'BoardController@Board', ['id' => $id]
        );
    }

    public function expired($id = 0)
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 0]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
                $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;
            } else {
                $task['flag_expired'] = false;
            }
        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }

    public function today($id = 0)
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 0]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
            } else {
                $task['flag_expired'] = false;
            }
            if ($task['complite_till'] < time() + 60 * 60 * 24) {
                $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;
            }

        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }

    public function week($id = 0)
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 0]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
            } else {
                $task['flag_expired'] = false;
            }
            if ($task['complite_till'] < time() + 60 * 60 * 24 * 7) {
                $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;
            }
        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }

    public function month($id = 0)
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 0]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
            } else {
                $task['flag_expired'] = false;
            }
            if ($task['complite_till'] < time() + 60 * 60 * 24 * 30) {
                $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;
            }
        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }

    public function search($id = 0, $text = '')
    {
        if ($id == 0) {
            return 'Error';
        }
        $templateData = [];
        $pipelines = Pipelines::all();
        $typesTasks = Types::all()->toArray();
        $userTasks = Tasks::where([['user_id', '=', $id], ['status', '=', 0]])->get();
        foreach ($pipelines as $pipeline) {
            $templateData['board'][$pipeline->id] = [
                'id' => $pipeline->id,
                'name' => $pipeline->name,
                'position' => $pipeline->position,
                'style' => $pipeline->style,
                'tasks' => []
            ];
        }
        foreach ($userTasks as $userTask) {
            $task = $userTask->toArray();
            $keyTypeTask = array_search($userTask->type_id, array_column($typesTasks, 'id'));
            if ($keyTypeTask !== false) {
                $task['type'] = $typesTasks[$keyTypeTask]['name'];
            }
            if ($task['complite_till'] < time()) {
                $task['flag_expired'] = true;
            } else {
                $task['flag_expired'] = false;
            }
            if (stripos($task['number_request'], $text) !== false || stripos($task['comment'], $text) !== false) {
                $templateData['board'][$userTask->pipeline_id]['tasks'][] = $task;
            }
        }
        $templateData['user']['id'] = $id;
        echo view('board2', $templateData);
    }


}