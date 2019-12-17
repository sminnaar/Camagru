<?php

if (isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!Database::query('SELECT username FROM users WHERE username=:username', array(':username' => $username))) {
        if (!Database::query('SELECT email FROM users WHERE email=:email', array(':email' => $email))) {
            if (strlen($username) >= 3 && strlen($username) <= 32) {
                if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
                    if (strlen($password >= 6 && strlen($password) <= 32)) {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            Database::query('INSERT INTO users VALUES (id, :username, :email, :password)', array(':username' => $username, ':email' => $email, ':password' => password_hash($password, PASSWORD_BCRYPT))); 
                            echo "User added";
                        } else {
                            echo "Please enter a valid email address.";
                        }
                    } else {
                        echo "Passwords must be between 6 and 32 characters long";
                    }
                } else {
                        echo "Usernames can only contain uppercase, lowercase and digits.";
                }
            } else {
                echo "Username must be between 3 and 32 characters long.";
            }
        } else {
            echo "Email $email exists";
        }
    } else {
        echo "User $username exists";
    }
}
?>

<h1>Register</h1>
<form action="" method="post">
    <input type="text" name="username" value="" placeholder="Username"><p />
    <input type="password" name="password" value="" placeholder="Password"><p />
    <input type="email" name="email" value="" placeholder="x@x.x"><p />
    <input type="submit" name="register" value="Register">
</form>