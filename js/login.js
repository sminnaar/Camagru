(function () {
    function startup() {
        const errors = document.getElementById("errors");
        const errors2 = document.getElementById("errors2");
        
        const inputUsername = document.getElementById("username");
        const inputPassword = document.getElementById("password");
        const inputEmail = document.getElementById("email");
        
        let submitbutton = document.getElementById("loginbutton");
        let forgotbutton = document.getElementById("forgotbutton");

        inputPassword.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onLogin();
            } 
        });

        inputEmail.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onForgot();
            } 
        });


        submitbutton.onclick = onLogin;
        forgotbutton.onclick = onForgot;

        function onLogin() {
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
                        window.location.assign('profile');
                    }
                }
            }
            xhr.open('POST', 'login/login');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'username=' + inputUsername.value + '&password=' + inputPassword.value;
            xhr.send(params);
        }
    
        
        function onForgot() {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;
                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        errors2.innerHTML = resHTML;
                        errors2.style.display = "initial";
                    } else {
                        window.location.assign('login');
                    }
                }
            }
            xhr.open('POST', 'login/forgot');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'email=' + inputEmail.value;
            xhr.send(params);
        }

        
    }


    window.addEventListener('load', startup, false);
})();