<?php
class Router {
    public static function route($url) {

        // Extract controller
        $cont = (isset($url[0]) && $url != '') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
        $cont_name = $cont;
        array_shift($url);


        //action
        $action = (isset($url[0]) && $url != '') ? $url[0] . 'Action' : 'indexAction';
        $action_name = $cont;
        array_shift($url);
        // echo $cont . '<br>';
        // echo $action . '<br>';
        // dnd($url);

        //params
        $queryParams = $url;

        $dispatch = new $cont($cont_name, $action);

        if (method_exists($cont, $action)) {
            call_user_func_array([$dispatch, $action], $queryParams);
        }
        else {
            die('That method does not exist in the controller \"' . $cont_name . '\"');
        }
    }
    
}