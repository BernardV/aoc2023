<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$games = array();

$sum = 0;

foreach ($input as $line) {
    preg_match('/Game (\d+)/', $line, $matches);
    $game = (int)$matches[1];
    $line = substr($line, strlen($matches[0]) + 2);
    $turns = explode(';', $line);
    $games[$game] = array();
    $correct = true;
    $result = array('red' => 0, 'green' => 0, 'blue' => 0);
    foreach ($turns as $turn) {
        $turn = explode(',', $turn);

        foreach ($turn as $item) {
            $item = explode(' ', trim($item));
            $result[$item[1]] =  max($result[$item[1]], (int)$item[0]);
        }
    }
    $sum += array_product($result);
}

echo 'Sum of correct game ids: ' . $sum . PHP_EOL;