<?php
$input = file('input.txt', FILE_IGNORE_NEW_LINES);

$maps = array();
$seeds = array();
$seedPairs = array();
$lastmap = '';

foreach ($input as $line) {
    if(stripos($line, 'seeds:') !== false)
    {
        preg_match_all('/\d+/', $line, $matches);
        $seeds = array_map('intval', $matches[0]);

        for($i = 0 ; $i < count($seeds) ; $i+=2)
        {
            $seedPairs[] = array($seeds[$i], $seeds[$i+1]);
        }

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

foreach ($maps as $key=>$map)
{

    usort($maps[$key], function($a, $b) {
        return $a['start'] > $b['start'] ? 1 : -1;
    });
}

$lowestLocation = PHP_INT_MAX;

foreach ($maps as $mapname=>$map)
{

    $seedPairsNew = array();

    while(count($seedPairs) > 0)
    {
        $seedPair = array_splice($seedPairs, 0, 1)[0];
        $sStart = $seedPair[0];
        $sLength = $seedPair[1];

        foreach ($map as $mapitem) {

            if ($sStart >= $mapitem['start'] && $sStart <= $mapitem['end']) {
                if ($mapitem['length'] >= $sLength)
                {
                    $seedPair[0] = $mapitem['dest'] + $sStart - $mapitem['start'];
                } else {
                    $seedPair[0] = $mapitem['dest'] + $sStart - $mapitem['start'];
                    $dcount = $mapitem['end'] - $sStart + 1;
                    $seedPair[1] = $dcount;

                    $new = array($sStart + $dcount, $sLength - $dcount);
                    $seedPairs[] = $new;
                }

            }
        }
        $seedPairsNew[] = $seedPair;
    }
    $seedPairs = $seedPairsNew;
}

foreach ($seedPairs as $seedPair)
{
    $lowestLocation = min($seedPair[0], $lowestLocation);
}

echo 'Lowest location: ' . $lowestLocation . PHP_EOL;