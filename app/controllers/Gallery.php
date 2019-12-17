<?php

class Gallery extends Controller {
    
    public $_db;
    public $images;
    public $comments;
    public $likes;
    public $n = 0;
    public $start = [];
    public $next = [];
    public $prev = [];

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
        $this->_db = DB::getInstance();
    }

    public function setup() {
        $images = [];
        $comments = [];
        $liked = [];
        $this->images = $this->_db->query('SELECT * FROM posts ORDER BY time desc')->results();
        $this->comments = $this->_db->query('SELECT * FROM comments')->results();
        $this->likes = $this->_db->query('SELECT * FROM likes')->results();
        if (isset($_SESSION['user'])) {
            $uid = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results();
            if ($uid) {
                $uid = $uid[0]->id;
            }
        }
        foreach ($this->images as $img) {
            foreach ($this->comments as $comment) {
                if ($comment->post == $img->id) {
                    $comments[] = $comment->text;
                }
            }
            foreach ($this->likes as $like) {
                if (isset($uid) && $like->post == $img->id && $like->user == $uid) {
                    $liked[$img->id] = $like->post;
                }
            }
            $images[] = [
                'id' => $img->id,
                'uid' => $img->user,
                'image' => $img->img,
                'likes' => $img->likes,
                'liked' => $liked,
                'comments' => $comments
            ];
            $comments = [];
            $liked = [];
        }
        $this->n = count($images);
        $i = $_POST['count'];
        $count = 5;
        if (isset($_POST['start']) && $_POST['start']) {
            while ($i < $this->n - 1 && $count) {
            $start = 1;
                echo "<div class='center post' id='" . $images[$i]['id'] . "'>";
                echo "<div id='imagess'>";
                    echo "<img id='" . $images[$i]['id'] . "' src='" . $images[$i]['image'] . "' style='width: 25%'><p></p>";
                echo "</div>";
                echo "<div id='likes'>";
                if (isset($_SESSION['user'])) {
                    if (array_key_exists($images[$i]['id'], $images[$i]['liked'])) {
                        echo "<input class='button text-black grey' id='unlikebutton' type='submit' value='Unlike'/>";
                    } else {
                        echo "<input class='button text-black grey' id='likebutton' type='submit' value='Like'/>";
                    }
                }
                echo "<p> Likes: " . $images[$i]['likes'] . "</p>";
                echo "</div>";
                if ($images[$i]['comments']) {
                    echo "<div style='display: inline-flex'>";
                        echo "<a class='prev' onclick='prevSlide(" . $images[$i]['id']. ")'>&#10094; Prev</a>";
                    echo "</div>";
                    echo "<div id='comments' class='slideshow-container' style='display: inline-flex'>";
                    foreach ($images[$i]['comments'] as $text) {
                        if ($start) {
                            echo "<div id='" . $images[$i]['id'] . "' class='comment fade center' style='display: block; border: 1px solid grey; margin: 20px; padding-left: 10px; padding-right: 10px'>";
                                echo "<p>" . $text . " </p>";
                            echo "</div>";
                        } else {
                            echo "<div id='" . $images[$i]['id'] . "'  class='comment fade center' style='display: none; border: 1px solid grey; margin: 20px; padding-left: 10px; padding-right: 10px'>";
                                echo "<p>" . $text . " </p>";
                            echo "</div>";
                        } 
                        $start = 0;
                    }
                    echo "</div>";
                    echo "<div style='display: inline-flex'>";
                        echo "<a class='next' onclick='nextSlide(" . $images[$i]['id']. ")'>Next &#10095;</a>";
                    echo "</div>";
                    echo "<div class='padding-16'>";
                        echo "<a class='prev' onclick='allSlides(" . $images[$i]['id']. ")'> All Comments </a>";
                    echo "</div>";

                    echo "<div class='comms'>";
                    if (isset($_SESSION['user'])) {
                        echo "<input class='input center' id='" . "c" . $images[$i]['id'] . "' name='next' type='text' placeholder='Add Comment'/><p></p>";
                        echo "<input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>";
                        echo "<p style='color: red;' id='log" . $images[$i]['id'] . "' name='count'></p>";
                    }
                    echo "</div>";

                } else {
                    echo "<div class='center comms'>";
                    echo "<p> No comments</p>";
                    if (isset($_SESSION['user'])) {
                        echo "<input class='input center' id='" . "c" . $images[$i]['id'] . "' name='next' type='text' placeholder='Add Comment'/><p></p>";
                        echo "<input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>";
                        echo "<p style='color: red;' id='log" . $images[$i]['id'] . "' name='count'></p>";
                    }
                    echo "</div>";
                }
                $i++;
                $count--;
                echo "<hr>";
            }
            echo "<p style='display: none; color: black;' id='counter' name='count'>" . $i . "</p>";
            echo "<p style='color: red; display: none' id='log' name='count'></p>";

        } else {
            echo "<p>No photos</p>";
            echo "<p style='display: none; color: black;' id='counter' name='count'>" . 0 . "</p>";
        }
        unset($_POST['start']);
    } 

    public function like() {
        if (isset($_POST['postId']) && $_POST['postId']) {
            if (isset($_SESSION['user'])) {
                $uid = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results();
                if ($uid) {
                    $uid = $uid[0]->id;
                }
            }
            $id = $this->_db->query('SELECT * FROM likes WHERE user = ? AND post = ?', ['user'=>$uid, 'post'=>$_POST['postId']])->results();
            if ($id) {
                $id = $id[0]->id;
                $likes = $this->_db->query('SELECT likes FROM posts WHERE id = ?', ['id'=>$_POST['postId']])->results();
                if ($likes) {
                    $likes = $likes[0]->likes;
                    $likes -= 1;
                }
                $this->_db->delete('likes', $id);
                $this->_db->update('posts', $_POST['postId'], ['likes'=>$likes]);
                echo "Like";
            } else {
                $likes = $this->_db->query('SELECT likes FROM posts WHERE id = ?', ['id'=>$_POST['postId']])->results();
                if ($likes) {
                    $likes = $likes[0]->likes;
                    $likes += 1;
                }
                $fields = ['post'=>$_POST['postId'], 'user'=>$uid]; 
                $this->_db->insert('likes', $fields);
                $this->_db->update('posts', $_POST['postId'], ['likes'=>$likes]);
                echo "Unlike";
            }
        }
    }

    public function comment() {
        if (isset($_POST['postId']) && $_POST['postId']) {
            if (isset($_SESSION['user'])) {
                $uid = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results();
                if ($uid) {
                    $uid = $uid[0]->id;
                }
            }
            if (isset($_POST['text']) && $_POST['text']) {
                $comment = htmlspecialchars($_POST['text']);
                $fields = ['post'=>$_POST['postId'], 'user'=>$uid, 'text'=>$comment]; 
                $this->_db->insert('comments', $fields);
                    echo "Comment added successfully!";
               
                $owner = $this->_db->query('SELECT * FROM posts WHERE id = ?', ['id'=>$_POST['postId']])->results();
                if ($owner) {
                    $owner = $owner[0]->user;
                }
                $info = $this->_db->query('SELECT * FROM users WHERE id = ?', ['id'=>$owner])->results();
                if ($info) {
                    $email = $info[0]->email;
                    $notify = $info[0]->notify;
                }
                if ($notify) {
                    $subject = "Comment Notification | Camagru";
                    $headers = "Content-type:text/html;charset=UTF-8" . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= 'From:noreply@camagru.wtc.hi' . "\r\n";
                    $text = "Hello! <br><br>Someone has commented on your post.<br><br>Comment: " . $comment; 
                    mail($email, $subject, $text, $headers);
                    echo "Notified!";
                }
            }
        }
    }

    public function display() {
        $images = [];
        $comments = [];
        $liked = [];
        $this->images = $this->_db->query('SELECT * FROM posts ORDER BY time desc')->results();
        $this->comments = $this->_db->query('SELECT * FROM comments')->results();
        $this->likes = $this->_db->query('SELECT * FROM likes')->results();
        if (isset($_SESSION['user'])) {
            $uid = $this->_db->query('SELECT id FROM users WHERE token = ?', ['token'=>$_SESSION['user']])->results();
            if ($uid) {
                $uid = $uid[0]->id;
            }
        }
        foreach ($this->images as $img) {
            foreach ($this->comments as $comment) {
                if ($comment->post == $img->id) {
                    $comments[] = $comment->text;
                }
            }
            foreach ($this->likes as $like) {
                if (isset($uid) && $like->post == $img->id && $like->user == $uid) {
                    $liked[$img->id] = $like->post;
                }
            }
            $images[] = [
                'id' => $img->id,
                'uid' => $img->user,
                'image' => $img->img,
                'likes' => $img->likes,
                'liked' => $liked,
                'comments' => $comments
            ];
            $comments = [];
            $liked = [];
        }
        $this->n = count($images);
        $i = $_POST['count'];
        $count = 5;
        if (isset($_POST['next']) && $_POST['next']) {
            while ($i < $this->n && $count) {
            $start = 1;
                echo "<div class='center post' id='" . $images[$i]['id'] . "'>";
                echo "<div id='imagess'>";
                    echo "<img id='" . $images[$i]['id'] . "' src='" . $images[$i]['image'] . "' style='width: 25%'><p></p>";
                echo "</div>";
                echo "<div id='likes'>";
                if (isset($_SESSION['user'])) {
                    if (array_key_exists($images[$i]['id'], $images[$i]['liked'])) {
                        echo "<input class='button text-black grey' id='unlikebutton' type='submit' value='Unlike'/>";
                    } else {
                        echo "<input class='button text-black grey' id='likebutton' type='submit' value='Like'/>";
                    }
                }
                echo "<p> Likes: " . $images[$i]['likes'] . "</p>";
                echo "</div>";
                if ($images[$i]['comments']) {
                    echo "<div style='display: inline-flex'>";
                        echo "<a class='prev' onclick='prevSlide(" . $images[$i]['id']. ")'>&#10094; Prev</a>";
                    echo "</div>";
                    echo "<div id='comments' class='slideshow-container' style='display: inline-flex'>";
                    foreach ($images[$i]['comments'] as $text) {
                        if ($start) {
                            echo "<div id='" . $images[$i]['id'] . "' class='comment fade center' style='display: block; border: 1px solid grey; margin: 20px; padding-left: 10px; padding-right: 10px'>";
                                echo "<p>" . $text . " </p>";
                            echo "</div>";
                        } else {
                            echo "<div id='" . $images[$i]['id'] . "'  class='comment fade center' style='display: none; border: 1px solid grey; margin: 20px; padding-left: 10px; padding-right: 10px'>";
                                echo "<p>" . $text . " </p>";
                            echo "</div>";
                        } 
                        $start = 0;
                    }
                    echo "</div>";
                    echo "<div style='display: inline-flex'>";
                        echo "<a class='next' onclick='nextSlide(" . $images[$i]['id']. ")'>Next &#10095;</a>";
                    echo "</div>";
                    echo "<div class='padding-16'>";
                        echo "<a class='prev' onclick='allSlides(" . $images[$i]['id']. ")'> All Comments </a>";
                    echo "</div>";

                    echo "<div class='comms'>";
                    if (isset($_SESSION['user'])) {
                        echo "<input class='input center' id='" . "c" . $images[$i]['id'] . "' name='next' type='text' placeholder='Add Comment'/><p></p>";
                        echo "<input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>";
                        echo "<p style='color: red;' id='log" . $images[$i]['id'] . "' name='count'></p>";
                    }
                    echo "</div>";

                } else {
                    echo "<div class='center comms'>";
                    echo "<p> No comments</p>";
                    if (isset($_SESSION['user'])) {
                        echo "<input class='input center' id='" . "c" . $images[$i]['id'] . "' name='next' type='text' placeholder='Add Comment'/><p></p>";
                        echo "<input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>";
                        echo "<p style='color: red;' id='log" . $images[$i]['id'] . "' name='count'></p>";
                    }
                    echo "</div>";
                }
                $i++;
                if ($i == $this->n) {
                    $i = 0;
                }
                $count--;
                echo "<hr>";
            }
            echo "<p style='display: none; color: black;' id='counter' name='count'>" . $i . "</p>";
            echo "<p style='color: red; display: none' id='log' name='count'></p>";

        } else if (isset($_POST['prev']) && $_POST['prev']) {
            while ($i >= 0 && $count) {
            $start = 1;
                echo "<div class='center post' id='" . $images[$i]['id'] . "'>";
                echo "<div id='imagess'>";
                    echo "<img id='" . $images[$i]['id'] . "' src='" . $images[$i]['image'] . "' style='width: 25%'><p></p>";
                echo "</div>";
                echo "<div id='likes'>";
                if (isset($_SESSION['user'])) {
                    if (array_key_exists($images[$i]['id'], $images[$i]['liked'])) {
                        echo "<input class='button text-black grey' id='unlikebutton' type='submit' value='Unlike'/>";
                    } else {
                        echo "<input class='button text-black grey' id='likebutton' type='submit' value='Like'/>";
                    }
                }
                echo "<p> Likes: " . $images[$i]['likes'] . "</p>";
                echo "</div>";
                if ($images[$i]['comments']) {
                    echo "<div style='display: inline-flex'>";
                        echo "<a class='prev' onclick='prevSlide(" . $images[$i]['id']. ")'>&#10094; Prev</a>";
                    echo "</div>";
                    echo "<div id='comments' class='slideshow-container' style='display: inline-flex'>";
                    foreach ($images[$i]['comments'] as $text) {
                        if ($start) {
                            echo "<div id='" . $images[$i]['id'] . "' class='comment fade center' style='display: block; border: 1px solid grey; margin: 20px; padding-left: 10px; padding-right: 10px'>";
                                echo "<p>" . $text . " </p>";
                            echo "</div>";
                        } else {
                            echo "<div id='" . $images[$i]['id'] . "'  class='comment fade center' style='display: none; border: 1px solid grey; margin: 20px; padding-left: 10px; padding-right: 10px'>";
                                echo "<p>" . $text . " </p>";
                            echo "</div>";
                        } 
                        $start = 0;
                    }
                    echo "</div>";
                    echo "<div style='display: inline-flex'>";
                        echo "<a class='next' onclick='nextSlide(" . $images[$i]['id']. ")'>Next &#10095;</a>";
                    echo "</div>";
                    echo "<div class='padding-16'>";
                        echo "<a class='prev' onclick='allSlides(" . $images[$i]['id']. ")'> All Comments </a>";
                    echo "</div>";

                    echo "<div class='comms'>";
                    if (isset($_SESSION['user'])) {
                        echo "<input class='input center' id='" . "c" . $images[$i]['id'] . "' name='next' type='text' placeholder='Add Comment'/><p></p>";
                        echo "<input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>";
                        echo "<p style='color: red;' id='log" . $images[$i]['id'] . "' name='count'></p>";
                    }
                    echo "</div>";

                } else {
                    echo "<div class='center comms'>";
                    echo "<p> No comments</p>";
                    if (isset($_SESSION['user'])) {
                        echo "<input class='input center' id='" . "c" . $images[$i]['id'] . "' name='next' type='text' placeholder='Add Comment'/><p></p>";
                        echo "<input class='button text-black grey' id='commentbutton' type='button' name='comment' value='Comment'><p></p>";
                        echo "<p style='color: red;' id='log" . $images[$i]['id'] . "' name='count'></p>";
                    }
                    echo "</div>";
                }
                if ($i == 0) {
                    $i = $this->n;
                }
                $i--;
                $count--;
                echo "<hr>";
            }
            echo "<p style='display: none; color: black;' id='counter' name='count'>" . $i . "</p>";
            echo "<p style='color: red; display: none' id='log' name='count'></p>";

        } else {
            echo "<p>No photos</p>";
            echo "<p style='display: none; color: black;' id='counter' name='count'>" . 0 . "</p>";

        }
        unset($_POST['prev']);
        unset($_POST['next']);
    }

    public function index() {
        $this->view->render('gallery');
    }

}