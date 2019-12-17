<?php $this->setSiteTitle('Register') ?>

<?php $this->start('body'); ?>

	<script src="./js/register.js"></script>

	<div class="center">
		
		<h1>Register</h1>

		<input class="input center" id="username" type="text" placeholder="Username" autofocus><p></p>
		<input class="input center" id="password" type="password" placeholder="Password"><p></p>
		<input class="input center" id="vpassword" type="password" placeholder="Confirm Password"><p></p>
		<input class="input center" id="email" type="email" placeholder="example@example.com"><p></p>
		<input class="button text-black grey" id="registerbutton" type="button" name="register" value="Register"><p></p>

		<p id="errors" style="display: none; color: red;"></p>

		<p>Or</p>
		<a href="home"><input class="button text-black grey" id="home" type="button" name="home" value="Back to Home"></a><p></p>
	</div>

<?php $this->end(); ?>
