<?php


class graph
{
    public $point;
    public $link;
    public $len;

    public function __construct($point = [], $link = [])
    {
        $this->point = $point;
        $this->link = $link;
        $this->len = count($point);
    }

    public function coloringGraph()
    {
        $coloring = $this->preparationGraph();
        $len = $this->len;
        $color = 100;
        for ($j = 0; $j < $len; $j++) {
            if (!$coloring[$j]->flag) {
                $coloring[$j]->flag = 1;
                $coloring[$j]->color = $color;
                for ($k = 0; $k < $len; $k++) {
                    if ((!$coloring[$k]->flag) and (!$coloring[$j]->arrLink[$k])) {
                        $coloring[$k]->flag = 1;
                        $coloring[$k]->color = $color;
                        for ($t = 0; $t < $len; $t++) {
                            $arrO[$t] = $t < $j ? 1 : ($coloring[$k]->arrLink[$t] || $coloring[$j]->arrLink[$t]);
                            $coloring[$k]->arrLink[$t] = $arrO[$t];
                            $coloring[$j]->arrLink[$t] = $arrO[$t];
                        }
                    }
                }
            } else {
                $color++;
            }
        }
        return $coloring;
    }

    public function preparationGraph()
    {
        $link = $this->link;
        $len = $this->len;
        for ($j = 0; $j < $len; $j++) {
            $preparation[$j] = new structGraph($j, $len);
            for ($v = 0; $v < count($link); $v++) {
                if ($link[$v][0] == $preparation[$j]->key) {
                    $preparation[$j]->arrLink[$link[$v][1]] = 1;
                }
                if ($link[$v][1] == $preparation[$j]->key) {
                    $preparation[$j]->arrLink[$link[$v][0]] = 1;
                }
            }
        }
        return $preparation;
    }
}

class structGraph
{
    public $key;
    public $color;
    public $flag;
    public $len;
    public $arrLink;

    public function __construct($key, $len)
    {
        $this->key = $key;
        $this->color = 0;
        $this->flag = false;
        for ($i = 0; $i < $len; $i++) {
            $this->arrLink[$i] = 0;
        };
        $this->arrLink[$key] = 1;
        $this->len = $len;
    }
}






// ============================================= example

print '<pre>';
$point = ['a-d6-c-b4', 'b1-a', 'b2-d5', 'b3-c', 'c-b6-a-d4', 'd1-c', 'd2-b5', 'd3-a'];
$link = [[0, 2], [0, 3], [0, 4], [0, 5], [0, 6], [0, 7], [1, 4], [1, 7], [2, 4], [2, 7], [3, 4], [3, 5], [3, 6], [3, 7], [4, 6], [4, 7]];

$graphObject = new graph($point, $link);
// $preparations = $graphObject->preparationGraph();
$colorings = $graphObject->coloringGraph();

foreach ($colorings as $ob) {
    $colors[] = $ob->color;
}
print_r($colors);
print_r($colorings);

print '</pre>';
