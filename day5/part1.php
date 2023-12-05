<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$maps = array();
$seeds = array();

$lastmap = '';

foreach ($input as $line) {
    if(stripos($line, 'seeds:') !== false)
    {
        preg_match_all('/\d+/', $line, $matches);
        $seeds = array_map('intval', $matches[0]);

    } elseif(stripos($line, 'map:') !== false)
    {
        $temp = explode(' map:', $line);
        $lastmap = $temp[0];
    } elseif (trim($line) !== '') {
        preg_match_all('/\d+/', $line, $matches);
        if(!isset($maps[$lastmap]))
        {
            $maps[$lastmap] = array();
        }
        $tempmap = array_map('intval', $matches[0]);
        $maps[$lastmap][] = array('start'=>$tempmap[1], 'end'=>$tempmap[1] + $tempmap[2] - 1, 'dest'=>$tempmap[0], 'length'=>$tempmap[2]);
    }
}

$lowestLocation = PHP_INT_MAX;

foreach ($seeds as $seed)
{
    foreach ($maps as $map)
    {
        foreach ($map as $mapitem)
        {
            if($seed >= $mapitem['start'] && $seed <= $mapitem['end'])
            {
                $seed = $mapitem['dest'] + $seed - $mapitem['start'];
                break;
            }
        }
    }
    $lowestLocation = min($seed, $lowestLocation);
}

echo 'Lowest location: ' . $lowestLocation . PHP_EOL;