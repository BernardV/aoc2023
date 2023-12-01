<?php
$input = array_map(function($a) {
    $replace = array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6, 'seven' => 7, 'eight' => 8, 'nine' => 9);
    $numbers = array();

    for($i = 0; $i < strlen($a); $i++) {
        if(is_numeric(substr($a, $i, 1))) {
            $numbers[] = (int) $a[$i];
        } else {
            foreach ($replace as $key => $value) {
                if (substr($a, $i, strlen($key)) === $key) {
                    $numbers[] = $value;
                }
            }
        }
    }

    return intval(reset($numbers) . end($numbers));
},
    file('input.txt', FILE_IGNORE_NEW_LINES)
);

$sum = array_sum($input);

echo 'Sum: ' . $sum . PHP_EOL;
