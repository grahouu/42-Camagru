streaming       = false,
video           = document.querySelector('#video'),
canvas          = document.querySelector('#canvas'),
canvasPhotoTmp  = document.querySelector('#photo-tmp'),
btnTakePicture  = document.querySelector('#takepicture'),
maskContainer   = document.querySelector(".mask-container"),
btnGenerate     = document.querySelector("#generate")
form            = document.querySelector('#file-form'),
fileSelect      = document.querySelector('#file-select'),
ctx             = canvas.getContext('2d'),
ctxPhotoTmp     = canvasPhotoTmp.getContext('2d'),
vendorURL       = null,
width           = 0,
height          = 0,
mask            = null,
maskpostion     = {'x': 0, y: 0, width: 50, height: 50},
photo           = null,
userToken       = null,
userId          = null;
presskey        = {"w": false, "h": false};

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
navigator.getMedia(
    {
        video: true,
        audio: false
    },
    function(stream) {
        if (navigator.mozGetUserMedia) {
            video.mozSrcObject = stream;
        } else {
            vendorURL = window.URL || window.webkitURL;
            video.src = vendorURL.createObjectURL(stream);
        }
        video.play();
        width = video.offsetWidth;
        height = video.offsetHeight;
    },
    function(err) {
        console.log("An error occured! ", err);
    }
);

video.addEventListener('canplay', function(ev){
    if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        canvasPhotoTmp.setAttribute('width', width);
        canvasPhotoTmp.setAttribute('height', height);
        streaming = true;
    }
}, false);

// ----- TAKE PHOTO -----
btnTakePicture.addEventListener('click', function(ev){
    takepicture();
    ev.preventDefault();
}, false);

function takepicture() {
    canvas.width = width;
    canvas.height = height;
    ctxPhotoTmp.drawImage(video, 0 , 0, width, height);
    canvasPhotoTmp.setAttribute('src', video.src);
    render();
}

// ----- DRAW RENDER FUNCTION -----
function render(){

    var pixel = ctxPhotoTmp.getImageData(0, 0, 1, 1);

    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(canvasPhotoTmp, 0 , 0, width, height);
    if (mask){
        ctx.globalCompositeOperation = 'source-over';
        ctx.drawImage(mask, maskpostion.x, maskpostion.y, maskpostion.width, maskpostion.height);
    }

    if (pixel.data[0] && mask){
        btnGenerate.style.display = "";
    }else{
        btnGenerate.style.display = "none";
    }
}

// ----- MASK SELECTION -----
maskContainer.onclick = function(event) {
    var target = getEventTarget(event);

    if (mask)
        mask.classList.remove("selected");

    if (target == mask){
        mask = null;
    }else{
        target.classList.add("selected");
        mask = target;
    }

    render();
}

// ----- MASK RESIZE AND MOVE -----
window.addEventListener("keydown", function (event) {
    var handled = false;
    var keys = ["Left", "Right", "Up", "Down", "+", "-", "h", "w"];
    var keysPressed = event.key.replace("Arrow", "");

    if (event.key == "h" || event.key == "w")
        presskey[event.key] = true;

    if (keys.indexOf(keysPressed) > -1) {
        handled = true;
        if (keysPressed == "Left")
            maskpostion.x--;
        else if (keysPressed == "Right")
            maskpostion.x++;
        else if (keysPressed == "Up")
            maskpostion.y--;
        else if (keysPressed == "Down")
            maskpostion.y++;
        else if (presskey['h'] && keysPressed == "+"){
            maskpostion.height++;
        }else if (presskey['h'] && keysPressed == "-"){
            maskpostion.height--;
        }else if (presskey['w'] && keysPressed == "+"){
            maskpostion.width++;
        }else if (presskey['w'] && keysPressed == "-"){
            maskpostion.width--;
        }else if (keysPressed == "+"){
            maskpostion.height++;
            maskpostion.width++;
        }else if (keysPressed == "-"){
            maskpostion.height--;
            maskpostion.width--;
        }
    }
    if (handled) {
        event.preventDefault();
        render();
    }
}, true);

// ----- FILE UPLOAD -----
fileSelect.onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        var img = new Image();
        img.onload = function(){
            ctxPhotoTmp.drawImage(img,0,0, width, height);
            render();
        }
        img.src = event.target.result;
    };

    // read the image file as a data URL
    reader.readAsDataURL(this.files[0]);
};

// ----- SEND PHOTO  -----
function sendPhoto() {
    var xhr = new XMLHttpRequest();
    var formData = new FormData();
    var image = canvasPhotoTmp.toDataURL('image/png');

    if (mask && image){
        formData.append('photo', image);
        formData.append('filter', mask.id);
        formData.append('filterX', maskpostion.x);
        formData.append('filterY', maskpostion.y);
        formData.append('filterWidth', maskpostion.width);
        formData.append('filterHeight', maskpostion.height);

        xhr.open('POST', 'generateImage', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var photoInfo = JSON.parse(xhr.responseText);
                if (photoInfo.success){
                    // paginatePage(pageActual);
                }
            }
        };
        xhr.send(formData);
    }
}