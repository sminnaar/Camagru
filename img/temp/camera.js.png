(function() {
    // The width and height of the captured photo. We will set the
    // width to the value defined here, but the height will be
    // calculated based on the aspect ratio of the input stream.
  
    var width = 320;    // We will scale the photo width to this
    var height = 0;     // This will be computed based on the input stream
  
    // |streaming| indicates whether or not we're currently streaming
    // video from the camera. Obviously, we start at false.
  
    var streaming = false;
  
    // The various HTML elements we need to configure or control. These
    // will be set by the startup() function.
  
    var video = null;
    var canvas = null;
    
    var preview = null;
    
    var canvas2 = null;
    var canvas3 = null;
    var canvas4 = null;
    var canvas5 = null;
    var canvas6 = null;

    var photo = null;
    var startbutton = null;

    function startup() {

      video = document.getElementById('video');
      canvas = document.getElementById('canvas'); 
      

      canvas2 = document.getElementById('canvas2'); 
      canvas3 = document.getElementById('canvas3'); 
      canvas4 = document.getElementById('canvas4'); 
      canvas5 = document.getElementById('canvas5'); 
      canvas6 = document.getElementById('canvas6');
      
      startbutton = document.getElementById('startbutton');
      uploadbutton = document.getElementById('uploadbutton');
      sbutton1 = document.getElementById('sbutton1');
      sbutton2 = document.getElementById('sbutton2');
      sbutton3 = document.getElementById('sbutton3');
      sbutton4 = document.getElementById('sbutton4');
      

      // Upload picture from file
      const u_errors = document.getElementById("u_errors");
      let upload_filebutton = document.getElementById("upload_file");

      uploadbutton.onclick = uploadPicture;
      sbutton1.onclick = addSticker1;
      sbutton2.onclick = addSticker2;
      sbutton3.onclick = addSticker3;
      sbutton4.onclick = addSticker4;
     
      upload_filebutton.onclick = onUpload;
      
      previewbutton = document.getElementById('preview');
      previewbutton.onclick = onPreview;
  
      navigator.mediaDevices.getUserMedia({video: true, audio: false})
      .then(function(stream) {
        video.srcObject = stream;
        video.play();
      })
      .catch(function(err) {
        console.log("An error occurred: " + err);
      });
  
      video.addEventListener('canplay', function(ev){
        if (!streaming) {
          height = video.videoHeight / (video.videoWidth/width);
        
          // Firefox currently has a bug where the height can't be read from
          // the video, so we will make assumptions if this happens.
        
          if (isNaN(height)) {
            height = width / (4/3);
          }
        
          video.setAttribute('width', width);
          video.setAttribute('height', height);
          canvas.setAttribute('width', width);
          canvas.setAttribute('height', height);
          
          canvas2.setAttribute('height', 60);
          canvas2.setAttribute('width', 80);
          canvas3.setAttribute('height', 60);
          canvas3.setAttribute('width', 80);
          canvas4.setAttribute('height', 60);
          canvas4.setAttribute('width', 80);
          canvas5.setAttribute('height', 60);
          canvas5.setAttribute('width', 80);
          canvas6.setAttribute('height', 60);
          canvas6.setAttribute('width', 80);

          streaming = true;
        }
      }, false);
  
      startbutton.addEventListener('click', function(ev){
        takepicture();
        addpicture();

        // s1 = false;
        // s2 = false;
        // s3 = false;
        // s4 = false;

        ev.preventDefault();
      }, false);
      
      clearphoto();
    }
  
    // Fill the photo with an indication that none has been
    // captured.
  
    function clearphoto() {
      var context = canvas.getContext('2d');
      context.fillStyle = "#000";
      context.fillRect(0, 0, canvas.width, canvas.height);
    }
    
    // Capture a photo by fetching the current contents of the video
    // and drawing it into a canvas, then converting that to a PNG
    // format data URL. By drawing it on an offscreen canvas and then
    // drawing that to the screen, we can change its size and/or apply
    // other changes before drawing it.
  
    function takepicture() {
      var context = canvas.getContext('2d');
      if (width && height) {
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);
      }
    }
 
    let con2 = 0;
    let con3 = 0;
    let con4 = 0;
    let con5 = 0;
    let con6 = 0;
    let count = 0;
    
    function addpicture() {
      if (count < 5){
        if (!con2) {
          var context2 = canvas2.getContext('2d');
          canvas2.width = 80;
          canvas2.height = 60;
          context2.drawImage(video, 0, 0, 80, 60);
          addStickers(context2);
          con2 = 1;
          count++;
        } else if (!con3) {
          var context3 = canvas3.getContext('2d');
          canvas3.width = 80;
          canvas3.height = 60;
          context3.drawImage(video, 0, 0, 80, 60);
          addStickers(context3);
          con3 = 1;
          count++;
        } else if (!con4) {
          var context4 = canvas4.getContext('2d');
          canvas4.width = 80;
          canvas4.height = 60;
          context4.drawImage(video, 0, 0, 80, 60);
          addStickers(context4);
          con4 = 1;
          count++;
        } else if (!con5) {
          var context5 = canvas5.getContext('2d');
          canvas5.width = 80;
          canvas5.height = 60;
          context5.drawImage(video, 0, 0, 80, 60);
          addStickers(context5);
          con5 = 1;
          count++;
        } else if (!con6) {
          var context6 = canvas6.getContext('2d');
          canvas6.width = 80;
          canvas6.height = 60;
          context6.drawImage(video, 0, 0, 80, 60);
          addStickers(context6);
          con6 = 1;
          count++;
        }
      } else {
        count = 0;
        con2 = 0;
        con3 = 0;
        con4 = 0;
        con5 = 0;
        con6 = 0;
      }

      s1 = false;
      s2 = false;
      s3 = false;
      s4 = false;

    }

      let prev = false;

      let s1 = false;
      let s2 = false;
      let s3 = false;
      let s4 = false;

    function addStickers(context) {
      if (s1) {
        var img = document.getElementById("s1");
        context.drawImage(img, 20, 0, 50, 30);
      }
      if (s2) {
        var img = document.getElementById("s2");
        context.drawImage(img, 20, 0, 50, 30);
      }
      if (s3) {
        var img = document.getElementById("s3");
        context.drawImage(img, 20, 0, 50, 30);
      }
      if (s4) {
        var img = document.getElementById("s4");
        context.drawImage(img, 20, 0, 50, 30);
      }
    }

    function addSticker1() {
        var canvas = document.getElementById("canvas");
        var layer = canvas.getContext("2d");
        var img = document.getElementById("s1");
        layer.drawImage(img, 100, 20, 120, 120);

        s1 = true;
    }

    function addSticker2() {

        var canvas = document.getElementById("canvas");
        var layer = canvas.getContext("2d");
        var img = document.getElementById("s2");
        layer.drawImage(img, 100, 20, 120, 120);
        
        s2 = true;
    }

    function addSticker3() {

        var canvas = document.getElementById("canvas");
        var layer = canvas.getContext("2d");
        var img = document.getElementById("s3");
        layer.drawImage(img, 120, 30, 90, 90);
        
        s3 = true;
    }

    function addSticker4() {

        var canvas = document.getElementById("canvas");
        var layer = canvas.getContext("2d");
        var img = document.getElementById("s4");
        layer.drawImage(img, 120, 30, 90, 90);

        s4 = true;
    }

    function uploadPicture() {
          var file = canvas.toDataURL('image/png');
          var xhr = new XMLHttpRequest;
          xhr.onreadystatechange = function(res) {
            if (this.readyState == 4 && this.status == 200) {
            }
          };
          xhr.open ('POST', 'upload/upload');
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.send("img=" + file);
      }

    function onPreview() {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function(res) {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          resData = res.target.response;
          if (resData) {
              var img = new Image();
              img.setAttribute('crossOrigin', 'anonymous');
              var ctx = canvas.getContext("2d");
              ctx.drawImage(img, 0, 0, 320, 240);
              var dataURL = canvas.toDataURL("image/png");
              display = dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
              img.src = resData;
              ctx.drawImage(img, 0, 0, 320, 240);
          } else {
            u_errors.innerHTML = 'Priview failed.';
            u_errors.style.display = "initial";
          }
        }
      }
      const file = document.getElementById('image');
      const formData = new FormData();
      formData.append('image', file.files[0]);
      xhr.open('POST', 'upload/upload_prev');
      xhr.send(formData);
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
            u_errors.innerHTML = 'Uploaded.';
            u_errors.style.display = "initial";
          }
        }
      }
      const file = document.getElementById('image');
      const formData = new FormData();
      formData.append('image', file.files[0]);
      xhr.open('POST', 'upload/upload_file');
      xhr.send(formData);
    }

  
    window.addEventListener('load', startup, false);
  })();