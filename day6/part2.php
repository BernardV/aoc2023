<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$races = array();

preg_match_all('/\d+/', str_replace(' ', '', $input[0]), $matches);
$races = array_map(function($a){ return array('duration'=>(int)$a);}, $matches[0]);

preg_match_all('/\d+/', str_replace(' ', '', $input[1]), $matches);
foreach ($matches[0] as $key => $value) {
    $races[$key]['distance'] = (int)$value;
}

$result = 1;

foreach ($races as $key => $race) {
    $duration = $race['duration'];
    $distance = $race['distance'];

    $count = 0;

    for($i = 0 ; $i <= $duration; $i++) {
        if(($duration - $i) * $i > $distance) {
            $count++;
        }
    }

    $result *= $count;
}

echo 'Result: ' . $result . PHP_EOL;