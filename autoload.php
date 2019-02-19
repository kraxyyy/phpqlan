//LISTENER FOR AUTO-INCLUDE NEEDED FILES IN THE GIVEN DIRECTORIES (ADD YOUR DIRECTORIES INTO THE ARRAY)
//EXECUTE THIS METHOD IN YOUR CLIENT-PROVIDER FILES LIKE INDEX.PHP etc.


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
