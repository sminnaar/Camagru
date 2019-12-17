<?php $this->setSiteTitle('Login') ?>

<?php $this->start('body'); ?>

<script src="./js/login.js"></script>

	<div class="center">

		<h1 id="header">Login</h1>
		
		<input class="input center" id="username" type="text" name="username" value="" placeholder="Username" autofocus><p></p>
		<input class="input center" id="password" type="password" name="password" value="" placeholder="Password"><p></p>
		<input class="button text-black grey" id="loginbutton" type="button" name="login" value="Login" /><p></p>
		<p id="errors" style="display: none; color: red;"></p>
		
		<br />
		
		<p>Can't remember your password?</p>

		<input class="input center" id="email" type="email" name='reset_pass' placeholder='Enter email address'><p></p>
		<input class="button text-black grey" type="button" id="forgotbutton" name="forgot" value="Reset"><p></p>
		<p id="errors2" style="display: none; color: red;"></p>

		<p>Or</p>
		<a href="home"><input class="button text-black grey" id="home" type="button" name="home" value="Back to Home"></a><p></p>
	</div>
<?php $this->end(); ?>
