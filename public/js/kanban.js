$(function () {
    $('#datetimepicker1').datepicker({
        format: "dd.mm.yyyy",
        language: "ru"
    });
    $('#datetimepicker2').datepicker({
        format: "dd.mm.yyyy",
        language: "ru"
    });

    $('[data-toggle="tooltip"]').tooltip();
    var kanbanCol = $('.pipeline-body');
    //kanbanCol.css('max-height', (window.innerHeight - 150) + 'px');

    var kanbanColCount = parseInt(kanbanCol.length);
    //$('.container-fluid').css('min-width', (kanbanColCount * 350) + 'px');

    draggableInit();
    $('.card-body').slideToggle();
    $('.card-header').click(function () {
        var $panelBody = $(this).parent().children('.card-body');
        $panelBody.slideToggle();
    });
    $("#name_lead").change(function () {
        $('#lead_select option').remove();
        var timerId;
        $.ajax({
            type: "GET",
            url: "/getLeads/" + $("#name_lead").val(),
            beforeSend: function () {
                $('#lead_select').prop('disabled', 'disabled');
                $('#lead_select').hide();

                $('#loaderLeads').show();
                timerId = setInterval(function () {
                    $("#innerLoaderLeads").width($("#innerLoaderLeads").width() + 1 + '%');
                }, 250);
            }
        }).done(function (data) {
            $("#innerLoaderLeads").width('100%');
            $.each(data, function (key, value) {
                if (key == 0) {
                    $('input[name="number_request"]').val(value.name);
                }
                $('#lead_select')
                    .append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
            });
            setTimeout(function () {
                $('#lead_select').prop('disabled', false);
                $('#lead_select').show();
                clearInterval(timerId);
                $('#loaderLeads').hide();
                $("#innerLoaderLeads").width('0%');
            }, 500);

        });
        $('#lead_select').change(function () {
            $('input[name="number_request"]').val($("#lead_select option:selected").text());
        });
    });

});

function draggableInit() {
    var sourceId;

    $('[draggable=true]').bind('dragstart', function (event) {
        sourceId = $(this).parent().attr('id');
        event.originalEvent.dataTransfer.setData("text/plain", event.target.getAttribute('id'));
    });

    $('.pipeline-body').bind('dragover', function (event) {
        event.preventDefault();
    });

    $('.pipeline-body').bind('drop', function (event) {
        var children = $(this);
        var targetId = children.attr('id');

        if (sourceId != targetId) {
            var elementId = event.originalEvent.dataTransfer.getData("text/plain");

            $('#processing-modal').modal('toggle'); //before post

            console.log('Source ID: ' + sourceId);
            console.log('Target ID: ' + targetId);
            console.log('Element ID: ' + elementId);
            // Post data
            $.ajax({
                type: "POST",
                url: "/tasks/changePipeline",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    taskId: elementId.replace(/[^\d;]/g, ''),
                    newPipelineId: targetId.replace(/[^\d;]/g, ''),
                    oldPipelineId: sourceId.replace(/[^\d;]/g, '')
                }
            }).done(function () {
                var element = document.getElementById(elementId);
                children.prepend(element);
                $('#processing-modal').modal('toggle'); // after post
            });
        }

        event.preventDefault();
    });
}

function endTask(id) {
    $.ajax({
        type: 'GET',
        url: '/tasks/endTask/' + id,

    }).done(function () {
        $('#task' + id).remove();
    })
}

function saveText(id) {
    $.ajax({
        type: "POST",
        url: "/tasks/changeText",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            taskId: id,
            text: $('#comment' + id).val()
        }
    });
}

function editTask(id) {
    $.ajax({
        type: 'GET',
        url: '/tasks/getTaskAPI/' + id,
    }).done(function (data) {
        $('#edit_nameTask_header').text(data.number_request);
        $('#edit_nameTask').text(data.number_request);
        $('#edit_taskId').val(data.id);
        $('#edit_pipelineId').val(data.pipeline.id);
        $('#edit_typeId').val(data.type.id);
        $('#edit_numberRequest').val(data.number_request);
        $('#edit_comment').text(data.comment);
        $('#datetimepicker2').val(data.complite_till_format);
    })

}

function changeTimerTaskId(id) {
    console.log(id);
    $('#task_id_timer').val(id);
}

function searchit(id) {
    console.log('/search/' + id + '/' + $('#searchText').val());
    $(location).attr('href', '/search/' + id + '/' + $('#searchText').val());

}