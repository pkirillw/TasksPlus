<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"
      integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

<link href="https://tasks.pkirillw.ru/public/css/newKanban.css" rel="stylesheet">
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
<script src="https://unpkg.com/ionicons@4.1.2/dist/ionicons.js"></script>

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
<script src="https://tasks.pkirillw.ru/public/js/kanban.js"></script>

<link rel="manifest" href="/public/manifest.json"/>
<script charset="UTF-8"
        src="//cdn.sendpulse.com/9dae6d62c816560a842268bde2cd317d/js/push/c0d74035efdcf15c37ae4d8cc483f654_1.js"
        async></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.ru.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.standalone.min.css" />
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<meta name="user_id" content="{{ $user['id'] }}"/>

<nav class="navbar navbar-expand-lg navbar-light" style="
    background-color: #fff;
    height: 65px;
    padding: 0px;
    border-bottom: 1px solid #e8eaeb;
    ">
    <span class="navbar-brand mb-0 h1" style="
    border-right: 1px solid #e8eaeb;
    height: 100%;
    margin: 0;
    padding: 16px 28px;
">ДЕЛА</span>
    <div class="navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav" style="
    height: 100%;
    padding:  13px 5px;
    border-right: 1px solid #e8eaeb;
">
            <div class="dropdown" style="
    min-width: 50px;
    padding: 5px 23px;
">
                <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                    <img src="/public/images/outline-center_focus_strong-24px.svg" style="
    width: 28px;
">
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="/board/{{$user['id']}}">Все <span
                                class="sr-only">(current)</span></a>
                    <a class="dropdown-item" href="/expired/{{$user['id']}}">Просроченные <span
                                class="sr-only">(current)</span></a>
                    <a class="dropdown-item" href="/today/{{$user['id']}}">Сегодня </a>
                    <a class="dropdown-item" href="/week/{{$user['id']}}">Неделя </a>
                    <a class="dropdown-item" href="/month/{{$user['id']}}">Месяц </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/ends/{{$user['id']}}">Завершенные </a>
                </div>
            </div>
        </div>
        <form class="form-inline my-2 my-lg-0" style="
    padding: 0 10px;
    width: 75%;
    border-right: 1px solid #e8eaeb;
    height: 100%;

    ">
            <div class="input-group mb-3" style="
    width: -webkit-fill-available;
    margin: inherit !important;
">
                <input type="text" class="form-control" id="searchText" placeholder="Поиск" aria-label="Поиск"
                       aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" style="color: #fff;"
                            onclick="searchit({{$user['id']}});">Поиск
                    </button>
                </div>
            </div>
        </form>

        </span>
    </div>
    </div>

    <a class="btn btn-primary" style="color: #f5f5f5;margin: 10px;text-transform: uppercase;"
       data-toggle="modal" data-target="#createTask">+ Добавить задачу</a>
</nav>
<div class="container-fluid">
    <div class="row">
        @foreach($board as $pipeline)
            <div class="col-sm">
                <div class="pipeline ">
                    <div class="pipeline-header font-weight-bold">
                        {{$pipeline['name']}}<br>
                    </div>
                    <div class="pipeline-body" id="pipeline{{$pipeline['id']}}">
                        @foreach($pipeline['tasks'] as $task)
                            <div class="card task border_{{$task['type']}}" id="task{{$task['id']}}" draggable="true">
                                <div class="card-header " style="
                                background: #fff;    border-bottom: 0px;
