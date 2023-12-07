<?php

$input = file('aoc-2023-day-07-challenge-1.txt', FILE_IGNORE_NEW_LINES);

$cards = array();

foreach ($input as $line) {
    $temp = explode(' ', $line);
    $cards[] = array('hand'=>$temp[0], 'bid'=>(int)$temp[1], 'value'=>calculateValue($temp[0]));
}

usort($cards, 'sortHands');

function sortHands ($a, $b)
{
    $hand1Value = $a['value'];
    $hand2Value = $b['value'];

    $cardValues = array('J'=>1, '2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6, '7'=>7, '8'=>8, '9'=>9, 'T'=>10, 'Q'=>12, 'K'=>13, 'A'=>14);
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
    $values = array_count_values($cards);

    if(isset($values['J']) && $values['J'] < 5) {
        $index = array_search(max($values), $values);
        if($index != 'J') {
            $values[$index] += $values['J'];
            unset($values['J']);
        } else {
            $temp = $values['J'];
            unset($values['J']);
            $index = array_search(max($values), $values);
            $values[$index] += $temp;

        }
    }

    $values = array_map(function($a) { return $a*$a; }, $values);
    return array_sum($values);
}

$total = 0;

foreach ($cards as $key=>$card) {
    $total += ($key+1) * $card['bid'];
}

echo 'Total: ' . $total . PHP_EOL;