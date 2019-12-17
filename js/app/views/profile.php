<?php $this->setSiteTitle('Profile') ?>


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
    position: absolute;
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

	<script src="./js/profile.js"></script>
    <div class="center">
        <?php
            $_db = DB::getInstance();
            if (isset($_SESSION['user'])) {
                $user = $_db->query('SELECT username FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results();
                $photo = $_db->query('SELECT photo FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->photo;
                if ($user) {
                    $username = $user[0]->username;
                    echo "<h2 class='text-light-grey'>Welcome, $username!</h2>";
                } else {
                    unset($_SESSION['user']);
                    Router::redirect('');
                }
                if ($photo) {
                    echo "<img style='width: 10%;border-radius: 50%' src='$photo' alt='Profile photo'>";
                } else {
                    echo "<img style='width: 10%;' src='img/profile/def4.jpg' alt='Profile photo'>";
                }
            }
        ?>
    </div>

    <br>
    
    <h2 class='text-light-grey center'>Your Photos</h2>

    <br>

    <div class="slideshow-container">
            <?php
                $id = $_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results()[0]->id;
                $photos = $_db->query('SELECT img FROM posts WHERE user = ?', ['user'=>$id])->results();
                if ($photos) {
                    echo "<a class='prev' onclick='plusSlides(-1)'>&#10094;</a>";
                    foreach ($photos as $photo) {
                        echo "<div class='roll fade center'>";
                        echo "<img src=$photo->img alt='Uploads' style='width:30%'><p></p>";
                        echo "<input class='button text-black grey' id='deletebutton' type='button' name='comment' value='Delete'><p></p>";
                        echo "<p style='display: none; color: black;' id='delete' name='count'>" . $photo->img . "</p>";
                        echo "</div>";
                    }
                    echo "<a class='next' onclick='plusSlides(1)'>&#10095;</a>";
                    echo "<script>
                    var slideIndex = 1;
                    showSlides(slideIndex);
                    function plusSlides(n) {
                        showSlides(slideIndex += n);
                    }
                    function currentSlide(n) {
                        showSlides(slideIndex = n);
                    }
                    function showSlides(n) {
                        var i;
                        var slides = document.getElementsByClassName('roll');
                        if (n > slides.length) {slideIndex = 1}    
                        if (n < 1) {slideIndex = slides.length}
                        for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = 'none';  
                        }
                        slides[slideIndex-1].style.display = 'block';  
                    }
                    </script>";
                } else {
                    echo "<div class='center'>";
                    echo "<p>No photos</p>";
                    echo "<input class='button text-black grey' id='deletebutton' type='button' name='comment' style='display: none; value='Delete'><p></p>";
                    echo "</div>";
                }
            ?>
    </div>
    <div class="center">
        <p class='center' id='errors' style='display: none; color: red;'></p>
    </div>

    <br>

<?php $this->end(); ?>
