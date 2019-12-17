<?php

class Login extends Controller {

    private $_db;
    private $_validate;
    public $errors = [];

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->_db = DB::getInstance();
        $this->_validate = new Validate();
    }

    public function login($input = []) {
        $this->errors = []; 
     
        if ($_POST) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $hash = password_hash($password, PASSWORD_BCRYPT);

            if ($username)
            {
                if ($password) {
                    if ($user = $this->_db->query('SELECT username FROM users WHERE username = ?', ['username' => $username])->results()) {
                        $user = $user[0]->username;
                        if ($pass = $this->_db->query('SELECT pass FROM users WHERE username = ?', ['username'=>$username])->results()) {
                            $pass = $pass[0]->pass;
                        }
                        if ($verify = $this->_db->query('SELECT verified FROM users WHERE username = ?', ['username'=>$username])->results()) {
                            $verify = $verify[0]->verified;
                        }
                        if (password_verify($password, $pass)) {
                            if ($verify)
                            {
                                $_SESSION['user'] = $this->_db->query('SELECT token FROM users WHERE username = ?', ['username'=>$username])->results()[0]->token;
                            } else {
                                echo 'Please verify your email before logging in.';
                            }
                        } else {
                            echo 'Incorrect Password!';
                        }
                    } else {
                        echo 'Username not registered!';
                    }
                } else {
                    echo 'Please enter a password!';
                } 
            } else {
                echo 'Please enter a username!';
            }
        } else {
            Router::redirect('login');
        }

    }

    public function forgot() {

        if ($_POST) {
            $email = htmlspecialchars(htmlentities($_POST['email'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
            $pass = mt_rand(100000, 9999999);
            
            if ($verify = $this->_db->query('SELECT verified FROM users WHERE email = ?', ['email'=>$email])->results()) {
                $verify = $verify[0]->verified;
            }
            if ($verify) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $check = $this->_db->query('SELECT email FROM users WHERE email = ?', ['email'=>$email])->results();
                    if ($check) {
                        $id = $this->_db->query('SELECT id FROM users WHERE email = ?', ['email'=>$email])->results()[0]->id;
                        $fields = ['pass'=>password_hash($pass, PASSWORD_BCRYPT)];
                        $this->_db->update('users', $id, $fields);
                        $subject = "Password reset | Camagru";
                        $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $headers .= "MIME-Version: 1.0" . "\r\n";
                        $headers .= 'From:noreply@camagru.wtc.hi' . "\r\n";
                        $text = "Hello! <br><br>Your password has been reset to: ". $pass; 
                        mail($email, $subject, $text, $headers);
                        echo 'Please check your email!';
                    } else {
                        echo "Email address does not exist!";
                    }
                } else {
                    echo "Please enter a valid email address.";
                }
            } else {
                echo 'Please verify your email before trying to reset your password';
            }
        } else {
            Router::redirect('login');
        }
    }
 
    public function check($check) {
        if (!$check[0]) {
            $this->errors[] = $check[1];
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        Router::redirect('');
    }
	public function index() {
       if (isset($_SESSION['user'])) {
           Router::redirect('profile');
       } else {
            $this->view->render('login');
       }
    }
}
