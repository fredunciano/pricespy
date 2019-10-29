@extends('layouts.app')
@section('styles')
    <style>
        /*@media screen and (max-width: 767px) {*/
            /*.page-head-title{*/
                /*width: 30%;*/
            /*}*/

        /*}*/
    </style>
@stop
@section('page-title')
    @t('price_changes')
@stop
@section('page-button')
    <div id='toggle-button' style="display: none; padding-left: 15px; padding-bottom: 10px">
        <button id="toggle-table-view" class="btn btn-orange pull-right"><i id="toggleIconClass" class="fa fa-th-large"></i> Toggle
            View
        </button>
    </div>
@stop
@section('content')
    <div class="">
        <div class="customPriceChangeTable">
            <div class="customPriceChangeTable-info">
                <ul class="nav nav-tabs trendingDropdown" style="display: inline-block">
                    <li class="dropdown">
                        <a class="dropdown-toggle increaseMenuText border_bottom_add_radius" data-toggle="dropdown"
                           href="#">
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu increaseMenu">
                            <li><a href="#dayInc" id="dayDataInc" data-toggle="tab">@t('day')</a></li>
                            <li><a href="#weekInc" id="weekDataInc" data-toggle="tab">@t('this_week')</a></li>
                            <li><a href="#monthInc" id="monthDataInc" data-toggle="tab">@t('this_month')</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="price-change-stat-count">
                    @t('No. of Competitor Products which Increased in Price') :<span class="label increase" id="countTrends"></span>
                </div>
            </div>

            <!-- Tab panes -->
            <div class="tab-content trending_body ">
                <div id="dayInc" class="tab-pane active"><br>
                    <span class="label increase" id="dayIncreaseCount" style="display: none"></span>
                    <div class="table-responsive">
                        <table class="table table-custom table-vcenter" id="tableDayIncrease">
                            <thead>
                            <tr>
                                <th class="{{ hc('red') }}">@tbl('product_name')</th>
                                <th class="{{ hc('purple') }}">
                                    @tbl('competitor')
                                </th>
                                <th class="{{ hc('orange') }}">
                                    @tbl('percentage')
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                </div>
                <div id="weekInc" class="tab-pane fade"><br>
                    <span class="label increase" id="weekIncreaseCount" style="display: none"></span>
                    <div class="table-responsive">
                        <table class="table table-custom table-vcenter table" id="tableWeekIncrease">
                            <thead>
                            <tr>
                                <th class="{{ hc('red') }}  ">@tbl('product_name')</th>
                                <th class="{{ hc('purple') }}  ">
                                    @tbl('competitor')
                                </th>
                                <th class="{{ hc('orange') }}  ">
                                    @tbl('percentage')
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                    <br>
                </div>
                <div id="monthInc" class="tab-pane fade"><br>
                    <span class="label increase" id="monthIncreaseCount" style="display: none"></span>
                    <div class="table-responsive">
                        <table class="table table-custom table-vcenter table" id="tableMonthIncrease">
                            <thead>
                            <tr>
                                <th class="{{ hc('red') }}  ">@tbl('product_name')</th>
                                <th class="{{ hc('purple') }}  ">
                                    @tbl('competitor')
                                </th>
                                <th class="{{ hc('orange') }}  ">
                                    @tbl('percentage')
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <!-- END Statistics Widget -->
        <div class="customPriceChangeTable">
            <div class="customPriceChangeTable-info">
                <ul class="nav nav-tabs trendingDropdown" style="display: inline-block">
                    <li class="dropdown">
                        <a class="dropdown-toggle decreaseMenuText border_bottom_add_radius" data-toggle="dropdown"
                           href="#">
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu decreaseMenu">
                            <li><a class="nav-link" id="dayDataDec" data-toggle="tab" href="#day">@t('day')</a></li>
                            <li><a class="nav-link" id="weekDataDec" data-toggle="tab" href="#week">@t('this_week')</a></li>
                            <li><a class="nav-link" id="monthDataDec" data-toggle="tab" href="#month">@t('this_month')</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="price-change-stat-count">
                    @t('No. of Competitor Products which Decreased in Price') :<span class="label decrease" id="countTrendsDec"></span>
                </div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content trending_body">
                <div id="day" class="tab-pane active"><br>
                    {{--<p>@t('No. of Competitor Products which Decreased in Price') : <span--}}
                    {{--class="label increase" id="dayDecreaseCount"></span></p>--}}
                    <span class="label decrease" id="dayDecreaseCount" style="display: none"></span>
                    <div class="table-responsive">
                        <table class="table table-custom table-vcenter table" id="tableDayDecrease">
                            <thead>
                            <tr>
                                <th class="{{ hc('red') }}  ">@tbl('product_name')</th>
                                <th class="{{ hc('purple') }}  ">
                                    @tbl('competitor')
                                </th>
                                <th class="{{ hc('orange') }}  ">
                                    @tbl('percentage')
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                </div>
                <div id="week" class="tab-pane fade"><br>
                    <br>
                    {{--<p>@t('No. of Competitor Products which Decreased in Price') : <span--}}
                    {{--class="label increase" id="weekDecreaseCount"></span></p>--}}
                    <span class="label decrease" id="weekDecreaseCount" style="display: none"></span>
                    <div class="table-responsive">
                        <table class="table table-custom table-vcenter table" id="tableWeekDecrease">
                            <thead>
                            <tr>
                                <th class="{{ hc('red') }}  ">@tbl('product_name')</th>
                                <th class="{{ hc('purple') }}  ">
                                    @tbl('competitor')
                                </th>
                                <th class="{{ hc('orange') }}  ">
                                    @tbl('percentage')
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                </div>
                <div id="month" class="tab-pane fade"><br>
                    <br>
                    {{--<p>@t('No. of Competitor Products which Decreased in Price') : <span--}}
                    {{--class="label increase" id="monthDecreaseCount"></span></p>--}}
                    <span class="label decrease" id="monthDecreaseCount" style="display: none"></span>
                    <div class="table-responsive">
                        <table class="table table-custom table-vcenter table" id="tablemonthDecrease">
                            <thead>
                            <tr>
                                <th class="{{ hc('red') }}  ">@tbl('product_name')</th>
                                <th class="{{ hc('purple') }}  ">
                                    @tbl('competitor')
                                </th>
                                <th class="{{ hc('orange') }}  ">
                                    @tbl('percentage')
                                </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <br>
                </div>
            </div>
            <br>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        function setColumnLabel(colIndex) {
            let str;
            switch (colIndex) {
                case 0:
                    str = '@t("product_name")';
                    break;
                case 1:
                    str = '@t("competitor")';
                    break;
                case 2:
                    str = '@t("percentage")';
                    break;
            }
            return str;
        }
        $(document).ready(function () {
            $(".increaseMenu li a").click(function () {
                $(".increaseMenuText").html($(this).text() + "<span class='caret'></span>");

            });
            $('.increaseMenu li a').first().trigger('click');
            $(".decreaseMenu li a").click(function () {
                $(".decreaseMenuText").html($(this).text() + "<span class='caret'></span>");

            });
            $('.decreaseMenu li a').first().trigger('click');

        });
        App.datatables();

        getDailyInfo(2)

        async function getDailyInfo(type) {
            try {
                var dayDataUrl = "{{ route('products.comparison.getProductPerDay') }}"
                const response = await axios.get(dayDataUrl);
                if (response) {
                    if (type === 0) {
                        await renderTable($('#tableDayIncrease'), $('#dayIncreaseCount'), true, dayDataUrl);
                    } else if (type === 1) {
                        await renderTable($('#tableDayDecrease'), $('#dayDecreaseCount'), false, dayDataUrl);
                    } else {
                        await renderTable($('#tableDayIncrease'), $('#dayIncreaseCount'), true, dayDataUrl);
                        await renderTable($('#tableDayDecrease'), $('#dayDecreaseCount'), false, dayDataUrl);
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function getWeeklyInfo(type) {
            try {
                var weekDataUrl = "{{ route('products.comparison.getProductsForWeek') }}"
                const response = await axios.get(weekDataUrl);
                if (response) {
                    if (type === 0) {
                        await renderTable($('#tableWeekIncrease'), $('#weekIncreaseCount'), true, weekDataUrl);
                    } else if (type === 1) {
                        await renderTable($('#tableWeekDecrease'), $('#weekDecreaseCount'), false, weekDataUrl);
                    } else {
                        await renderTable($('#tableWeekIncrease'), $('#weekIncreaseCount'), true, weekDataUrl);
                        await renderTable($('#tableWeekDecrease'), $('#weekDecreaseCount'), false, weekDataUrl);
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }

        async function getMonthlyInfo(type) {
            try {
                var monthDataUrl = "{{ route('products.comparison.getProductByMonth') }}"
                const response = await axios.get(monthDataUrl);
                if (response) {
                    if (type === 0) {
                        await renderTable($('#tableMonthIncrease'), $('#monthIncreaseCount'), true, monthDataUrl);
                    } else if (type === 1) {
                        await renderTable($('#tablemonthDecrease'), $('#monthDecreaseCount'), false, monthDataUrl);

                    } else {
                        await renderTable($('#tableMonthIncrease'), $('#monthIncreaseCount'), true, monthDataUrl);
                        await renderTable($('#tablemonthDecrease'), $('#monthDecreaseCount'), false, monthDataUrl);
                    }
                }
            } catch (error) {
                console.error(error);
            }
        }

        $('#countTrends').text('0');
        $('#countTrendsDec').text('0');

        $('#dayDataInc').on('click', function () {
            if (!$('#dayIncreaseCount').text()) {
                $('#countTrends').text('0');
            } else {
                $('#countTrends').text($('#dayIncreaseCount').text());
            }

        });
        $('#dayDataDec').on('click', function () {
            if (!$('#dayDecreaseCount').text()) {
                $('#countTrendsDec').text('0');
            } else {
                $('#countTrendsDec').text($('#dayDecreaseCount').text());
            }
        });

        var weekData = null;
        $('#weekDataInc').on('click', async function () {
            if (weekData == null) {
                const data = await getWeeklyInfo(0);
            }
            if (!$('#weekIncreaseCount').text()) {
                $('#countTrends').text('0');
            } else {
                $('#countTrends').text($('#weekIncreaseCount').text());
            }

        });
        $('#weekDataDec').on('click', async function () {
            if (weekData == null) {
                const data = await getWeeklyInfo(1);
            }
            if (!$('#weekDecreaseCount').text()) {
                $('#countTrendsDec').text('0');
            } else {
                $('#countTrendsDec').text($('#weekDecreaseCount').text());
            }
        });

        var monthData = null;
        $('#monthDataInc').on('click', async function () {
            if (monthData == null) {
                const data = await getMonthlyInfo(0);
            }
            if (!$('#monthIncreaseCount').text()) {
                $('#countTrends').text('0');
            } else {
                $('#countTrends').text($('#monthIncreaseCount').text());
            }
        });
        $('#monthDataDec').on('click', async function () {
            if (monthData == null) {
                const data = await getMonthlyInfo(1);
            }
            if (!$('#monthDecreaseCount').text()) {
                $('#countTrendsDec').text('0');
            } else {
                $('#countTrendsDec').text($('#monthDecreaseCount').text());
            }

        });

        function renderTable(selector, selectorTypeCount, isItPositive, url) {
            var className = 'decrease'
            var trendSelector = $('#countTrendsDec');
            if (isItPositive) {
                className = 'increase';
                trendSelector = $('#countTrends');
                url = url + '?inc=1';
            } else {
                url = url + '?inc=0';
            }
            selector.DataTable(
                {
                    "stateSave": true,
                    "bDestroy": true,
                    'ajax': {
                        'url': url,
                        'type': 'GET',
                        'error': function (error) {
                            console.log(error.responseText);
                        },
                        'dataSrc': function (json) {

                            selectorTypeCount.text(json.length);
                            trendSelector.text(selectorTypeCount.text());
                            return json;

                        }
                    },
                    "columns": [
                        {
                            "data": null,
                            "render": function (data, type, row, meta) {
                                let productName = row.product_name.length > 60 ? row.product_name.substr(0, 60) + '..' : row.product_name;
                                return '<span class="text-orange  "><a class="text-orange" href="/products/' + row.id +
                                    '"><strong class="underline-on-hover">' + productName + '</strong></a></span>';

                            }
                        },
                        {
                            "data": null,
                            "render": function (data, type, row, meta) {
                                return '<a href="/products?compName=' + row.name.split(' ').join('||') + '">' + row.name + '</a>';
                            }
                        },
                        {
                            "data": null,
                            "render": function (data, type, row, meta) {
                                if (type === 'display') {
                                    return '<span class="label ' + className + '">' + showVisualDifference(row.price_difference, true) + '</span>';
                                }
                                return row.price_difference;
                            }
                        },
                    ],
                    "columnDefs": [
                        {className: "text-center", "targets": [1, 2]},
                    ],
                    "order": [[2, "desc"]],
                    'initComplete': async function (settings, json) {
                        selector.addClass('mobile-responsive-v2');
                        var columns = $(selector.selector + ' tr').length;
                        var rows = $(selector.selector + ' th').length;
                        await shapeTable(rows, columns, selector.selector);
                        $('.table .text-center').removeClass('text-center');
                    },
                    'drawCallback': function () {
                        $('.table .text-center').removeClass('text-center');
                        setTimeout(async function () {
                            selector.addClass('mobile-responsive-v2');
                            var columns = $(selector.selector + ' tr').length;
                            var rows = $(selector.selector + ' th').length;
                            await shapeTable(rows, columns, selector.selector);
                        }, 150)
                    },
                    'createdRow': function (row, data, rowIndex) {
                        $.each($('td', row), function (colIndex) {
                            $(this).attr('data-label', setColumnLabel(colIndex));
                        });
                    },
                    language: {
                        "searchPlaceholder": searchString(),
                        "sEmptyTable": emptyTable(),
                        "sInfo": getInfo(),
                        "sInfoEmpty": getEmpty(),
                        "sLoadingRecords": getLoading(),
                        "sInfoFiltered": getFiltered()
                    },

                });
        }

        function showVisualDifference(difference, percents = false) {
            let dif = parseFloat(difference);
            if (dif === 0) {
                return difference + (percents ? ' %' : '');
            }
            return (dif > 0 ? '+ ' : '- ') + Math.abs(difference) + (percents ? ' %' : '');
        }

        function searchString() {
            return envLang === 'en' ? 'Search...' : 'Suchen...';

        }

        function emptyTable() {
            return envLang === 'en' ? 'No Data Available' : 'Keine Daten vorhanden';
        }

        function getInfo() {
            return envLang === 'en' ? "Showing _START_ to _END_ of _TOTAL_ entries" : "_START_ bis _END_ von _TOTAL_ Einträgen"
        }

        function getEmpty() {
            return envLang === 'en' ? "Showing 0 to 0 of 0 entries" : "Zeige 0 bis 0 von 0 Einträgen"
        }

        function getFiltered() {
            return envLang === 'en' ? " (filtered from _MAX_ total entries) " : "(Gefiltert aus insgesamt _MAX_ Einträgen) "
        }


        function getLoading() {
            // return envLang === 'en' ? "Loading..." : "Lädt...";
            return '<div class="loader">\n' +
                '                    <svg width="200px" height="200px">\n' +
                '                        <g id="document">\n' +
                '                            <path fill="#EFEADE" d="M120,87.068L108,75H80v50h40V87.068z M120,87.068"/>\n' +
                '                            <path fill="#D6D1BC"\n' +
                '                                  d="M90.741,99.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 C90.333,98,90,98.334,90,98.753C90,99.166,90.333,99.5,90.741,99.5L90.741,99.5z M90.741,99.5"/>\n' +
                '                            <path fill="#D6D1BC"\n' +
                '                                  d="M91.001,93.5h9.998c0.552,0,1.001-0.335,1.001-0.75c0-0.413-0.449-0.75-1.001-0.75h-9.998 C90.45,92,90,92.337,90,92.75C90,93.165,90.45,93.5,91.001,93.5L91.001,93.5z M91.001,93.5"/>\n' +
                '                            <path fill="#D6D1BC" d="M108,75v12h12L108,75z M108,75"/>\n' +
                '                            <path fill="#D6D1BC"\n' +
                '                                  d="M90.741,105.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,105.166,90.333,105.5,90.741,105.5L90.741,105.5z M90.741,105.5"/>\n' +
                '                            <path fill="#D6D1BC"\n' +
                '                                  d="M90.741,111.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,111.166,90.333,111.5,90.741,111.5L90.741,111.5z M90.741,111.5"/>\n' +
                '                            <path fill="#D6D1BC"\n' +
                '                                  d="M90.741,117.5h18.518c0.408,0,0.741-0.334,0.741-0.747c0-0.419-0.333-0.753-0.741-0.753H90.741 c-0.408,0-0.741,0.334-0.741,0.753C90,117.166,90.333,117.5,90.741,117.5L90.741,117.5z M90.741,117.5"/>\n' +
                '                        </g>\n' +
                '                        <g id="search">\n' +
                '                            <path fill="#566181"\n' +
                '                                  d="M127.039,127.787l-13.217-13.213c2.793-2.594,4.555-6.285,4.555-10.385c0-7.821-6.367-14.189-14.188-14.189 C96.37,90,90,96.369,90,104.189c0,7.82,6.37,14.188,14.189,14.188c2.783,0,5.375-0.818,7.57-2.211l13.449,13.451 c0.26,0.246,0.582,0.383,0.924,0.383c0.32,0,0.646-0.137,0.906-0.383C127.545,129.111,127.545,128.291,127.039,127.787z M92.582,104.189c0-6.396,5.211-11.608,11.608-11.608c6.406,0,11.607,5.211,11.607,11.608c0,6.402-5.201,11.607-11.607,11.607 C97.793,115.797,92.582,110.592,92.582,104.189z"/>\n' +
                '                        </g>\n' +
                '                    </svg>\n' +
                '                </div>'
        }
    </script>
    <script src="{{ asset('js/table-responsive-for-mobile.js') }}"></script>
@endsection
