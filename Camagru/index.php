<?php

//echo $_GET['url'];
require_once('./classes/Rout.php');

function __autoload($class_name) {
    if (file_exists('./classes/'.$class_name.'.php')) {
        require_once './classes/'.$class_name.'.php';
    }
    else if (file_exists('./Controllers/'.$class_name.'.php')) {
        require_once './Controllers/'.$class_name.'.php';
    }
}

?>

<!DOCTYPE HTML>
<html lan="en">
<head>
<title>Camagru | Home</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style/w3.css">
<meta name="discription" content="Camagru - Instagram clone"/>
</head>
<body>
    <div class="top">
        <div class="bar-item button padding-large hide-meduim hide-large right">
        <a href="#" class="bar-item button padding-large">HOME</a>
        <a class="bar-item button padding-large">|</a>
        <a href="#" class="bar-item button padding-large">CAMAGRU</a>
        <a href="#" class="bar-item button padding-large">DISCOVER</a>
        <a href="#" class="bar-item button padding-large">LIKES</a>
        <a href="#" class="bar-item button padding-large">PEOPLE</a>
    </div>
</div>
<h1>Welcome to the Instagru</h1>
<h2>Don't have an account?</h2>
    <form action="register.php" method="post" class="">
        <input type="text" name="username" value="" placeholder="User ..."><p />
        <input type="email" name="email" value="" placeholder="email@host.com ..."><p />
        <input type="password" name="passwd" value="" placeholder="Password ..."><p />
        <input type="password" name="confirm_passwd" value="" placeholder="Confirm Password ..."><p />
<input type="submit" name="register" value="Register">
</form>
</body>
</html>
