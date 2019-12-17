(function () {

    let loaded = 0;
    let count = 0;
    
    function load() {
        
        let resData = [];

        function next() {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = [];
                    resData = res.target.response;
                    if (resData) {
                        
                        gallery.innerHTML = resData;
                        var like = document.getElementById("likes");
                        likes.innerHTML = '';
                        likes.innerHTML = like;
                        var comment = document.getElementById("comments");
                        comments.innerHTML = '';
                        comments.innerHTML = comment;
                        gallery.innerHTML = '';
                        gallery.innerHTML = resData;
                        var counter = document.getElementById("counter");
                        count = Number(counter.innerHTML);
    
                        let posts = Array.from(document.getElementsByClassName('post'));
                        for (let post of posts) {
                            let postId = post.id;
                            let likeButton = post.querySelector('input');
                            likeButton.onclick = function() {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function(res) {
                                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                        resData = [];
                                        resData = res.target.response;
                                        if (resData) {
                                            likeButton.value = resData;
                                        } else {
                                            likeButton.value = 'FAILED NEXT';
                                            window.location.assign('gallery');
                                        }
                                    }
                                }
                                xhr.open('POST', 'gallery/like');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                let params = 'postId=' + postId;
                                xhr.send(params);
                            };
                        }

                        let comm = Array.from(document.getElementsByClassName('post'));
                        for (let com of comm) {
                            let postId = com.id;
                            let commentButton = com.querySelector('#commentbutton');
                            let log = document.getElementById('log' + postId);
                            commentButton.onclick = function() {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function(res) {
                                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                        resData = [];
                                        resData = res.target.response;
                                        if (resData) {
                                            log.innerHTML = "";
                                            log.innerHTML = resData;
                                            log.style.display = "initial";
                                        } else {
                                          //  window.location.assign('gallery');
                                        }
                                    }
                                }
                                var text = document.getElementById('c' + postId).value;
                                xhr.open('POST', 'gallery/comment');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                let params = 'postId=' + postId + '&text=' + text;
                                xhr.send(params);
                            };
                        }
    
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
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function(res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = [];
                    resData = res.target.response;
                    if (resData) {
                        gallery.innerHTML = resData;
                        var like = document.getElementById("likes");
                        likes.innerHTML = '';
                        likes.innerHTML = like;
                        var comment = document.getElementById("comments");
                        comments.innerHTML = '';
                        comments.innerHTML = comment;
                        gallery.innerHTML = '';
                        gallery.innerHTML = resData;
                        var counter = document.getElementById("counter");
                        count = Number(counter.innerHTML);
    
                        let posts = Array.from(document.getElementsByClassName('post'));
                        for (let post of posts) {
                            let postId = post.id;
                            let likeButton = post.querySelector('input');
                            likeButton.onclick = function() {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function(res) {
                                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                        resData = [];
                                        resData = res.target.response;
                                        if (resData) {
                                            likeButton.value = resData;
                                        } else {
                                            likeButton.value = 'FAILED PREV';
                                            //window.location.assign('gallery');
                                        }
                                    }
                                }
                                xhr.open('POST', 'gallery/like');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                let params = 'postId=' + postId;
                                xhr.send(params);
                            };
                        }

                        let comm = Array.from(document.getElementsByClassName('post'));
                        for (let com of comm) {
                            let postId = com.id;
                            let commentButton = com.querySelector('#commentbutton');
                            let log = document.getElementById('log' + postId);

                            commentButton.onclick = function() {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function(res) {
                                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                        resData = [];
                                        resData = res.target.response;
                                        if (resData) {
                                            log.innerHTML = "";
                                            log.innerHTML = resData;
                                            log.style.display = "initial";

                                        } else {
                                            window.location.assign('gallery');
                                        }
                                    }
                                }
                                var text = document.getElementById('c' + postId).value;
                                xhr.open('POST', 'gallery/comment');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                let params = 'postId=' + postId + '&text=' + text;
                                xhr.send(params);
                            };
                        }

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
        const likes = document.getElementById("likes");
        const comments = document.getElementById("comments");
        
        let prevbutton = document.getElementById("prev");
        let nextbutton = document.getElementById("next");
     
        prevbutton.onclick = prev;
        nextbutton.onclick = next;
        
        if (!loaded) {
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function (res) {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    resData = [];
                    resData = res.target.response;
                    if (resData) {
                        gallery.innerHTML = resData;
                        var like = document.getElementById("likes");
                        likes.innerHTML = like;
                        var comment = document.getElementById("comments");
                        comments.innerHTML = comment;
                        gallery.innerHTML = resData;
                        var counter = document.getElementById("counter");
                        count = Number(counter.innerHTML);
                        
                        loaded = 1;
    
                        let posts = Array.from(document.getElementsByClassName('post'));
                        for (let post of posts) {
                            let postId = post.id;
                            let likeButton = post.querySelector('input');
                            likeButton.onclick = function() {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function(res) {
                                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                        resData = [];
                                        resData = res.target.response;
                                        if (resData) {
                                            likeButton.value = resData;
                                        } else {
                                            window.location.assign('gallery');
                                        }
                                    }
                                }
                                xhr.open('POST', 'gallery/like');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                let params = 'postId=' + postId;
                                xhr.send(params);
                            };

                        }

                        let comm = Array.from(document.getElementsByClassName('post'));
                        for (let com of comm) {
                            let postId = com.id;
                            let commentButton = com.querySelector('#commentbutton');
                            let log = document.getElementById('log' + postId);
                            commentButton.onclick = function() {
                                const xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function(res) {
                                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                                        resData = [];
                                        resData = res.target.response;
                                        if (resData) {
                                            log.innerHTML = "";
                                            log.innerHTML = resData;
                                            log.style.display = "initial";


                                        } else {
                                            window.location.assign('gallery');
                                        }
                                    }
                                }
                                var text = document.getElementById('c' + postId).value;
                                xhr.open('POST', 'gallery/comment');
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                                let params = 'postId=' + postId + '&text=' + text;
                                xhr.send(params);
                            };
                        }

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