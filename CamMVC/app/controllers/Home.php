<?php

    class Home extends Controller {

        public function __construct($controller, $action) {
            parent::__construct($controller, $action);
        }

        public function indexAction() {
            //echo $name;
            $this->view->render('home/index');
            //die('Welcome to the Home controller, this is the index action');
        }
    }