<?php
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
$checkPositions = array(-1,1, $l, -$l,$l+1, -$l+1, $l-1, -$l-1);

foreach ($flat as $key => $value) {
    if (is_numeric($value)) {
        $buffer[] = $value;
        foreach ($checkPositions as $checkPosition) {
            $dpos = $key+$checkPosition;

            if($dpos < 0 || $dpos > $l*$h-1) {
                continue;
            }

            $char = $flat[$dpos];

            if(!is_numeric($char) && $char !== '.') {
                if($char === '*') {
                    $gearPos = $dpos;
                }
                $symbolFound = true;
            }
        }
    } else {
        if($symbolFound)
        {
            $number = implode('', $buffer);
            $sum += (int)$number;
            if($gearPos > 0) {
                if(!isset($gears[$gearPos]))
                {
                    $gears[$gearPos] = array();
                }
                $gears[$gearPos][] = $number;
            }
        }
        $gearPos = 0;
        $buffer = array();
        $symbolFound = false;
    }

}

$filteredGears = array_map(function($a) {
    if(count($a) > 1) {
        return array_product($a);
    }
    return 0;
}, $gears);

$gearSum = array_sum($filteredGears);

echo 'Part 1 sum: ' . $sum . PHP_EOL;
echo 'Part 2 sum: ' . $gearSum . PHP_EOL;