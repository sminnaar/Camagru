<?php

class Home extends Controller {
    
    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
    }

 
    public function logout() {
        unset($_SESSION['user']);
        Router::redirect('');
    }

    public function index() {
       if (!isset($_SESSION['user'])) {
           $this->view->render('index');
       }
       else {
           $this->view->render('profile');
       }
    }
}