<?php

class Settings extends Controller {
    
    public $_db;
    private $_validate;
    public $errors = [];
    private $checked;

    public function __construct($controller, $action) {
        if (!isset($_SESSION['user'])) {
            Router::redirect('');
            return;
        }
        parent::__construct($controller, $action);
        $this->_db = DB::getInstance();
        $this->_validate = new Validate();
    }

    public function check($check) {
        if (!$check[0]) {
            $this->errors[] = $check[1];
        }
    }

    public function index() {
        $this->view->render('settings');
    }

    public function logout() {
        unset($_SESSION['user']);
        Router::redirect('');
    }

    public function upload() {
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
                    $fields = ['photo'=>$save];
                    $this->_db->update('users', $id, $fields);
                } else {
                    echo implode(' ', $errors);
                }
            }
        } else {
            echo "Please select a file";
        }
    }

    public function names() {
        if ((isset($_POST['fname']) && isset($_POST['lname']) && ($_POST['fname']) && $_POST['lname'])) {

        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);

        if (preg_match("/^[- '\p{L}]+$/u", $fname) && preg_match("/^[- '\p{L}]+$/u", $lname)) {
        $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
        $fields = ['fname'=>$fname, 'lname'=>$lname];
        $this->_db->update('users', $id, $fields);
        } else {
            echo "Names can only contain Lowercase and Uppercase characters";
        }
        } else {
            echo "Please enter your details.";
        }
    }

    public function username() {
        $username = htmlspecialchars($_POST['username']);
        
        if (!$username) {
            echo "Please enter a username.";
        }
        $check = $this->_db->query('SELECT username FROM users WHERE username = ?', ['username' => $username])->results();
        if (!$check) {
            if (strlen($username) >= 3 && strlen($username) <= 32) {
                if (preg_match('/^[\w]{3,32}$/i', $username)) {
                    $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
                    $fields = ['username'=>$username];
                    $this->_db->update('users', $id, $fields);
                    echo 'Updated.';
                } else {
                    echo "Usernames can only contain uppercase, lowercase and digits.";
                }
            } else {
                echo "Username must be between 3 and 32 characters long.";
            }
        } else {
            echo "User $username already exists.";
        }
    }

    public function update_email() {

        if ((isset($_POST['email'])) && ($_POST['email'])) {
            $email = htmlspecialchars($_POST['email']);
            $this->check($check = $this->_validate->check(['email', $email]));
             if (!$this->errors) {
		        $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
                $fields = ['email'=>$email, 'verified'=>0];
                $this->_db->update('users', $id, $fields);

                // Email verification
                $link = "<a href='http://127.0.0.1:8080/Camagru_git/register/verify/" . $_SESSION['user'] . "'> Verify </a>";

                $subject = "Email change verification | Camagru";
                $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $headers .= 'From:noreply@camagru.wtc.hi' . "\r\n";
                $text = "Hello! <br><br>Please follow the link to verify your new email with Camagru: " . $link; 
                mail($email, $subject, $text, $headers);
                unset($_SESSION['user']);
            } else {
                echo implode(",", $this->errors);
            }
        } else {
            echo "Please enter an email.";
        }
    }

    public function pass() {

        $pass = htmlspecialchars($_POST['password']);
        $vpass = htmlspecialchars($_POST['vpassword']);
        
        $this->check($check = $this->_validate->check(['password', $pass]));
        $this->check($check = $this->_validate->check(['match', $pass, $vpass]));

        if (!$this->errors) {
            $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
            $fields = ['pass'=>password_hash($pass, PASSWORD_BCRYPT)];
            $this->_db->update('users', $id, $fields);
            unset($_SESSION['user']);
        }
        else {
            echo implode(",", $this->errors);
        }
    }

    public function notifyon() {
        $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
        $fields = ['notify'=>1];
        $this->_db->update('users', $id, $fields);
        Router::redirect('settings');
    }
    
    public function notifyoff() {
        $id = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
        $fields = ['notify'=>0];
        $this->_db->update('users', $id, $fields);
        Router::redirect('settings');
    }
}