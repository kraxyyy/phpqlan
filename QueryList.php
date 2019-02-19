<?php

class QueryList {

    private $array;
    private $toStringVariable;

    public function __construct($array) {
        $this->array = $array;
        $this->toStringVariable = false;
    }

    public function setToStringFunction($function) {
        $this->toStringVariable = $function;
        return $this;
    }

    public function getToStringFunction() {
        return $this->toStringVariable;
    }

    public function toString() {
        if($this->toStringVariable === false)
            return $this;

        $this->forAll(function($item) {
            $this->getToStringFunction()($item);
        });

        return $this;
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

        return $this;
    }

    public function subList($start, $end) {
        $temp = [];

        for($i = 0; $i < $this->getLength(); $i++)
            if($i >= $start && $i < $end)
                array_push($temp, $this->array[$i]);

        $this->array = $temp;
        return $this;
    }

    public function contains($function) {
        foreach ($this->array as $item)
            if($function($item))
                return true;

        return false;
    }

    public function fastSearch($function) {
        $amount = $this->getLength();

        if($amount > 1) {

            $amount /= 2;
            $amount = round($amount);

            $list = $this->subList(0, $amount);

            foreach ($list as $item)
                if($function($item))
                    return $item;

            $list = $this->subList($amount, $this->getLength());

            foreach ($list as $item)
                if($function($item))
                    return $item;

            return false;
        }else{
            foreach ($this->array as $item)
                if ($function($item))
                    return $item;
        }
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

        return $this;
    }

    public function display($function) {
        foreach ($this->array as $item)
            echo $function($item) . '<br>';

        return $this->array;
    }

    public function extract($function) {
        $temp = [];

        foreach ($this->array as $item)
            array_push($temp, $function($item));

        $this->array = $temp;

        return $this;
    }

    public function clear() {
        $this->array =  [];
        return $this;
    }

    public function add($item) {
        array_push($this->array, $item);
        return $this;
    }

    public function shuffle() {
        shuffle($this->array);
        return $this;
    }

    public function where($function) {
        $temp = [];

        foreach ($this->array as $item)
            if($function($item))
                array_push($temp, $item);

        $this->array = $temp;
        return $this;
    }

    public function dump() {
        var_dump($this->array);
        return $this;
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

        $this->array = $temp;
        return $this;
    }

    public function remove($function) {
        $temp = [];

        foreach ($this->array as $item)
           if(!$function($item))
               array_push($temp, $item);

        $this->array = $temp;
        return $this;
    }

    public function flip() {
        array_reverse($this->array);
        return $this;
    }

    public function get($index) {
        if($index >= sizeof($this->array))
            return false;

        $temp = 0;

        foreach ($this->array as $item) {
            if($temp === $index)
                return $item;
            $temp++;
        }
        return false;
    }
}