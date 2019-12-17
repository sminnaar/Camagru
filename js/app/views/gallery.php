<?php $this->setSiteTitle('Gallery') ?>

<?php $this->start('head'); ?>

    <style>
    * {box-sizing: border-box}
    body {font-family: Verdana, sans-serif; margin:0}
    .mySlides {display: none}
    img {vertical-align: middle;}

    /* Slideshow container */
    .slideshow-container {
    max-width: 1000px;
    position: relative;
    margin: auto;
    }

    /* Next & previous buttons */
    .prev, .next {
    cursor: pointer;
    /* position: absolute; */
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    color: white;
    font-weight: bold;
    font-size: 18px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    }

    /* Position the "next button" to the right */
    .next {
    right: 0;
    border-radius: 3px 0 0 3px;
    }

    /* On hover, add a black background color with a little bit see-through */
    .prev:hover, .next:hover {
    background-color: rgba(0,0,0,0.8);
    }

    /* Caption text */
    .text {
    color: #f2f2f2;
    font-size: 15px;
    padding: 8px 12px;
    position: absolute;
    bottom: 8px;
    width: 100%;
    text-align: center;
    }

    /* Number text (1/3 etc) */
    .numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
    }

    /* The dots/bullets/indicators */
    .dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
    }

    .active, .dot:hover {
    background-color: #717171;
    }

    /* Fading animation */
    .fade {
    -webkit-animation-name: fade;
    -webkit-animation-duration: 1.5s;
    animation-name: fade;
    animation-duration: 1.5s;
    }

    @-webkit-keyframes fade {
    from {opacity: .4} 
    to {opacity: 1}
    }

    @keyframes fade {
    from {opacity: .4} 
    to {opacity: 1}
    }

    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
    .prev, .next,.text {font-size: 11px}
    }
    </style>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

    <script src="./js/gallery.js"></script>

    <div class='center black padding-32'>
        <div id="buttons" class='center black' style="display: inline;">
            <input style='margin-right: 20px' class="button text-black grey" id="prev" name="prev" type="submit" value="Previous Page"/>
            <input style='margin-left: 20px' class="button text-black grey" id="next" name="next" type="submit" value="Next Page"/>
        </div>
        <br />
        <br />
        <div id="gallery" class='center black'>
            <div id="likes" class='center black'></div>
            <div id="comments" class='center black'>
            <input class='input center' id='commentin' name='next' type='text' placeholder='Add Comment'/><p></p>
            <input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>
            <p style='color: red;' id='log' name='count'></p>
            <input style='display: none' class='button text-black grey' id='unlikebutton' name='next' type='submit' value='Unlike'/>
            <input style='display: none' class='button text-black grey' id='likebutton' name='next' type='submit' value='like'/>
            </div>
            <p style='display: none; color: black;' id='counter' name='count'></p>
        </div>
    </div>

    <script>

        let next = 1;
        let prev = 0;

        function nextSlide(id) {
            var slideshow = document.getElementsByClassName('slideshow-container');
            var comments = Array.from(document.getElementsByClassName('comment'));
            var len = 0;
            var all = new Array();
            for (let comment of comments) {
                let postId = comment.id;
                if (postId == id) {
                    len++;
                    all.push(comment);
                }
            }
            for (let i = 0; i < comments.length; i++) {
                if (comments[i]) {
                    if (comments[i].id == id && comments[i].style) {
                        comments[i].style.display = 'none';  
                    }
                }
            }
            if (next >= len) { next = 0; }    
            if (all[next]) {
                if (all[next].style) {
                    all[next].style.display = 'block'; 
                    prev = next - 1;
                    next++;
                } 
            }
        }

        function prevSlide(id) {
            var slideshow = document.getElementsByClassName('slideshow-container');
            var comments = Array.from(document.getElementsByClassName('comment'));
            var len = 0;
            var all = new Array();
            for (let comment of comments) {
                let postId = comment.id;
                if (postId == id) {
                    len++;
                    all.push(comment);
                }
            }
            for (let i = 0; i < comments.length; i++) {
                if (comments[i]) {
                    if (comments[i].id == id && comments[i].style) {
                        comments[i].style.display = 'none';  
                    }
                }
            }
            if (prev <= 0) { prev = len - 1; }
            if (all[prev]) {
                if (all[prev].style) {
                    all[prev].style.display = 'block'; 
                    next = prev + 1;
                    prev--;
                } 
            }
        }

        function allSlides(id) {

            var slideshow = document.getElementsByClassName('slideshow-container');
            var posts = Array.from(document.getElementsByClassName('post'));
            var comments = Array.from(document.getElementsByClassName('comment'));
            var len = 0;

            for (let comment of comments) {
                let postId = comment.id;
                if (postId == id) {
                    len++;
                }
            }

            for (let i = 0; i < comments.length; i++) {
                if (comments[i]) {
                    if (comments[i].id == id && comments[i].style) {
                        comments[i].style.display = 'block';  
                    }
                }
            }
            next = 0;
            prev = -1;
        }
    </script>

<?php $this->end(); ?>