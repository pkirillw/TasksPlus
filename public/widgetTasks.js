var TaskPlusLibrary = {};
var TaskInfo = {};
var leadInfo = {};
var tempWidget = {};
TaskPlusLibrary.GenerateLeftArea = function (widget) {

    var html_data = '' +
        '<link rel="stylesheet" href="https://toert.github.io/Isolated-Bootstrap/versions/3.3.7/iso_bootstrap3.3.7min.css">' +
        '<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">' +
        '<script src="https://unpkg.com/ionicons@4.1.2/dist/ionicons.js"></script>' +
        '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"' +
        '        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"' +
        '        crossorigin="anonymous"></script>' +
        '<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.ru.min.js"></script>' +
        '<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>' +
        '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker3.standalone.min.css" />' +

        '<meta charset="utf-8">\n' +
        '<style>\n' +
        '    .leftTasks_panel {\n' +
        '        border: 1px solid #aaa;\n' +
        '        font: 15px \'PT Sans\',Arial,sans-serif;\n' +
        '        border-radius: 3px;\n' +
        '        border-left: 5px solid;\n' +
        '        background: #fff;\n' +
        '        margin-bottom: 10px;' +
        '    }\n' +
        '    .leftTasks_panel_header {\n' +
        '        padding: 10px;\n' +
        '    }\n' +
        '    .border_success {\n' +
        '        border-left-color: #24a65c !important;\n' +
        '    }\n' +
        '\n' +
        '    .border_danger {\n' +
        '        border-left-color: #f2984a !important;\n' +
        '    }\n' +
        '\n' +
        '    .border_warning {\n' +
        '        border-left-color: #eb5757 !important;\n' +
        '    }\n' +
        '    .leftTasks_header_title {\n' +
        '        font-size: 16px;\n' +
        '        font-weight: bold;\n' +
        '        color: #000;\n' +
        '    }\n' +
        '    .leftTasks_header_date {\n' +
        '        font-size: 14px;\n' +
        '        color: #6c757d!important;\n' +
        '    }\n' +
        '    .leftTasks_panel_body {\n' +
        '        padding: 10px;\n' +
        '    }\n' +
        '    .leftTasks_comment {\n' +
        '        padding-bottom: 10px;\n' +
        '    }\n ' +
        ' .leftTasks_addTask {\n' +
        '        text-align: center;\n' +
        '        margin: 10px;\n' +
        '    }' +
        '    .leftTasks_menu {\n' +
        '        text-align: center;' +
        '    }\n' +
        '</style>\n' +
        '<div class="leftTasks_addTask" onclick="TaskPlusLibrary.addTask();">\n' +
        '       <span style="color: #4d89ed;\n' +
        '    text-transform: uppercase;\n' +
        '    font-weight: bold;">\n' +
        '           <img src="https://tasks.pkirillw.ru/public/images/outline-add-24px.svg" style="    margin: -6px 0px;">\n' +
        '           Добавить дело\n' +
        '       </span>\n' +
        '    </div>' +
        '<div class="leftTasks_allTasks"></div>';


    widget.render_template(
        {
            caption: {
                class_name: 'task_plus_widget' //имя класса для обертки разметки
            },
            body: html_data,//разметка
            render: '' //шаблон не передается
        },
        {
            name: 'taskPlus'
        }
    );
    $('.task_plus_widget').css('background', ' #9e9e9e');
    TaskPlusLibrary.getData();

};

