var maswidget = {};

maswidget.init = function (id) {
    if ($('div[data-entity=mas]').length !== 0) {
        return;
    }
    $('head').append('<link href="https://tasks.pkirillw.ru/public/css/styleWidget.css" rel="stylesheet" type="text/css" />');
    var menuItem = '<div class="nav__menu__item" data-entity="mas">\n' +
        '\t\t\t\t\t\t<a class="nav__menu__item__link" href="/board/' + id + '">\n' +
        '\t\t\t\t\t\t\t<div class="nav__menu__item__icon icon-mas">\n' +
        '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class="js-notifications_counter nav__notifications__counter" style="display: none"></span>\n' +
        '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="nav__top__userpic__loader stopped" id="page_change_progress"><span class="spinner-icon"></span></div></div>\n' +
        '\t\t\t\t\t\t\t<div class="nav__menu__item__title">Дела</div>\n' +
        '\t\t\t\t\t\t</a>\n' +
        '\t\t\t\t\t</div>';
    $(menuItem).insertAfter('div[data-entity=leads]');

    $('div[data-entity=mas] a').click(function (event) {
        event.preventDefault();
        $('#page_holder').html('<iframe id="masIframe" src="https://tasks.pkirillw.ru/openBoard/' + id + '" width="100%" frameborder="0" ></iframe>');
        $('#masIframe').load(function () {
            $('div[data-entity=mas]').addClass('nav__menu__item-selected');
            $('#masIframe').css('height', $('#page_holder').css('height'));
            $('#page_holder').css('z-index', 3000);
        });
    });
};

window.NTTasksLeftTasks.bind_actions.push(function (widget) {
    maswidget.widget = widget;
    console.log(widget.system().amouser_id);
    console.log(widget);
    maswidget.init(widget.system().amouser_id);

    return true;
});