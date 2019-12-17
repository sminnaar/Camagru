<?php

class Profile extends Controller {
    
    public $_db;
    
    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        if (!isset($_SESSION['user'])) {
            Router::redirect('');
        }
        $this->_db = DB::getInstance();
    }

    public function delete() {
        if (isset($_POST['delete']) && $_POST['delete']) {
            $image = $_POST['image'];
            $id = $this->_db->query('SELECT id FROM posts WHERE img=?', ['img'=>$image])->results()[0]->id;
            $this->_db->delete('posts', $id);
        }
    }
    public function index() {
       $this->view->render('profile');
    }
}