TaskPlusLibrary.renderTasks = function () {
    if (TaskInfo.length > 0) {
        TaskInfo.forEach(function (item, i) {
            var html_data = '<div class="leftTasks_panel border_' + item.type.name + '"  id="leftTask_' + item.id + '">\n' +
                '    <div class="leftTasks_panel_header" onclick="TaskPlusLibrary.showFullTask(\'' + item.id + '\')">\n' +
                '        <div class="leftTasks_header_title">\n' +
                '            ' + item.number_request + '<br>\n' +
                '            <small>' + item.pipeline.name + '</small>\n' +
                '        </div>\n' +
                '        <div class="leftTasks_header_date">\n';
            if (item.flag_expired) {
                html_data = html_data + ' <img src="https://tasks.pkirillw.ru/public/images/icon_expired.svg" width="16px" style="\n' +
                    '    margin: -4px;\n' +
                    '">';
            }
            html_data = html_data +
                '            (' + item.complite_till_format + ')\n' +
                '        </div>\n' +
                '    </div>\n' +
                '    <div class="leftTasks_panel_body" id="leftTask_body_' + item.id + '"  style="display: none;">\n' +
                '        <div class="leftTasks_comment">\n' +
                '            <p>' + item.comment + '</p>\n' +
                '        </div>\n' +
                '        <div class="leftTasks_menu">\n' +
                '            <span data-toggle="tooltip" data-placement="top" title="Изменить задачу">\n' +
                '<img src="https://tasks.pkirillw.ru/public/images/icon_edit.svg" width="24px" onclick="TaskPlusLibrary.editTask(\'' + i + '\')">\n' +
                '                                                </span>\n' +
                '            <span data-toggle="tooltip" data-placement="top" title="Завершить задачу">\n' +
                '<img src="https://tasks.pkirillw.ru/public/images/outline-done_outline-24px.svg" onclick="TaskPlusLibrary.endTask(\'' + i + '\')">\n' +
                '                                                    </span>\n' +
                '        </div>\n' +
                '    </div>\n' +
                '</div>\n';
            $(".leftTasks_allTasks").append(html_data);
        });
    }
}

TaskPlusLibrary.showFullTask = function (id) {
    $("#leftTask_body_" + id).toggle("slow", function () {
    });
};

TaskPlusLibrary.editTask = function (id) {
    var localTask = TaskInfo[id];
    data = '<div class="bootstrap">' +
        '<h2 class="text-center">Редактирование дела ' + localTask.name + '</h2>' +
        '<div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Воронка</label>\n' +
        '                        <select name="pipeline_id" class="form-control">';
    if (localTask.pipeline.id === 1) {
        data = data + '<option value="1" selected>Качество запроса</option>';
    } else {
        data = data + '<option value="1" >Качество запроса</option>';
    }
    if (localTask.pipeline.id === 2) {
        data = data + '<option value="2" selected>Назначен поставщик</option>';
    } else {
        data = data + '<option value="2" >Назначен поставщик</option>';
    }
    if (localTask.pipeline.id === 3) {
        data = data + '<option value="3" selected>На контроль</option>';
    } else {
        data = data + '<option value="3" >На контроль</option>';
    }
    if (localTask.pipeline.id === 4) {
        data = data + '<option value="4" selected>Выполнен</option>';
    } else {
        data = data + '<option value="4" >Выполнен</option>';
    }
    data = data +
        '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Цвет задачи</label>\n' +
        '                        <select name="type_id" class="form-control">\n';
    if (localTask.type.id === 1) {
        data = data + '<option style="background: #ff0000; color: #000;" value="1" selected>Красный</option>';
    } else {
        data = data + '<option style="background: #ff0000; color: #000;" value="1">Красный</option>';
    }
    if (localTask.type.id === 2) {
        data = data + '<option style="background: #ffc000; color: #000;" value="2" selected>Желтый</option>';
    } else {
        data = data + '<option style="background: #ffc000; color: #000;" value="2">Желтый</option>';
    }
    if (localTask.type.id === 3) {
        data = data + '<option style="background: #92d050; color: #000;" value="3" selected>Зеленый</option>';
    } else {
        data = data + '<option style="background: #92d050; color: #000;" value="3">Зеленый</option>';
    }
    data = data +
        '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Наименование задачи</label>\n' +
        '                        <input type="text" name="number_request" class="form-control" id="exampleInputEmail1"\n' +
        '                               placeholder="№123456" value="' + localTask.number_request + '">\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Комментарий</label>\n' +
        '                        <textarea name="comment" class="form-control" rows="3">' + localTask.comment + '</textarea>\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                       <label>Время окончания задачи</label>\n' +
        '                       <div class="input-group">\n' +
        '                           <input  class="form-control" name="complite_till" type="text" value="' + localTask.complite_till_format + '" id="datetimepicker1">\n' +
        '                           <div class="input-group-addon"><span class="ion-calendar"></span></div>\n' +
        '                       </div>\n' +
        '                    </div>\n' +
        '                    <div class="text-center">\n' +
        '                        <button type="submit" class="btn btn-primary modal-body__close" onclick="" style="\n' +
        '    position: inherit;\n' +
        '">Отправить</button>\n' +
        '                    </div>\n' +
        '</div>';
    modal = new Modal({
        class_name: 'modal-window',
        init: function ($modal_body) {
            var $this = $(this);
            $modal_body
                .trigger('modal:loaded') //запускает отображение модального окна
                .html(data)
                .trigger('modal:centrify')  //настраивает модальное окно
                .append('<span class="modal-body__close"><span class="icon icon-modal-close"></span></span>');
        },
        destroy: function () {
        }
    });
    console.log(id);
};

