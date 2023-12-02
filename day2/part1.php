<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$games = array();

$max = array('red' => 12, 'green' => 13, 'blue' => 14);

$sumids = 0;

foreach ($input as $line) {
    preg_match('/Game (\d+)/', $line, $matches);
    $game = (int)$matches[1];
    $line = substr($line, strlen($matches[0]) + 2);
    $turns = explode(';', $line);
    $games[$game] = array();
    $correct = true;
    foreach ($turns as $turn) {
        $turn = explode(',', $turn);
        $result = array('red' => 0, 'green' => 0, 'blue' => 0);
        foreach ($turn as $item) {
            $item = explode(' ', trim($item));
            $result[$item[1]] =  (int)$item[0];
        }
        if ($result['red'] > $max['red'] || $result['green'] > $max['green'] || $result['blue'] > $max['blue']) {
            $correct = false;
        }

        $games[$game][] = $result;
    }
    if ($correct) {
        $sumids += $game;
    }
}

echo 'Sum of correct game ids: ' . $sumids . PHP_EOL;