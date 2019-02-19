<?php

class QueryList {

    private $array;

    public function __construct($array) {
        $this->array = $array;
    }

    public function toArray() {
        return $this->array;
    }

    public function getLength() {
        return sizeof($this->array);
    }

    public function forAll($function) {
        for($i = 0; $i < sizeof($this->array); $i++)
            $function($this->array[$i]);

        return new QueryList($this->array);
    }

    public function contains($function) {
        foreach ($this->array as $item)
            if($function($item))
                return true;

        return false;
    }

    public function sort($function) {
        for($i = 0; $i < sizeof($this->array); $i++) {
            for ($x = 0; $x < sizeof($this->array); $x++) {
                if(isset($this->array[$x]) && isset($this->array[$x + 1])) {
                    $res = $function($this->array[$x], $this->array[$x + 1]);

                    if($res) {
                        $temp = $this->array[$x];

                        $this->array[$x] = $this->array[$x + 1];
                        $this->array[$x + 1] = $temp;
                    }
                }
            }
        }

        return new QueryList($this->array);
    }

    public function display($function) {
        foreach ($this->array as $item)
            echo $function($item) . '<br>';

        return new QueryList($this->array);
    }

    public function extract($function) {
        $temp = [];

        foreach ($this->array as $item)
            array_push($temp, $function($item));

        return new QueryList($temp);
    }

    public function clear() {
        return new QueryList([]);
    }

    public function add($item) {
        array_push($this->array, $item);
    }

    public function shuffle() {
        shuffle($this->array);
        return new QueryList($this->array);
    }

    public function where($function) {
        $temp = [];

        foreach ($this->array as $item) {
            if($function($item))
                array_push($temp, $item);
        }
        return new QueryList($temp);
    }

    public function dump() {
        var_dump($this->array);
        return new QueryList($this->array);
    }

    public function take($amount) {
        $temp = [];

        $counter = 0;

        foreach ($this->array as $item) {
            $counter++;
            if ($amount >= $counter)
                array_push($temp, $item);
            else
                break;
        }
        return new QueryList($temp);
    }

    public function remove($function) {
        $temp = [];

        foreach ($this->array as $item)
           if(!$function($item))
               array_push($temp, $item);

        return new QueryList($temp);
    }

    public function get($index) {
        if($index >= sizeof($this->array))
            return false;

        $temp = 0;

        foreach ($this->array as $item) {
            if($temp === $index)
                return $index;
            $temp++;
        }

        return false;
    }
}