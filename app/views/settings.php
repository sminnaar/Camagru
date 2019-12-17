<?php $this->setSiteTitle('Settings') ?>

<?php $this->start('body'); ?>

<div class="center black">
<p>Change Username</p>
    <input class="input center" id="username" type="text" name="username" value="" placeholder="New Username"><p></p>
    <input class="button text-black grey" id="change_username" type="submit" name="change_username" value="Update"><p></p>
    <p id="name_errors" style="display: none; color: red;"></p>
    <br />

    <p>Update First and Last names</p>
    <input class="input center" id="fname" type="text" name="fname" value="" placeholder="First Name" autofocus><p></p>
    <input class="input center" id="lname" type="text" name="lname" value="" placeholder="Last Name"><p></p>
    <input class="button text-black grey" id="update" type="submit" name="update" value="Update" /><p></p>
    <p id="n_errors" style="display: none; color: red;"></p>
    <br />

    <p>Upload Profile Photo</p>
    <form action="settings/upload" method="POST" enctype="multipart/form-data">
        <input id="image" class="input center" type="file" name="image"><p></p>
        <input id="upload" class="button text-black grey" type="submit" value="Upload"/><p></p>
        <p id="u_errors" style="display: none; color: red;"></p>
    </form>

    <br />

    <p>Change Password</p>
    <input class="input center" id="pass" type="password" name="pass_update" value="" placeholder="Enter New Password"><p></p>
    <input class="input center" id="vpass" type="password" name="vpass_update" value="" placeholder="Confirm New Password"><p></p>
    <input class="button text-black grey" id="change_p" type="submit" name="change_password" value="Change Password" ><p></p>
    <p id="errors" style="display: none; color: red;"></p>

    <br />

    <p>Update Email</p>
    <input class="input center" id="email" type="email" name="update_email" value="" placeholder="New Email"><p></p>
    <input class="button text-black grey" id="change_e" type="submit" name="change_email" value="Change Email"><p></p>
    <p id="e_errors" style="display: none; color: red;"></p>
    <br />

    <p>Update Preferences</p>
    <form action="settings/notifyon">
    <input class="button text-black grey" id="submit_on" type="submit" name="notify0" value="Notifications on"><p></p>
    </form>
    <form action="settings/notifyoff">
    <input class="button text-black grey" id="submit_off" type="submit" name="notify1" value="Notifications off"><p></p>
    </form>
</div>

<script src="./js/settings.js"></script>
<script>
    document.getElementById("upload").addEventListener("click", function(event){
    event.preventDefault()
    });
</script>

<?php $this->end('body'); ?>
