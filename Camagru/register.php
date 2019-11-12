<?php
include('./classes/DB.php');
include_once('./configs/tables.php');

//$conn = connect();

if (isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwd = $_POST['passwd'];
    // $confirm_passwd = $_POST['confirm_passwd'];

    DB::query('INSERT INTO users VALUES (\'\', :username, :email, :passwd)', array(':username'=>$username,':email'=>$email, ':passwd'=>$passwd));
    echo "Success";
}
?>


<h1>Register</h1>
<form action="register.php" method="post">
<input type="text" name="username" value="" placeholder="User ..."><p />
<input type="email" name="email" value="" placeholder="email@host.com ..."><p />
<input type="password" name="passwd" value="" placeholder="Password ..."><p />
<!-- <input type="password" name="confirm_passwd" value="" placeholder="Confirm Password ..."><p /> -->
<input type="submit" name="register" value="Register">
</form>
