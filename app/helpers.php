<?php


function ___($word, $isCapital = false, $multiple = false, $replace = [], $locale = null)
{
    $string = $multiple ? trans_choice($word, $multiple, $replace, $locale) : trans($word, $replace, $locale);
    return $isCapital ? ucwords($string) : ucfirst($string);
}

function t($text, $uppercase = false)
{
    $text = 'general.' . $text;
    return $uppercase ? ucwords(__($text)) : ucfirst(__($text));
}

function r($text)
{
    return $text;
//    return __('routes.' . $text);
}

function putBrTag($string, $after)
{
    $stringArray = explode(" ", $string);
    $string = '';
    foreach ($stringArray as $index => $item) {
        if (($index + 1) == $after) {
            $item = $item . '<br/>';
        }
        $string = $string . " $item";
    }
    return $string;
}

//Function overridden
function formatMoney($number)
{

    return number_format($number, 2, ',', '.').' €';
//    return \App\Services\FormatMoney::EUR($number);
}

function hex2rgba($color, $opacity = false)
{

    $default = 'rgb(0,0,0)';

    //Return default if no color provided
    if (empty($color))
        return $default;

    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }

    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }

    //Return rgb(a) color string
    return $output;
}

function getMenu()
{
    if (app()->getLocale() === 'en') {
        return config('menu.en');
    }

    return config('menu.de');
}

function routeHas($string, $contains = false)
{
    return $contains ? starts_with(Route::currentRouteName(), $string) : Route::is($string);
}

function getGradient($difference, $moreIsBetter = false)
{
    $colours = [
        'good' => '108, 189, 143',
        'bad' => '255, 76, 106',
        'neutral' => '0,70,200'
    ];

    if ($difference == 0 || $difference == 0.00 || $moreIsBetter === null) {
        $colour = $colours['neutral'];
    } else {
        if ($moreIsBetter) {
            $colour = $difference > 0 ? $colours['good'] : $colours['bad'];
        } else {
            $colour = $difference > 0 ? $colours['bad'] : $colours['good'];
        }
    }
//    if ($difference >= 50 || $difference <= -50) {
//        $opacity = 1;
//    } else {
//        $opacity = number_format((50 + abs($difference)) / 100, 2);
//    }
    return 'rgba(' . $colour . ',' . 1 . ')';
}

//custom color function for charts
function getGradientChart($difference, $moreIsBetter = false)
{
    $colours = [
        'good' => '131,255,220',
        'bad' => '254,77,103',
        'neutral' => '0,70,200'
    ];

    if ($difference == 0 || $moreIsBetter === null) {
        $colour = $colours['neutral'];
    } else {
        if ($moreIsBetter) {
            $colour = $difference > 0 ? $colours['good'] : $colours['bad'];
        } else {
            $colour = $difference > 0 ? $colours['bad'] : $colours['good'];
        }
    }
    if ($difference >= 50 || $difference <= -50) {
        $opacity = 1;
    } else {
        $opacity = number_format((50 + abs($difference)) / 100, 2);
    }
    return 'rgba(' . $colour . ',' . $opacity . ')';
}


function gradientForAvgCategories($difference)
{
    if ($difference > 0) {
        $colour = '108, 189, 143';
        $opacity = '1';
    } elseif ($difference == 0) {
        $colour = '108, 189, 143';
        $opacity = '1';
    } else {
        $colour = '255, 76, 106';
        $opacity = '1';
    }
    return 'rgba(' . $colour . ',' . $opacity . ')';
}

/**
 * It will check the condition and trigger the color as needed.
 * @param $difference
 * @param $getProduct
 * @param $equalityPercentage
 * @param bool $moreIsBetter
 * @return string
 */
function getGradientWithEqualityPercentage($difference, $getProduct, $equalityPercentage, $moreIsBetter = false)
{
    $priceDifference = $getProduct->product->price - $getProduct->mainProduct->price;
    $priceDifferencePercentage = round(($priceDifference / $getProduct->mainProduct->price) * 100, 2);
    if (($priceDifferencePercentage >= -1 * $equalityPercentage) && ($priceDifferencePercentage <= $equalityPercentage)) {
        return "rgba(0,70,200,0.50)";
    } else {
        return getGradient($difference, $moreIsBetter);
    }
}


function showVisualDifference($difference, $percents = false, $cents = false)
{
    if ($cents) {
        $difference = number_format($difference / 100, 2);
    }
    if ((float)$difference === 0 || (float)$difference === 0.00) {
        return 0 . ($percents ? ' %' : '');
    }
    return ($difference > 0 ? '+ ' : '- ') . abs($difference) . ($percents ? ' %' : '');
}

function percentise($value, $percented = true)
{
    $value = number_format($value * 100, 2);
    return $percented ? $value . '%' : $value;
}

function categories()
{
    return auth()->user()->categories;
}

function getRandomMultiplier()
{
    return (110 - rand(0, 20)) / 100; // 0.90 - 1.10
}

function storage()
{
    return \Storage::disk('public');
}

