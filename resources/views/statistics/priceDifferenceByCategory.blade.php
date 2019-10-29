@extends('layouts.app')
@section('styles')
    <style>
        .clearfix:before, .clearfix:after, .dl-horizontal dd:before, .dl-horizontal dd:after, .container:before, .container:after, .container-fluid:before, .container-fluid:after, .row:before, .row:after, .form-horizontal .form-group:before, .form-horizontal .form-group:after, .btn-toolbar:before, .btn-toolbar:after, .btn-group-vertical > .btn-group:before, .btn-group-vertical > .btn-group:after, .nav:before, .nav:after, .navbar:before, .navbar:after, .navbar-header:before, .navbar-header:after, .navbar-collapse:before, .navbar-collapse:after, .pager:before, .pager:after, .panel-body:before, .panel-body:after, .modal-header:before, .modal-header:after, .modal-footer:before, .modal-footer:after {
            display: initial;
        }
    </style>
@stop
{{--@section('page-title')--}}
{{--@t('@t("percentage_difference") By Category')--}}
{{--@stop--}}
@section('content')
    <div class="row">
        <div class="col-sm-3 col-xs-6">
            <ul class="nav nav-tabs trendingDropdown">
                <li class="dropdown">
                    <a class="dropdown-toggle categoryText border_bottom_add_radius" data-toggle="dropdown"
                       href="#">
                        @t('categories') <span class="caret"></span></a>
                    <ul class="dropdown-menu chartToggle">
                        @foreach ($categories as $category)
                            <li><a href="#category{{$category->id}}"
                                   data-categoryId={{$category->id}}>{{$category->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

        </div>

        <div class="col-sm-3 col-xs-6">
            <ul class="nav nav-tabs trendingDropdown">
                <li class="dropdown">
                    <a class="dropdown-toggle competitorText increaseMenuText border_bottom_add_radius"
                       data-toggle="dropdown"
                       href="#">
                        @t('stores') <span class="caret"></span></a>
                    <ul class="dropdown-menu competitorToggle">
                        <li><a href="#competitor0"
                               data-competitor=0>@t('all')</a></li>
                        @foreach ($competitors as $competitor)
                            <li><a href="#competitor{{$competitor->id}}"
                                   data-competitor={{$competitor->id}}>{{$competitor->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>

        </div>

        <div class="col-sm-3 col-xs-6 inline export" style="display: none">
            <button id="export-chart-data"
                    style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"
                    class="btn btn-info">
                @t('csv_export')
            </button>
        </div>

        <div class="col-sm-3 col-xs-6 inline export" style="display: none">
            <button id="export-chart-data-in-pdf"
                    style="background: #373d58; color: #ccc; border-color: #373d58; height: 40px"

                    class="btn btn-info">
                @t('pdf_export')
            </button>
        </div>
    </div>
    <div style="width: 100%; overflow: auto">
        <div class="chart-container chartWrapper">
        <canvas id="bubble-chart"></canvas>
        <div class="emptyHeader font-weight-bold text-secondary">@t('Please make a selection first')</div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            if ($(window).width() < 500) {
                $('.export').removeClass('inline').css('margin-top', '10px')
            }
            window.bubbleDataset = null;
            window.category_name = null;
            window.competitor_name = null;

            function prepareData() {
                if (bubbleDataset.length > 0) {
                    let dataSet = [];
                    bubbleDataset.forEach(item => {
                        var data = [item['label'][0], item['data'][0]];
                        dataSet.push(data);
                    })

                    return JSON.stringify(dataSet);
                } else {
                    alert('@t("no_data_available")')
                    return false;
                }
            }
            $('#export-chart-data').on('click', function () {
                let $stringifyData = prepareData()
                if ($stringifyData) {
                    let url = '{{ route('statistics.priceDifferenceByCategory.csv.export') }}';
                    url = url + '?data=' + $stringifyData;
                    if (category_name !== null) {
                        url = url + '&type=0&category_name=' + category_name;
                    }
                    if (competitor_name !== null) {
                        url = url + '&type=0&competitor_name=' + competitor_name;
                    }
                    window.location.href = url;
                }
            })

            $('#export-chart-data-in-pdf').on('click', function () {
                let $stringifyData = prepareData()
                if ($stringifyData) {
                    let url = '{{ route('statistics.priceDifferenceByCategory.pdf.export') }}';
                    url = url + '?data=' + $stringifyData;
                    if (category_name !== null) {
                        url = url + '&type=0&category_name=' + category_name;
                    }
                    if (competitor_name !== null) {
                        url = url + '&type=0&competitor_name=' + competitor_name;
                    }
                    window.location.href = url;
                }
            });

            $(".chartToggle li a").click(function () {
                $(".categoryText").html($(this).text() + "<span class='caret'></span>");
            });

            $(".competitorToggle li a").click(function () {
                $(".competitorText").html($(this).text() + "<span class='caret'></span>");
            });

        var randomScalingFactor = function () {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        };
        // $('canvas').clear();
        $(".chartToggle li a").click(function () {
            $('#bubble-chart').hide();
            $('.emptyHeader').hide();
            $('canvas').remove();
            var category_id = $(this).attr('data-categoryId');
            var category_name = $(this).text();
            $('.chart-container').append('<canvas id="' + category_name + '"></canvas>');
            $.ajax({
                url: '/statistics/priceDifference/sortByCategory/' + category_id,
                success: function (point) {
                    var dataValue = [];
                    $.each(point, function (key, val) {
                        dataValue.push(val);
                    });
                    dataValue = dataValue.sort();
                    window.bubbleDataset = dataValue;
                    window.category_name = category_name;
                    window.competitor_name = null;
                    $('.export').show()
                    new Chart(document.getElementById(category_name), {
                        type: 'bubble',
                        data: {
                            labels: "@t('products')",
                            datasets: dataValue
                        },
                        options: {
                            plugins: {
                                zoom: {
                                    pan: {
                                        enabled: true,
                                        mode: "x",
                                        speed: 10,
                                        threshold: 10
                                    },
                                    zoom: {
                                        enabled: true,
                                        drag: false,

                                        // Zooming directions. Remove the appropriate direction to disable
                                        // Eg. 'y' would only allow zooming in the y direction
                                        mode: 'x',
                                    },
                                }
                            },
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: '@t("products")'
                            },
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "@t('price')"
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "@t('percentage')"
                                    }
                                }]
                            },
                            tooltips: {
                                enabled: false,

                                custom: function (tooltipModel) {
                                    // Tooltip Element
                                    var tooltipEl = document.getElementById('chartjs-tooltip');

                                    // Create element on first render
                                    // $('c-tooltip__item_priceByCategory_priceByCategory').css('visibility: visible,opacity: 100 ');
                                    if (!tooltipEl) {
                                        tooltipEl = document.createElement('div');
                                        tooltipEl.id = 'chartjs-tooltip';
                                        // tooltipEl.innerHTML = '<table style="border:2px solid pink; background-color: #353A5C;padding:5px;"></table>';
                                        tooltipEl.innerHTML = '<table class="c-tooltip__item_priceByCategory" style="border-collapse: unset ;"></table>';
                                        document.body.appendChild(tooltipEl);
                                    }

                                    // Hide if no tooltip
                                    if (tooltipModel.opacity === 0) {
                                        tooltipEl.style.opacity = 0;
                                        return;
                                    }

                                    // Set caret Position
                                    tooltipEl.classList.remove('above', 'below', 'no-transform');
                                    if (tooltipModel.yAlign) {
                                        tooltipEl.classList.add(tooltipModel.yAlign);
                                    } else {
                                        tooltipEl.classList.add('no-transform');
                                    }

                                    function getBody(bodyItem) {
                                        return bodyItem.lines;
                                    }

                                    // Set Text
                                    if (tooltipModel.body) {
                                        var titleLines = tooltipModel.title || [];
                                        var bodyLines = tooltipModel.body.map(getBody);
                                        var dataPoints = tooltipModel.dataPoints;
                                        var innerHtml = '';
                                        titleLines.forEach(function (title) {

                                            innerHtml += '<tr><th colspan="2">' + title + '</th><th>' + title + ' </th></tr>';
                                        });
                                        innerHtml += '</thead><tbody style="padding:5px;">';

                                        bodyLines.forEach(function (body, i) {
                                            var colors = tooltipModel.labelColors[i];
                                            var style = 'background:' + '#10b7b0';
                                            style += '; color: white';

                                            // style += '; border: 2px bold' + '#10b7b0';
                                            style += '; font-weight: bold';
                                            var bodyString = body.toString();
                                            bodyString = bodyString.substring(0, bodyString.indexOf(':'));
                                            var span = '<span style="' + style + '"></span>';
                                            innerHtml += '<tr style="' + style + '" ><td colspan="2" style="text-align: center; padding: 5px">' + bodyString + ' ' + span + '</td></tr>';
                                        });

                                        dataPoints.forEach(function (body, i) {
                                            var xLabel = body.xLabel;
                                            var yLabel = body.yLabel;
                                            var colors = tooltipModel.labelColors[i];

                                            var style = 'color:red; text-align:left;';
                                            var span = '<span class="info-title" > @t("percentage_difference"): </span>';
                                            innerHtml += '<tr class=""><td width="95%">' + span + '</td><td style="text-align: right; padding-right: 5px">' + xLabel + '%</td></tr>';

                                            var style = 'color:blue; text-align:left;';
                                            style += '; font-weight: bold';
                                            style += '; color: white';
                                            var span = '<span class="info-title" >@t("price_difference"):   </span>';
                                            innerHtml += '<tr><td width="95%">' + span + '</td><td style="text-align: right;padding-right: 5px">' + yLabel + '€</td></tr>';

                                        });

                                        innerHtml += '</tbody>';

                                        var tableRoot = tooltipEl.querySelector('table');
                                        tableRoot.innerHTML = innerHtml;
                                    }

                                    // `this` will be the overall tooltip
                                    var position = this._chart.canvas.getBoundingClientRect();
                                    var leftPx = tooltipModel.caretX > 470 ? tooltipModel.caretX - 265 : tooltipModel.caretX;
                                    // Display, position, and set styles for font
                                    tooltipEl.style.opacity = 1;
                                    tooltipEl.style.position = 'absolute';
                                    tooltipEl.style.left = position.left + window.pageXOffset + leftPx + 'px';
                                    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                                    tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
                                    tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
                                    tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
                                    tooltipEl.style.pointerEvents = 'none';
                                }

                            },
                        }
                    });
                },
                cache: false
            });
        });
        $(".competitorToggle li a").click(function () {
            $('#bubble-chart').hide();
            $('.emptyHeader').hide();
            $('canvas').remove();
            var competitor_id = $(this).attr('data-competitor');
            var competitor_name = $(this).text();
            $('.chart-container').append('<canvas id="' + competitor_name + '"></canvas>');
            $.ajax({
                url: '/statistics/priceDifference/sortByCompetitor',
                data: {
                    competitor_id: competitor_id
                },
                success: function (point) {
                    var dataValue = [];
                    $.each(point, function (key, val) {
                        dataValue.push(val);
                    });
                    dataValue = dataValue.sort();
                    window.bubbleDataset = dataValue;
                    window.competitor_name = competitor_name;
                    window.category_name = null;
                    $('.export').show()
                    new Chart(document.getElementById(competitor_name), {
                        type: 'bubble',
                        data: {
                            labels: "@t('products')",
                            datasets: dataValue
                        },
                        options: {
                            plugins: {
                                zoom: {
                                    pan: {
                                        enabled: true,
                                        mode: "x",
                                        speed: 10,
                                        threshold: 10
                                    },
                                    zoom: {
                                        enabled: true,
                                        drag: false,

                                        // Zooming directions. Remove the appropriate direction to disable
                                        // Eg. 'y' would only allow zooming in the y direction
                                        mode: 'x',
                                    },
                                }
                            },
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: "@t('products')"
                            },
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "@t('percentage_difference')"
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "@t('percentage')"
                                    }
                                }]
                            },
                            tooltips: {

                                enabled: false,

                                custom: function (tooltipModel) {
                                    // Tooltip Element
                                    var tooltipEl = document.getElementById('chartjs-tooltip');
                                    if (!tooltipEl) {
                                        tooltipEl = document.createElement('div');
                                        tooltipEl.id = 'chartjs-tooltip';
                                        // tooltipEl.innerHTML = '<table style="border:2px solid pink; background-color: #353A5C;padding:5px;"></table>';
                                        tooltipEl.innerHTML = '<table class="c-tooltip__item_priceByCategory" style="border-collapse: unset ;"></table>';
                                        document.body.appendChild(tooltipEl);
                                    }

                                    // Hide if no tooltip
                                    if (tooltipModel.opacity === 0) {
                                        tooltipEl.style.opacity = 0;
                                        return;
                                    }

                                    // Set caret Position
                                    tooltipEl.classList.remove('above', 'below', 'no-transform');
                                    if (tooltipModel.yAlign) {
                                        tooltipEl.classList.add(tooltipModel.yAlign);
                                    } else {
                                        tooltipEl.classList.add('no-transform');
                                    }

                                    function getBody(bodyItem) {
                                        return bodyItem.lines;
                                    }

                                    // Set Text
                                    if (tooltipModel.body) {
                                        var titleLines = tooltipModel.title || [];
                                        var bodyLines = tooltipModel.body.map(getBody);
                                        var dataPoints = tooltipModel.dataPoints;
                                        var innerHtml = '';
                                        titleLines.forEach(function (title) {

                                            innerHtml += '<tr><th colspan="2">' + title + '</th><th>' + title + ' </th></tr>';
                                        });
                                        innerHtml += '</thead><tbody style="padding:5px;">';

                                        bodyLines.forEach(function (body, i) {
                                            var colors = tooltipModel.labelColors[i]; // colors.backgroundColor
                                            var style = 'background:' + '#10b7b0';
                                            style += '; color: white';

                                            // style += '; border: 2px bold' + '#10b7b0';
                                            style += '; font-weight: bold';
                                            var bodyString = body.toString();
                                            bodyString = bodyString.substring(0, bodyString.indexOf(':'));
                                            var span = '<span style="' + style + '"></span>';
                                            innerHtml += '<tr style="' + style + '" ><td style="text-align: center; padding: 5px" colspan="2" >' + bodyString + ' </td></tr>';
                                        });

                                        dataPoints.forEach(function (body, i) {
                                            var xLabel = body.xLabel;
                                            var yLabel = body.yLabel;
                                            var colors = tooltipModel.labelColors[i];

                                            var style = 'color:red; text-align:left;';
                                            var span = '<span class="info-title" >  @t("percentage_difference"): </span>';
                                            innerHtml += '<tr class=""><td width="95%">' + span + '</td><td style="text-align: right; padding-right: 5px">' + xLabel + '%</td></tr>';

                                            var style = 'color:blue; text-align:left;';
                                            style += '; font-weight: bold';
                                            style += '; color: white';
                                            var span = '<span class="info-title" > @t("percentage_difference"):  </span>';
                                            innerHtml += '<tr><td width="95%">' + span + '</td><td style="text-align: right;padding-right: 5px">' + yLabel + '€</td></tr>';

                                            // var style = 'color:pink; text-align:left;';
                                            // var span = '<span style="' + style + '"> Result </span>';
                                            // innerHtml += '<tr style="border-top:2px solid red;"><td>' + span +'</td><td style="text-align: right;">' + 12325 + '</td></tr>';
                                        });

                                        innerHtml += '</tbody>';

                                        var tableRoot = tooltipEl.querySelector('table');
                                        tableRoot.innerHTML = innerHtml;
                                    }


                                    // `this` will be the overall tooltip
                                    var position = this._chart.canvas.getBoundingClientRect();
                                    // Display, position, and set styles for font
                                    var leftPx = tooltipModel.caretX > 470 ? tooltipModel.caretX - 265 : tooltipModel.caretX;
                                    // Display, position, and set styles for font
                                    tooltipEl.style.opacity = 1;
                                    tooltipEl.style.position = 'absolute';
                                    tooltipEl.style.left = position.left + window.pageXOffset + leftPx + 'px';
                                    tooltipEl.style.top = position.top + window.pageYOffset + tooltipModel.caretY + 'px';
                                    tooltipEl.style.fontFamily = tooltipModel._bodyFontFamily;
                                    tooltipEl.style.fontSize = tooltipModel.bodyFontSize + 'px';
                                    tooltipEl.style.fontStyle = tooltipModel._bodyFontStyle;
                                    // tooltipEl.style.padding = tooltipModel.yPadding + 'px ' + tooltipModel.xPadding + 'px';
                                    tooltipEl.style.pointerEvents = 'none';
                                }
                            }
                        }
                    });
                },
                cache: false
            });
        });
        $.ajax({
            url: '/statistics/priceDifference/sortByCompetitor',
            success: function (point) {
                var dataValue = [];
                $.each(point, function (key, val) {
                    dataValue.push(val);
                });
                dataValue = dataValue.sort();
                window.bubbleDataset = dataValue;
                $('.export').show()
                var testChart = new Chart(document.getElementById("bubble-chart"), {
                    type: 'bubble',
                    data: {
                        labels: "@t('products')",
                        datasets: []
                    },
                    options: {
                        plugins: {
                            zoom: {
                                pan: {
                                    enabled: true,
                                    mode: "x",
                                    speed: 10,
                                    threshold: 10
                                },
                                zoom: {
                                    enabled: true,
                                    drag: false,

                                    // Zooming directions. Remove the appropriate direction to disable
                                    // Eg. 'y' would only allow zooming in the y direction
                                    mode: 'x',
                                },
                            }
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: '@t("products")'
                        },
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: "@t('price')"
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: "@t('percentage')"
                                }
                            }]
                        },
                        tooltips: {
                            enabled: true,
                            mode: 'single',
                            callbacks: {
                                label: function (tooltipItems, data) {

                                    var label = data.datasets[tooltipItems.datasetIndex].label;
                                    return label;

                                },

                                afterLabel: function (tooltipItems, data) {

                                    return ['@t("price_difference"): ' + ' :' + tooltipItems.yLabel,
                                        ' @t("percentage_difference"): : ' + tooltipItems.xLabel + '%'
                                    ];
                                }

                            },

                        },

                    }
                });
            },
            cache: false
        });

        });
    </script>
@endsection
