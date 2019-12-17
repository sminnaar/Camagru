<?php $this->setSiteTitle('Upload') ?>
<?php $this->start('head'); ?>

    <style>
    #containerv {
    width: 320px;
    height: 240px;
    position: relative;
    }
    #vid1,
    #prev {
    width: 320;
    height: 240;
    position: absolute;
    top: 0;
    left: 0;
    }
    #prev {
        z-index: 0;
    }

</style>
<?php $this->end(); ?>

<?php $this->start('body'); ?>

<script src="./js/camera.js"></script>



<div class="center black">

    <div class="container black center" style="width: 320px; height: 240px; margin: 0 auto; position: relative">
        <div class="containerv">
            <div id="vid1"><video  id="video"></video></div>
            <div id="prev"><canvas id="canvas" width=320 height=240></canvas></div>
        </div>
    </div>

    <div style="padding: 10px">
        <button class="button text-black grey" id="startbutton">Take photo</button>
    </div>

    <div>
        <button class="button text-black grey" id="sbutton1"><img id="s1" src="img/sticker/g1.png" style="width: 70px; "></button>
        <button class="button text-black grey" id="sbutton2"><img id="s2" src="img/sticker/g2.png" style="width: 70px; "></button>
        <button class="button text-black grey" id="sbutton3"><img id="s3" src="img/sticker/g4.png" style="width: 70px; "></button>
        <button class="button text-black grey" id="sbutton4"><img id="s4" src="img/sticker/g5.png" style="width: 70px; "></button>
        <br />
        <br />
        <button class="button text-black grey" id="uploadbutton">Upload Image</button>
    </div>
        
        <br />
        <br />
   
    <div id='thumbs'>
        <canvas id="canvas2" width=80 height=60></canvas>
        <canvas id="canvas3" width=80 height=60></canvas>
        <canvas id="canvas4" width=80 height=60></canvas>
        <canvas id="canvas5" width=80 height=60></canvas>
        <canvas id="canvas6" width=80 height=60></canvas>
    </div>

        <br />
    
    <form action="upload/file" method="POST" enctype="multipart/form-data">
        <input id="image" class="input center" type="file" name="image" /><p></p>
        <button class="button text-black grey" id="preview" >Preview file</button><p></p>
        <button class="button text-black grey" id="save" ><input id="upload_file" class="text-black grey" style='border: none' type="submit" value="Upload File"/></button><p></p>
        <p id="u_errors" style="display: none; color: red;"></p>
    </form>
    <br />

    </div>

</div>
<script>
    document.getElementById("preview").addEventListener("click", function(event){
    event.preventDefault()
    });
</script>
<script>
    document.getElementById("upload_file").addEventListener("click", function(event){
    event.preventDefault()
    });
</script>

<?php $this->end(); ?>