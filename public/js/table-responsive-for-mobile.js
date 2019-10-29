if ($('.table-custom').length === 1) {
    var columns = $('.table tr').length;
    var rows = $('.table th').length;
}

$(document).ready(function ($) {
    //Fire it when the page first loads:
    alterClass();

    $(window).resize(function () {
        alterClass();
        $('.table').removeAttr('style');
    });

    $('#toggle-table-view').on('click', function () {
        let toggleClass = $('.table');
        if ($('.mobile-responsive-v1')[0]) {
            toggleClass.removeClass('mobile-responsive-v1');
            toggleClass.addClass('mobile-responsive-v2');

            shapeTable(rows, columns);
        } else {
            $('.mobile-responsive-v2 td, .mobile-responsive-v2 th').removeAttr('style');
            toggleClass.removeClass('mobile-responsive-v2');
            toggleClass.addClass('mobile-responsive-v1');
            $('.mobile-responsive-v1').css('width', '100%')
            $('.mobile-responsive-v1 thead').css('position', 'absolute')
            $('.mobile-responsive-v1 tbody').removeAttr('style')
        }

        let toggleButtonIcon = $('#toggleIconClass')
        if ($('.fa-th-large')[0]) {
            toggleButtonIcon.removeClass('fa-th-large');
            toggleButtonIcon.addClass('fa-th-list');
        } else {
            toggleButtonIcon.removeClass('fa-th-list');
            toggleButtonIcon.addClass('fa-th-large');
        }
    })
});


var smallBreak = 767; // Your small screen breakpoint in pixels

async function alterClass() {
    var ww = document.body.clientWidth;
    if (ww < 767) {
        $('.table-responsive .row .col-sm-6').addClass('no-padding-for-mobile');
        $('.table-responsive .col-sm-6').removeClass('col-xs-5 col-xs-7').addClass('col-xs-12');
        $('.table .text-center').removeClass('text-center');
        $('#toggle-button').show();

        $('.table-responsive .table').removeClass('table-custom').addClass('mobile-responsive-v2');
        // $('.table').addClass('mobile-responsive-v2');
        if (rows !== undefined) {
            await shapeTable(rows, columns);
        }
    } else {
        $('.mobile-responsive-v2 td, .mobile-responsive-v2 th').removeAttr('style');
        $('.table-responsive .row .col-sm-6').removeClass('no-padding-for-mobile');
        $('.table-responsive .table').addClass('table-custom');
        $('.table').removeClass('mobile-responsive-v1 mobile-responsive-v2');
        $('#toggle-button').hide();
    }
}

async function shapeTable(rows, columns, selector = null) {
    if ($('.mobile-responsive-v1')[0]) {
        $('.mobile-responsive-v1 td, .mobile-responsive-v1 th').removeAttr('style');
        return;
    }
    if (selector === null) {
        selector = '.mobile-responsive-v2';
    }

    $(selector + ' td,' + selector + ' th').removeAttr('style');

    if ($(window).width() < smallBreak) {
        var totalHeight = 0;
        await (function () {
            for (i = 1; i <= rows; i++) {

                var maxHeight = $(selector + " th:nth-child(" + i + ")").outerHeight();

                for (j = 0; j < columns; j++) {
                    var trSelector = $(selector + ' tr:nth-child(' + j + ') td:nth-child(' + i + ')');
                    if (trSelector.outerHeight() > maxHeight) {
                        maxHeight = $(selector + ' tr:nth-child(' + j + ') td:nth-child(' + i + ')').outerHeight();
                    }
                    if (trSelector.prop('scrollHeight') > trSelector.outerHeight()) {
                        maxHeight = $(selector + ' tr:nth-child(' + j + ') td:nth-child(' + i + ')').prop('scrollHeight');
                    }
                }
                for (j = 1; j <= columns; j++) {
                    maxHeight = maxHeight === 0 ? 40 : maxHeight;
                    if (i === 1 && maxHeight === 40) {
                        maxHeight = 60;
                    }
                    $(selector + ' th:nth-child(' + i + ')').css('height', maxHeight);
                    var trTdSelector = $(selector + ' tr:nth-child(' + j + ') td:nth-child(' + i + ')');
                    trTdSelector.css('height', maxHeight);
                }
                totalHeight += maxHeight;
            }
        })();

        for (i = 1; i <= rows; i++) {
            for (j = 1; j <= columns; j++) {
                var trSelector = $(selector + ' tr:nth-child(' + j + ') td:nth-child(' + i + ')');
                if (trSelector.hasClass('dataTables_empty') || trSelector.hasClass('empty_row')) {
                    trSelector.css('height', totalHeight);
                }
            }
        }
        var totalWidth = $(selector + ' thead').width() ? $(selector + ' thead').width() : 135 + 3;

        var tbodyWidth = $(window).width() - (totalWidth + 25)
        $(selector + ' tbody').css('padding-left', totalWidth).css('width', tbodyWidth)
        $(selector).css('width', 'auto')

    } else {
        $('.mobile-responsive-v2 td, .mobile-responsive-v2 th').removeAttr('style');
    }
}