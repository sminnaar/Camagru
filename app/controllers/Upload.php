<?php
class Upload extends Controller {
    
    private $_db;

    public function __construct($controller, $action) {
        if (!isset($_SESSION['user'])) {
            Router::redirect('');
            return;
        }
        parent::__construct($controller, $action);
        $this->_db = DB::getInstance();
    }

    public function index() {
       $this->view->render('upload');
    }

    public function logout() {
        unset($_SESSION['user']);
        Router::redirect('');
    }

    public function upload() {
        if (isset($_POST['img'])) {
            $img = $_POST['img'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file =  ROOT . DS . 'img' . DS . 'img_' . date('YmdHis') . '.png';

            file_put_contents($file, $data);

            $save = 'img' . DS . 'img_' . date('YmdHis') . '.png';
            $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
            $fields = ['img'=>$save, 'user'=>$id]; 

            $this->_db->insert('posts', $fields);

        } else {
            echo "Error: No image data";
        }
    }

    public function upload_prev() {
        if (!empty($_FILES['image']['name'])) {
            if (isset($_FILES['image'])) {
                $errors = [];
                $file_name = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_ext = explode('.', $_FILES['image']['name']);
                $file_ext = strtolower(end($file_ext));
                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext,$extensions) === false) {
                    $errors[] = "Extension not allowed: Please choose a JPEG or PNG file.";
                }

                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, ROOT . DS . 'img' . DS . 'temp' . DS . $file_name);
                    echo 'img' . DS . 'temp' . DS . $file_name;
                } else {
                    echo implode(' ', $errors);
                }
            }
        } else {
            echo "Please select a file";
        }
    }
    
    public function upload_file() {
        if (!empty($_FILES['image']['name'])) {
            if (isset($_FILES['image'])) {

                $errors = [];
                $file_name = $_FILES['image']['name'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];
                $file_ext = explode('.', $_FILES['image']['name']);
                $file_ext = strtolower(end($file_ext));

                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext,$extensions) === false) {
                    $errors[] = "Extension not allowed: Please choose a JPEG or PNG file.";
                }

                if (empty($errors) == true) {
                    move_uploaded_file($file_tmp, ROOT . DS . 'img' . DS . 'profile' . DS . $file_name);

                    $save = 'img' . DS . 'profile' . DS . $file_name;
                    $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
                    $fields = ['img'=>$save,'user'=>$id]; 
                    $this->_db->insert('posts', $fields);
                } else {
                    echo implode(' ', $errors);
                }
            }
        } else {
            echo "Please select a file";
        }
    }
}