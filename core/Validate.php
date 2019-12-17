<?php
 
class Validate {

    private $_db;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function check($input = []) {
        if ($input) {
            if ($input[0] == 'username') {
                return $this->username($input);
            }
            if ($input[0] == 'password') {
                return $this->password($input);
            }
            if ($input[0] == 'email') {
                return $this->email($input);
            }
            if ($input[0] == 'match') {
                return $this->match($input);
            }
        }
    }

    public function username($input) {
        $username = htmlspecialchars($input[1]);
        
        if (!$username) {
             return [false, "Please enter a username."];
        }
        $check = $this->_db->query('SELECT username FROM users WHERE username = ?', ['username' => $username])->results();
        if (!$check) {
            if (strlen($username) >= 3 && strlen($username) <= 32) {
                if (preg_match('/^[\w]{3,32}$/i', $username)) {
                    return [true];
                } else {
                    return [false, "Usernames can only contain uppercase, lowercase and digits."];
                }
            } else {
                return [false, "Username must be between 3 and 32 characters long."];
            }
        } else {
            return [false, "User $username already exists."];
        }
    }

    public function password($input) {
        $password = htmlspecialchars($input[1]);
        if (!$password) {
            return [false, "Please enter a password."];
        }
        if (strlen($password) >= 6 && strlen($password) <= 32) {
            if (preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $password)) {
                return [true];
            } else {
                
                return [false, 'Passwords should at least contain:<br>1 Lowercase<br>1 Uppercase<br>1 Number and<br>1 Special character.'];
            }
        } else {
            return [false, "Passwords must be between 6 and 32 characters long."];
        } 
    }

    public function email($input) {
        $email = htmlspecialchars($input[1]);

        if (!$email) {
             return [false, "Please enter an email."];
        }
        $check = $this->_db->query('SELECT email FROM users WHERE email = ?', ['email' => $email])->results();
        if (!$check) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return [true];
            } else {
                return [false, "Please enter a valid email address."];
            }
        } else {
            return [false, "Email: $email is already in use."];
        }
    }

    public function match($input) {
        $check = htmlspecialchars($input[1]);
        $match = htmlspecialchars($input[2]);
        if ($check == $match) {
            return [true];
        } else {
            return [false, "Passwords do not match."];
        }
    }
}