">
                                    <h5 class="card-title"><a
                                                class="color_{{$task['type']}}"
                                                href="https://novyetechnologii.amocrm.ru/leads/detail/{{$task['amo_id']}}"
                                                target="_top">{{$task['number_request']}}</a>
                                        <ion-icon name="ios-more" style="    float: right;"></ion-icon>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        @if($task['flag_expired'] == true)
                                            <img src="https://tasks.pkirillw.ru/public/images/icon_expired.svg"
                                                 width="18px" style="">
                                        @endif
                                        ({{date('d.m.Y H:i:s', $task['complite_till'])}})
                                    </h6>

                                </div>

                                <div class="card-body" style="padding: 5px 15px; ">
                                    <p>{{$task['comment']}}</p>
                                <!--<textarea class="form-control" id="comment{{$task['id']}}" rows="3"
                                              style="resize: none;"
                                              onblur="saveText({{$task['id']}});">{{$task['comment']}}</textarea> !-->
                                    <div class="row text-center" style="padding-top: 15px ; ">
                                        <div class="buttons" style="font-size: 26px; margin: 0 auto;">
                                            <span data-toggle="tooltip" data-placement="top" title="Изменить задачу">
                                                <img src="https://tasks.pkirillw.ru/public/images/icon_edit.svg"
                                                     width="24px" aria-hidden="true" data-toggle="modal"
                                                     data-target="#changeStatus"
                                                     onclick="editTask({{$task['id']}})">
                                                </span>
                                            <span data-toggle="tooltip" data-placement="top" title="Завершить задачу">
                                                <img aria-hidden="true"
                                                     src="https://tasks.pkirillw.ru/public/images/outline-done_outline-24px.svg"
                                                     onclick="endTask({{$task['id']}})">
                                                    </span>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>

<div class="modal fade" id="createTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создание задачи</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="/tasks/add" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{$user['id']}}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Наименование сделки</label>
                        <input type="text" class="form-control" id="name_lead"
                               placeholder="ХХ-0000-00">
                        <div class="progress" id="loaderLeads" style="height: 5px; margin-top: 5px; display: none">
                            <div class="progress-bar" id="innerLoaderLeads" role="progressbar" style="width: 0%;"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <select style="margin-top: 5px; display: none" class="form-control" name="lead_id"
                                id="lead_select">
                            <option disabled="disabled">----</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Воронка</label>
                        <select name="pipeline_id" class="form-control">
                            <option value="1">Качество запроса</option>
                            <option value="2">Назначен поставщик</option>
                            <option value="3">На контроль</option>
                            <option value="4">Выполнен</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Цвет задачи</label>
                        <select name="type_id" class="form-control">
                            <option style="background: #ff0000; color: #000;" value="1">Красный</option>
                            <option style="background: #ffc000; color: #000;" value="2">Желтый</option>
                            <option style="background: #92d050; color: #000;" value="3">Зеленый</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Наименование задачи</label>
                        <input type="text" name="number_request" class="form-control" id="exampleInputEmail1"
                               placeholder="№123456">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Комментарий</label>
                        <textarea name="comment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Время окончания задачи</label>
                        <div class="input-group mb-3">
                            <input name="complite_till" type='text' id='datetimepicker1' class="form-control"
                                   aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><span
                                            class="ion-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактирование задачи <span id="edit_nameTask_header">TEST</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2 class="text-center">Редактирование дела <span id="edit_nameTask">TEST</span></h2>
                <form role="form" action="/tasks/edit" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="user_id" value="{{$user['id']}}">
                    <input type="hidden" name="task_id" value="" id="edit_taskId">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Воронка</label>
                        <select name="pipeline_id" id="edit_pipelineId" class="form-control">
                            <option value="1">Качество запроса</option>
                            <option value="2">Назначен поставщик</option>
                            <option value="3">На контроль</option>
                            <option value="4">Выполнен</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Цвет задачи</label>
                        <select name="type_id" id="edit_typeId" class="form-control">
                            <option style="background: #ff0000; color: #000;" value="1">Красный</option>
                            <option style="background: #ffc000; color: #000;" value="2">Желтый</option>
                            <option style="background: #92d050; color: #000;" value="3">Зеленый</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Наименование задачи</label>
                        <input type="text" name="number_request" class="form-control" id="edit_numberRequest"
                               placeholder="№123456">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Комментарий</label>
                        <textarea name="comment" id="edit_comment" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Время окончания задачи</label>
                        <div class="input-group mb-3">
                            <input name="complite_till" type='text' id='datetimepicker2' class="form-control"
                                   aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><span
                                            class="ion-calendar"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
