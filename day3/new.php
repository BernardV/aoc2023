<?php
$time_start = microtime(true);
$input = file('input.txt', FILE_IGNORE_NEW_LINES);
$l = strlen($input[0]);
$h = count($input);

//Create flat array
$flat = array();
foreach ($input as $line) {
    $flat = array_merge($flat, str_split($line));
}

$sum = 0;

$buffer = array();
$symbolFound = false;
$gearPos = 0;
$gears = array();

preg_match_all('/\d+/', implode('', $flat), $numbers, PREG_OFFSET_CAPTURE);

foreach ($numbers[0] as $number) {
    $offset = $number[1];
    $nlength = strlen($number[0]);

    $checkPositions = array(-1,$nlength);

    for($i = -1; $i <= $nlength; $i++) {
        $checkPositions[] = $l + $i;
        $checkPositions[] = -$l + $i;
    }

    foreach ($checkPositions as $checkPosition) {
        $dpos = $offset+$checkPosition;

        if($dpos < 0 || $dpos > $l*$h-1) {
            continue;
        }

        $char = $flat[$dpos];

        if(!is_numeric($char) && $char !== '.') {
            $sum += (int)$number[0];
            if($char === '*') {
                if(!isset($gears[$dpos]))
                {
                    $gears[$dpos] = array();
                }
                $gears[$dpos][] = (int)$number[0];
            }
            break;
        }
    }
}

$filteredGears = array_map(function($a) {
    if(count($a) === 2) {
        return array_product($a);
    }
    return 0;
}, $gears);

$gearSum = array_sum($filteredGears);

echo 'Part 1 sum: ' . $sum . PHP_EOL;
echo 'Part 2 sum: ' . $gearSum . PHP_EOL;
echo 'Total execution time in ms: ' . (microtime(true) - $time_start) * 1000 . PHP_EOL;