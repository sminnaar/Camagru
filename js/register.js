(function () {
    function startup() {
        const errors = document.getElementById("errors");
        const inputUsername = document.getElementById("username");
        const inputPassword = document.getElementById("password");
        const inputVPassword = document.getElementById("vpassword");
        const inputEmail = document.getElementById("email");
        
        let submitbutton = document.getElementById("registerbutton");

        inputEmail.addEventListener("keyup", function (e) {
            if (e.keyCode === 13) {
                onRegister();
            } 
        });
    
        submitbutton.onclick = onRegister;

        function onRegister() {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;

                    if (resData) {
                        resErrors = resData.split(',');
                        resHTML = resErrors.map((error) => {return error + '<br />'}).join('');
                        errors.innerHTML = resHTML;
                        errors.style.display = "initial";
                    }
                }
            }
            xhr.open('POST', 'register/register');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'username=' + inputUsername.value
            + '&password=' + inputPassword.value
            + '&vpassword=' + inputVPassword.value
            + '&email=' + inputEmail.value;
            xhr.send(params);
        }
    }

    window.addEventListener('load', startup, false);
})();