TaskPlusLibrary.addTask = function () {
    leadInfo = {
        id: AMOCRM.data.current_card.id,
        name: $('[name="lead[NAME]"]').text()
    };
    console.log(leadInfo);
    data = '<div class="bootstrap">' +
        '<h2 class="text-center">Создание "Дела" для сделки ' + leadInfo.name + '</h2>' +
        '<div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Воронка</label>\n' +
        '                        <select name="pipeline_id" class="form-control">\n' +
        '                            <option value="1">Качество запроса</option>\n' +
        '                            <option value="2">Назначен поставщик</option>\n' +
        '                            <option value="3">На контроль</option>\n' +
        '                            <option value="4">Выполнен</option>\n' +
        '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Цвет задачи</label>\n' +
        '                        <select name="type_id" class="form-control">\n' +
        '                            <option style="background: #ff0000; color: #000;" value="1">Красный</option>\n' +
        '                            <option style="background: #ffc000; color: #000;" value="2">Желтый</option>\n' +
        '                            <option style="background: #92d050; color: #000;" value="3">Зеленый</option>\n' +
        '                        </select>\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Наименование задачи</label>\n' +
        '                        <input type="text" name="number_request" class="form-control" id="exampleInputEmail1"\n' +
        '                               placeholder="№123456" value="' + leadInfo.name + '">\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                        <label for="exampleInputEmail1">Комментарий</label>\n' +
        '                        <textarea name="comment" class="form-control" rows="3"></textarea>\n' +
        '                    </div>\n' +
        '                    <div class="form-group">\n' +
        '                       <label>Время окончания задачи</label>\n' +
        '                       <div class="input-group">\n' +
        '                           <input  class="form-control" name="complite_till" type="text" id="datetimepicker1">\n' +
        '                           <div class="input-group-addon"><span class="ion-calendar"></span></div>\n' +
        '                       </div>\n' +
        '                    </div>\n' +
        '                    <div class="text-center">\n' +
        '                        <button type="submit" class="btn btn-primary modal-body__close" onclick="TaskPlusLibrary.addTaskFunction()"style="\n' +
        '    position: inherit;\n' +
        '">Отправить</button>\n' +
        '                    </div>\n' +
        '</div>';
    modal = new Modal({
        class_name: 'modal-window',
        init: function ($modal_body) {
            var $this = $(this);
            $modal_body
                .trigger('modal:loaded') //запускает отображение модального окна
                .html(data)
                .trigger('modal:centrify')  //настраивает модальное окно
                .append('<span class="modal-body__close"><span class="icon icon-modal-close"></span></span>');
            $('#datetimepicker1').datepicker({
                format: "dd.mm.yyyy",
                language: "ru"
            });
        },
        destroy: function () {
        }
    });
};

TaskPlusLibrary.addTaskFunction = function () {
    var newTaskInfo = {
        amo_id: leadInfo.id,
        pipeline_id: $('[name="pipeline_id"]').val(),
        type_id: $('[name="type_id"]').val(),
        user_id: AMOCRM.data.current_card.user.id,
        number_request: leadInfo.name,
        position: 0,
        status: 0,
        complite_till: $('[name="complite_till"]').val(),
        comment: $('[name="comment"]').val()
    };
    self.crm_post(
        'https://tasks.pkirillw.ru//tasks/addAPI',
        newTaskInfo,
        function (data) {
            console.log(data);
            TaskPlusLibrary.getData();
        },
        'json',
        function () {
            alert('Error');
        }
    )
    console.log(newTaskInfo);
};

