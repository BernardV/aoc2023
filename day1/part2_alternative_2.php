<?php
$time_start = microtime(true);

$input = array_map(function($a) {
    $replace = array('one' => 'one1one', 'two' => 'two2two', 'three' => 'three3three', 'four' => 'four4four', 'five' => 'five5five', 'six' => 'six6six', 'seven' => 'seven7seven', 'eight' => 'eight8eight', 'nine' => 'nine9nine');

    $a = str_replace(array_keys($replace), array_values($replace), $a);

    $chars = str_split($a);

    $numbers = array_filter($chars, function($a){
        return is_numeric($a);
    });
    return intval(reset($numbers) . end($numbers));
},
    file('input.txt', FILE_IGNORE_NEW_LINES)
);

$sum = array_sum($input);

echo 'Sum: ' . $sum . PHP_EOL;
echo 'Total execution time in ms: ' . (microtime(true) - $time_start) * 1000 . PHP_EOL;