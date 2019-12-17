(function () {
    function startup() {
        // Username
        const name_errors = document.getElementById("name_errors");
        const inputUsername = document.getElementById("username");
        let userbutton = document.getElementById("change_username");

        // Password Errors
        const errors = document.getElementById("errors");
        const inputPassword = document.getElementById("pass");
        const inputVPassword = document.getElementById("vpass");
        let passbutton = document.getElementById("change_p");
       
        // Email Errors
        const e_errors = document.getElementById("e_errors");
        const inputEmail = document.getElementById("email");
        let emailbutton = document.getElementById("change_e");

        // Name Errors
        const n_errors = document.getElementById("n_errors");
        const inputFname = document.getElementById("fname");
        const inputLname = document.getElementById("lname");
        let namebutton = document.getElementById("update");

        // Profile picture
        const u_errors = document.getElementById("u_errors");
        let uploadbutton = document.getElementById("upload");

        inputUsername.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onUser();
            } 
        });

        inputVPassword.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onChange();
            } 
        });

        inputEmail.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onEmail();
            } 
        });

        inputLname.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onName();
            } 
        });

        passbutton.onclick = onChange;
        emailbutton.onclick = onEmail;
        namebutton.onclick = onName;
        uploadbutton.onclick = onUpload;
        userbutton.onclick = onUser;

        function onUser() {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;

                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        name_errors.innerHTML = resHTML;
                        name_errors.style.display = "initial";
                    } else {
                        name_errors.style.display = "initial";
                    }
                }
            }
            xhr.open('POST', 'settings/username');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = '&username=' + inputUsername.value;
            xhr.send(params);
        }

        function onChange() {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;
                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        errors.innerHTML = resHTML;
                        errors.style.display = "initial";
                    } else {
                        errors.innerHTML = "Password Changed. Redirecting...";
                        errors.style.display = "initial";
                        setTimeout(function() {
                            window.location.assign('login');
                        }, 1000);
                    }
                }
            }
            xhr.open('POST', 'settings/pass');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = '&password=' + inputPassword.value
            + '&vpassword=' + inputVPassword.value;
            xhr.send(params);
        }

        function onEmail() {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;

                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        e_errors.innerHTML = resHTML;
                        e_errors.style.display = "initial";
                    } else {
                        e_errors.innerHTML = 'Updated. Please check your email to verify. Redirecting in 3 seconds.';
                        e_errors.style.display = "initial";
                        setTimeout(function() {
                            window.location.assign('login');
                        }, 3000);
                    }
                }
            }
            xhr.open('POST', 'settings/update_email');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = '&email=' + inputEmail.value;
            xhr.send(params);
        }

        function onName() {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;

                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        n_errors.innerHTML = resHTML;
                        n_errors.style.display = "initial";
                    } else {
                        n_errors.innerHTML = 'Updated.';
                        n_errors.style.display = "initial";
                    }
                }
            }
            xhr.open('POST', 'settings/names');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = '&fname=' + inputFname.value
            + '&lname=' + inputLname.value;
            xhr.send(params);
        }

        function onUpload() {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;

                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        u_errors.innerHTML = resHTML;
                        u_errors.style.display = "initial";
                    } else {
                        //window.location.assign('settings');
                        u_errors.innerHTML = 'Uploaded.';
                        u_errors.style.display = "initial";
                    }
                }
            }

            const file = document.getElementById('image');
            const formData = new FormData();

            formData.append('image', file.files[0]);
            
            xhr.open('POST', 'settings/upload');
            xhr.send(formData);
        }

    } 

    window.addEventListener('load', startup, false);
})();