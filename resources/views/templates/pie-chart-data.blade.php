<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Market Distribution Report - PriceFeed</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both
        }

        a {
            color: #5d6975;
            text-decoration: underline
        }

        body {
            position: relative;
            /*width: 21cm;*/
            /*height: 29.7cm;*/
            margin: 0 auto;
            color: #001028;
            background: #fff;
            font-family: Roboto, sans-serif;
            font-size: 12px;
            padding: 0 50px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px
        }

        #logo {
            text-align: center;
            margin-bottom: 10px
        }

        #logo img {
            width: 90px
        }

        h1 {
            border-top: 1px solid #5d6975;
            border-bottom: 1px solid #5d6975;
            color: #5d6975;
            font-size: 1.4em;
            line-height: 1.4em;
            font-weight: 400;
            text-align: center;
            margin: 0 0 20px 0;
            padding: 10px;
        }

        #project {
            padding-left: 10px;
        }

        #project li {
            list-style-type: none;
            color: #5d6975;
        }

        #company {
            float: right;
            text-align: right
        }

        /*#company div, #project div {*/
        /*white-space: nowrap*/
        /*}*/

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        table tr:nth-child(2n-1) td {
            background: #f5f5f5
        }

        table td, table th {
            text-align: center
        }

        table th {
            padding: 5px 20px;
            color: #5d6975;
            border-bottom: 1px solid #5d6975;
            white-space: nowrap;
            font-weight: 400
        }

        table .desc, table .service {
            text-align: left
        }

        table td {
            padding: 10px;
            text-align: right
        }

        table td.desc, table td.service {
            vertical-align: top
        }

        table td.qty, table td.total, table td.unit {
            font-size: 1.2em
        }

        table td.grand {
            border-top: 1px solid #5d6975
        }

        #notices .notice {
            color: #5d6975;
            font-size: 1.2em
        }

        footer {
            color: #5d6975;
            width: 100%;
            height: 30px;
            position: relative;
            bottom: 0;
            border-top: 1px solid #5d6975;
            padding: 8px 0;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo" style="padding: 10px 30px; font-size: 30px; font-weight: bold; color: #5d6975">
        PriceFeed
    </div>
    <h1>Market Distribution Report</h1>
    <ul id="project">
        <li>{{ auth()->user()->name }}</li>
        <li>{{ auth()->user()->company }}</li>
        <li style="padding-bottom: 10px"><a href="mailto:{{ auth()->user()->email }}">{{ auth()->user()->email }}</a>
        </li>
        <li style="border-top: 1px solid #ffffff00;padding-top: 10px">
            This table has market distribution report for your products
        </li>
        <li>File Creation Date: {{ date('d.m.Y') }}</li>
    </ul>
</header>
<main>
    <table>
        <thead>
        <tr>
            @foreach($exportData['rowsData'][0] as $index => $heading)
                <th style="text-align: @if($index==0) left @else center @endif">{{ $heading }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @foreach(array_slice($exportData['rowsData'], 1) as $row)
            <tr>
                @foreach($row as $index => $data)
                    <td style="text-align: @if($index == 0) left @else center @endif">
                        @if($index == 0)
                            {{ $data }}
                        @else
                            {{ $data  }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    <p>* {{ $exportData['filterInfo'] }}</p>
    {{--<div id="notices">--}}
    {{--<div>NOTICE:</div>--}}
    {{--<div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>--}}
    {{--</div>--}}
</main>
<footer>
    <small><span id="year-copy"></span> PriceFeed &copy; {{ config('app.version') }}</small>
</footer>
</body>
</html>