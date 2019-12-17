<?php

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (Database::query('SELECT username FROM users WHERE username=:username', array(':username' => $username))) {
        if (password_verify($password, Database::query('SELECT password FROM users WHERE username=:username', array(':username' => $username))[0]['password'])) {

            $cstrong = True;
            $token = bin2hex(openssl_random_pseudo_bytes(65, $cstrong));

            // echo "$token";
            $user_id = Database::query('SELECT id FROM users WHERE username=:username', array(':username' => $username))[0]['id'];
            Database::query('INSERT INTO tokens VALUES (id, :token, :user)', array(':token' => sha1($token), ':user' => $user_id)); 

            // echo "Logged in!";

            setcookie("SNID", $token, time() + 60 * 60 * 24, '/', NULL, NULL, TRUE);

        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User $username not registered";
    }
}

        // if (strlen($username) >= 3 && strlen($username) <= 32) {
        //     if (preg_match('/[a-zA-Z0-9_]+/', $username)) {
        //         if (strlen($password >= 6 && strlen($password) <= 32)) {
        //             //echo "User added";
        //         } else {
        //             echo "Passwords must be between 6 and 32 characters long";
        //         }
        //     } else {
        //             echo "Usernames can only contain uppercase, lowercase and digits.";
        //     }
        // } else {
        //     echo "Username must be between 3 and 32 characters long.";
        // }