<?php

spl_autoload_register(function ($class_name) {
    $directories = ["", "/", "./"];

    foreach ($directories as $dir) {
        if(file_exists($dir . $class_name . '.php')) {
            include_once $dir . $class_name . '.php';
            return true;
        }
    }
    return false;
});

$array = [
    ["name" => "Max Mustermann", "age" => 19],
    ["name" => "Maximiliane Mustermann", "age" => 23],
    ["name" => "Markus Mustermann", "age" => 21]
];

$list = new QueryList($array);

$list->setToStringFunction(function($item) {

    echo 'Person: ' . $item["name"] . '<br>';

})->toString()->where(function($item) {

   return $item["age"] > 20;

})->take(2)->shuffle()->display(function($item) {

    return $item["name"] . ' > ' . $item["age"] . '<br>';

});
