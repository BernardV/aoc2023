<?php
$input = array_map(function($a) {
    $replace = array('one' => '1', 'two' => '2', 'three' => '3', 'four' => '4', 'five' => '5', 'six' => '6', 'seven' => '7', 'eight' => '8', 'nine' => '9');

    $a = preg_replace_callback('/(?=(' . implode('|', array_keys($replace)) . '))/', function($a) use ($replace){
        return $replace[$a[1]];
    }, $a, -1);

    $chars = str_split($a);

    $c = array_filter($chars, function($a){
        return is_numeric($a);
    });

    return intval(reset($c) . end($c));

},
    file('input.txt', FILE_IGNORE_NEW_LINES)
);

$sum = array_sum($input);

echo 'Sum: ' . $sum . PHP_EOL;