TaskPlusLibrary.changeTimer = function (id) {
    data = 'changeTimer';
    modal = new Modal({
        class_name: 'modal-window',
        init: function ($modal_body) {
            var $this = $(this);
            $modal_body
                .trigger('modal:loaded') //запускает отображение модального окна
                .html(data)
                .trigger('modal:centrify')  //настраивает модальное окно
                .append('<span class="modal-body__close"><span class="icon icon-modal-close"></span></span>');
        },
        destroy: function () {
        }
    });
    console.log(id);
};
TaskPlusLibrary.endTask = function (id) {
    var innerTaskInfo = TaskInfo[id];
    data = '<style>\n' +
        '    .modalTasks_endTask_title {\n' +
        '        font-size: 18px;\n' +
        '        text-align: center;\n' +
        '        margin: 10px 0 25px;\n' +
        '        padding: 0 5px 10px;\n' +
        '        border-bottom: 1px solid #ddd;\n' +
        '    }\n' +
        '\n' +
        '    .modalTasks_endTask_buttons {\n' +
        '        min-height: 25px;\n' +
        '    }\n' +
        '\n' +
        '    button.modalTasks_endTask_button {\n' +
        '        padding: 7px;\n' +
        '        border-radius: 4px;\n' +
        '        font-weight: 600;\n' +
        '        border: 1px solid;\n' +
        '        cursor: pointer;' +
        '    }\n' +
        '</style>\n' +
        '<div class="modalTasks_endTask_main">\n' +
        '    <div class="modalTasks_endTask_title">\n' +
        '        Вы уверены что хотите закрыть задачу <br>"' + innerTaskInfo.number_request + '"\n' +
        '    </div>\n' +
        '    <div class="modalTasks_endTask_buttons">\n' +
        '        <button class="modalTasks_endTask_button modal-body__close" onclick="TaskPlusLibrary.endTaskFunction(' + innerTaskInfo.id + ', ' + id + ')" style="\n' +
        '    background: #e53935;\n' +
        '    color: #fff;\n' +
        '    border-color: #b71c1c;\n' +
        '    position: absolute;\n' +
        '    left: 30px;\n' +
        '    width: 100px;\n' +
        '    top: initial;' +
        '">Закрыть\n' +
        '        </button>\n' +
        '        <button class="modalTasks_endTask_button modal-body__close" style="\n' +
        '    position: absolute;\n' +
        '    right: 30px;\n' +
        '    width: 100px;\n' +
        '   background: #eee;\n' +
        '    border-color: #ccc;\n' +
        '    top: initial;' +
        '">Отменить\n' +
        '        </button>\n' +
        '    </div>\n' +
        '</div>';
    modal = new Modal({
        class_name: 'modal-window',
        init: function ($modal_body) {
            var $this = $(this);
            $modal_body
                .trigger('modal:loaded') //запускает отображение модального окна
                .html(data)
                .trigger('modal:centrify')  //настраивает модальное окно
                .append('<span class="modal-body__close"><span class="icon icon-modal-close"></span></span>');
        },
        destroy: function () {
        }
    });
    console.log(id);
};
TaskPlusLibrary.api = function (url, callbackSuccess, callbackError) {
    console.time('[API] ' + url);
    $.ajax({
        type: 'GET',
        url: url,
        crossDomain: true,
        dataType: 'json',
        success: callbackSuccess,
        error: callbackError
    });
    console.timeEnd('[API] ' + url);
};

TaskPlusLibrary.endTaskFunction = function (id, indexTask) {
    $("#leftTask_" + id).hide('slow', function () {
        $("#leftTask_" + id).remove();
    });
    TaskPlusLibrary.api(
        'https://tasks.pkirillw.ru/tasks/endTask/' + id,
        function (data) {
        },
        function (data) {
        });
};

TaskPlusLibrary.getData = function () {
    TaskPlusLibrary.api(
        'https://tasks.pkirillw.ru/tasks/getLeadTask/' + AMOCRM.data.current_card.id,
        function (data) {
            TaskInfo = data;
            $(".leftTasks_allTasks").empty();
            TaskPlusLibrary.renderTasks();
        },
        function (data) {

        });
};

window.taskPlusWidget.render.push(function (widget) {
    tempWidget = widget;
    TaskPlusLibrary.GenerateLeftArea(widget);
    return true;
});
window.taskPlusWidget.init.push(function () {
    return true;
});
window.taskPlusWidget.bind_actions.push(function () {
    return true;
});
window.taskPlusWidget.settings.push(function () {
    return true;
});
window.taskPlusWidget.onSave.push(function () {
    return true;
});
window.taskPlusWidget.destroy.push(function () {
    return true;
});
window.taskPlusWidget.contacts.push(function () {
    return true;
});
window.taskPlusWidget.leads.push(function () {
    return true;
});
window.taskPlusWidget.tasks.push(function () {
    return true;
});


