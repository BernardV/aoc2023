<?php

$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$cards = array();

foreach ($input as $line) {
    $temp = explode(' ', $line);
    $cards[] = array('hand'=>$temp[0], 'bid'=>(int)$temp[1]);
}

usort($cards, 'sortHands');

function sortHands ($a, $b)
{
    $hand1Value = calculateValue($a['hand']);
    $hand2Value = calculateValue($b['hand']);

    $cardValues = array('2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6, '7'=>7, '8'=>8, '9'=>9, 'T'=>10, 'J'=>11, 'Q'=>12, 'K'=>13, 'A'=>14);
    if($hand1Value == $hand2Value) {
        $hand1 = str_split($a['hand'], 1);
        $hand2 = str_split($b['hand'], 1);
        while(count($hand1) > 0 && $hand1[0] == $hand2[0]) {
            array_shift($hand1);
            array_shift($hand2);
        }
        return $cardValues[$hand1[0]] < $cardValues[$hand2[0]] ? -1 : 1;

    }

    return $hand1Value < $hand2Value ? -1 : 1;
}

function calculateValue($hand)
{

    $cards = str_split($hand, 1);
    $values = array_map(function($a) { return $a*$a; }, array_count_values($cards));

    return array_sum($values);
}

$total = 0;

foreach ($cards as $key=>$card) {
    $total += ($key+1) * $card['bid'];
}

echo 'Total: ' . $total . PHP_EOL;