<?php
$input = array_map(function($a){
    $chars = str_split($a);
    $b = array_filter($chars, function($a){
        return is_numeric($a);
    });
    return intval(reset($b) . end($b));
    },
    file('input.txt', FILE_IGNORE_NEW_LINES)
);

$sum = array_sum($input);

echo 'Sum: ' . $sum . PHP_EOL;
