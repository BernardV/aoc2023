<?php
$time_start = microtime(true);
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$numbers = array_map(function($a) {
    $temp = explode(':', $a);
    $tnum = explode('|', $temp[1]);
    return array('owned'=>1, 'count'=>count(array_intersect(explode(' ', preg_replace('/\s+/', ' ', trim($tnum[0]))), explode(' ',  preg_replace('/\s+/', ' ', trim($tnum[1]))))));
}, $input);

$totalCards = 0;
$points = 0;

foreach ($numbers as $index=>$number)
{
    if($number['count'] > 0) {
        $points += 1 << $number['count'] - 1;
    }
    for($i=1;$i<=$number['count'];$i++) {
        $numbers[$index+$i]['owned']+=$numbers[$index]['owned'];
    }
    $totalCards += $numbers[$index]['owned'];
}

echo 'Part 1: ' . $points . PHP_EOL;
echo 'Part 2: ' . $totalCards . PHP_EOL;
echo 'Total execution time in ms: ' . (microtime(true) - $time_start) * 1000 . PHP_EOL;