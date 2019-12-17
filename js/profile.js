(function () {
    
    function load() {

        let deletebutton = document.getElementById("deletebutton");
        
        deletebutton.onclick = del;

        function del() {
            var image = document.getElementById("delete");
            var errors = document.getElementById("errors");
        
            resData = [];
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
                        errors.innerHTML = "Deleted. Reloading.";
                        errors.style.display = "initial";
                        setTimeout(function() {
                            window.location.assign('profile');
                        }, 800);
                    }
                }
            }
            xhr.open('POST', 'profile/delete');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'delete=' + 1
            + '&image=' + image.innerHTML;
            xhr.send(params);
        }
    
    }

    window.addEventListener('load', load, false);
})();