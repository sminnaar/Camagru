<?php

class Register extends Controller {

    private $_db;
    private $_validate;
    public $errors = [];

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->_db = DB::getInstance();
        $this->_validate = new Validate();
    }

    public function register($input = []) {
       $this->errors = [];
       if ($_POST) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $vpassword = htmlspecialchars($_POST['vpassword']);
            $email = htmlspecialchars($_POST['email']); 
            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

            $this->check($check = $this->_validate->check(['username', $username]));
            $this->check($check = $this->_validate->check(['password', $password]));
            $this->check($check = $this->_validate->check(['email', $email]));
            $this->check($check = $this->_validate->check(['match', $password, $vpassword]));
            if (!$this->errors) {
                $fields = ['username'=>$username, 'email'=>$email, 'pass'=>password_hash($password, PASSWORD_BCRYPT), 'token'=>$token, 'photo'=>'img/profile/def4.jpg']; 
                $this->_db->insert('users' , $fields);
                $link = "<a href='http://127.0.0.1:8080/Camagru_git/register/verify/" . $token . "'> Verify </a>";
                $this->email($email, $link);
                echo 'Please check your email for a verification link!';
            } else {
                echo implode(",", $this->errors);
            }
       } else {
            Router::redirect('');
       }
    }

    public function email($email, $link) {
        $subject = "Email verification | Camagru";
        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= 'From:noreply@camagru.wtc.hi' . "\r\n";
        $text = "Hello!<br><br>Please follow the link to verify your account with Camagru: " . $link; 
        mail($email, $subject, $text, $headers);
    }
 
    public function logout() {
        unset($_SESSION['user']);
        Router::redirect('');
    }

    public function verify($token) {
        $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$token])->results()[0]->id;
        $fields = ['verified' => 1];
        $this->_db->update('users', $id, $fields);
        Router::redirect('login');
    }

    public function check($check) {
        if (!$check[0]) {
            $this->errors[] = $check[1];
        }
    }

    public function index() {
        if (isset($_SESSION['user'])) {
            Router::redirect('profile');
        } else {
             $this->view->render('register');
        }
    }
}