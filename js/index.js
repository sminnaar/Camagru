(function () {

    let loaded = 0;
    let count = 0;
    
    function load() {
        
        function next() {
            resData = [];
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;
                    if (resData) {
                        gallery.innerHTML = resData;
    
                        var like = document.getElementById("likes");
                        // likes.innerHTML = '';
                        // likes.innerHTML = like;
                        
                        var comment = document.getElementById("comments");
                        // comments.innerHTML = '';
                        // comments.innerHTML = comment;
    
                        gallery.innerHTML = '';
                        gallery.innerHTML = resData;
    
                        var counter = document.getElementById("counter");
                        count = Number(counter.innerHTML);
    
    
                    } else {
                        window.location.assign('gallery');
                    }
                }
            }
            xhr.open('POST', 'gallery/display');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'next=' + 1
            + '&count=' + count;
            xhr.send(params);
        }
        
        function prev() {
            resData = [];
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;
                    if (resData) {
                        gallery.innerHTML = resData;
    
                        var like = document.getElementById("likes");
                        // likes.innerHTML = '';
                        // likes.innerHTML = like;
                        
                        var comment = document.getElementById("comments");
                        // comments.innerHTML = '';
                        // comments.innerHTML = comment;
    
                        gallery.innerHTML = '';
                        gallery.innerHTML = resData;
    
                        var counter = document.getElementById("counter");
                        count = Number(counter.innerHTML);
                    } else {
                        window.location.assign('gallery');
                    }
                }
            }
            xhr.open('POST', 'gallery/display');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'prev=' + 1
            + '&count=' + count;
            xhr.send(params);
        }
        
        const gallery = document.getElementById("gallery");
        
        let prevbutton = document.getElementById("prev");
        let nextbutton = document.getElementById("next");

        prevbutton.onclick = prev;
        nextbutton.onclick = next;
        
        if (!loaded) {
            resData = [];
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function (res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = res.target.response;
                    if (resData) {
                        gallery.innerHTML = resData;
                        
                        var like = document.getElementById("likes");

                        var comment = document.getElementById("comments");
                        
                        gallery.innerHTML = resData;

                        var counter = document.getElementById("counter");
                        count = Number(counter.innerHTML);
                        
                        loaded = 1;
    
                    } else {
                        window.location.assign('gallery');
                    }
                }
            }
            xhr.open('POST', 'gallery/setup');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            let params = 'start=' + 1
            + '&count=' + count;
            xhr.send(params);
        }
    }

    window.addEventListener('load', load, false);
})();