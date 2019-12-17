<?php

function dnd($data) {

    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}


function dump($text, $data = '') {
    ob_start();
    debug_print_backtrace();
    $trace = ob_get_contents();
    $trace = preg_split('/#/', $trace);
    array_shift($trace);
    $dump = $trace[0];
    $dump = preg_split('/ /', $dump);
    $dump = preg_replace('/\s\s+/', '', $dump[array_key_last($dump)]); 
    array_shift($trace);
    $trace = array_reverse($trace);
    ob_end_clean();
   
    echo '<pre>';
    echo '<hr>';
    if ($trace) {
            foreach ($trace as $line) {
                echo "  > " . $line;
            } 
        }
        echo "--> 1  " . $text . " || " . $dump;
        if ($data) {
            print_r($data);
        }
    echo '</pre>';
}

function sanitize($dirty) {
    return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
}

function currentUser() {
    return Users::currentUser();
}


function getConstants() {
    $constants = get_defined_constants();
    $new_constants = get_defined_constants();
    $myconstants = array_diff_assoc($new_constants, $constants); //compares array keys and values, and returns the differences.
    var_export($myconstants); //return the structured value of $myconstants 
}