function slugify($name)
{
    return str_replace('_', '-', snake_case(strtolower($name)));
}

/**
 * Get either a rotating or a precise header colour (hc)
 *
 * @param $identifier
 * @return string
 */
function hc($identifier)
{
    $colours = [
        'red',
        'purple',
        'orange',
        'red',
        'green',
        'blue',
        'sweet_pink',
        'lavender_purple',
        'manhattan',
    ];

    return is_string($identifier) ? 'header-' . $identifier : 'header-' . $colours[$identifier % count($colours)];
}


function calculateTrendLine($dataArr)
{
    if (count($dataArr) == 0) {
        return false;
    }
    $dataArr = array_values(array_filter($dataArr, function ($value) {
        return $value !== null;
    }));

    $y = $dataArr; // x
    $x = [1]; // y
    for ($i = 1; $i < count($dataArr); $i++) {
        array_push($x, $i);
    }

    $linearRegression = linearRegression($x, $y);

    $y = [];
    for ($i = 0; $i < count($x); $i++) {
        $number = $x[$i] * $linearRegression['slope'] + $linearRegression['intercept'];
        $y[$i] = ($number <= 0) ? 0 : $number;
    }
    return ['start' => min($y), 'end' => max($y)];
}


/*
 * linear regression function
 * @param $x array x-coords
 * @param $y array y-coords
 * @returns array() m=>slope, b=>intercept
 */

function linearRegression($x, $y)
{
    $n = count($x);     // number of items in the array
    $xSum = array_sum($x); // sum of all X values
    $ySum = array_sum($y); // sum of all Y values
    $xxSum = 0;
    $xySum = 0;

    for ($i = 0; $i < $n; $i++) {
        $xySum += (isset($x[$i]) && isset($y[$i])) ? ($x[$i] * $y[$i]) : 0;
        $xxSum += (isset($x[$i]) && isset($x[$i])) ? ($x[$i] * $x[$i]) : 0;
    }

    $divisor = (($n * $xxSum) - ($xSum * $xSum));
    // Slope
    if ($divisor > 0) {
        $slope = (($n * $xySum) - ($xSum * $ySum)) / (($n * $xxSum) - ($xSum * $xSum));
    } else {
        $slope = 0;
    }

    // calculate intercept
    $intercept = ($ySum - ($slope * $xSum)) / $n;

    return array(
        'slope' => $slope,
        'intercept' => $intercept,
    );

}

function priceToFloat($s)
{
    // convert "," to "."
    $s = str_replace(',', '.', $s);

    // remove everything except numbers and dot "."
    $s = preg_replace("/[^0-9\.]/", "", $s);

    // remove all seperators from first part and keep the end
    $s = str_replace('.', '', substr($s, 0, -3)) . substr($s, -3);

    // return float
    return (float)$s;
}

function roundDown($decimal, $precision)
{
    $sign = $decimal > 0 ? 1 : -1;
    $base = pow(10, $precision);
    return floor(abs($decimal) * $base) / $base * $sign;
}

function customNumberFormatter($number, $percentage = true)
{
    $number = (string)$number;
    if ($number < 0) {
        $n = explode('-', $number);
        $number = '- ' . $n[1] . $percentage ? ' %' : '';
    } elseif ($number > 0) {
        $n = explode('+', $number);
        $number = '+ ' . $n[1] . $percentage ? ' %' : '';
    } else {
        $number = '0 ' . $percentage ? ' %' : '';
    }
    return $number;
}

/*
 * @param translated words
 * Breaks words to array and insert break tag after 2 words
 */

function insertBrTagToWords($words)
{
    $words = explode(' ', $words);
    if (count($words) > 2) {
        end($words);
        $string = '<b>'.$words[0].' '.$words[1]. '</b><br />' . implode(' ', array_slice($words, 2));
    } else {
        $string =  $words;
    }

    return $string;
}

/*
 * @param date Array
 * returns generated dates array
 */

function generateDatesWithInterval($dates)
{
    $startDate = reset($dates);
    $endDate = end($dates);
    $start = (new \Carbon\Carbon($startDate));
    $end = (new \Carbon\Carbon($endDate));
    $dayDiff = $end->diffInDays($start);
    if ($dayDiff < 16) {
        $interval = 'P1D';
    } else if ($dayDiff > 15 && $dayDiff < 31) {
        if ($dayDiff % 2 == 0) {
            $interval = 'P2D';
        } else if ($dayDiff % 3 == 0) {
            $interval = 'P3D';
        } else {
            $interval = 'P1D';
        }
    } else {
        if ($dayDiff % 4 == 0) {
            $interval = 'P4D';
        } else if ($dayDiff % 3 == 0) {
            $interval = 'P3D';
        } else if ($dayDiff % 5 == 0) {
            $interval = 'P5D';
        } else {
            $interval = 'P1D';
        }
    }

    $period = new \DatePeriod(new \DateTime($start), new \DateInterval($interval), new \DateTime($end . '+1 day'));
    foreach ($period as $date) {
        $dateArray[] = $date->format("d.m.Y");
    }
    return $dateArray;
}