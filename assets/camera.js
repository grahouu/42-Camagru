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
masks           = [],
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
    if (masks.length){
        masks.forEach(element => {
            ctx.globalCompositeOperation = 'source-over';
            ctx.drawImage(element.mask, element.x, element.y, element.width, element.height); 
        });
    }

    if (pixel.data[0] && masks.length){
        btnGenerate.style.display = "";
    }else{
        btnGenerate.style.display = "none";
    }
}

function maskSelected(mask){
    for (const key in masks) {
        if (masks[key].mask == mask)
            return key;
    }
    return false;
}


// ----- MASK SELECTION -----
maskContainer.onclick = function(event) {
    var target = getEventTarget(event);
    let selected = maskSelected(target);
    console.log(selected)
    if (selected){
        masks[selected].mask.classList.remove("selected");
        masks.splice(selected, 1);
    }else{
        target.classList.add("selected");
        masks.push({ mask: target, id: target.id, x: 0, y: 0, width: 50, height: 50 });
    }

    render();
}

// ----- MASK RESIZE AND MOVE -----
window.addEventListener("keydown", function (event) {
    var handled = false;
    var keys = ["Left", "Right", "Up", "Down", "+", "-", "h", "w"];
    var keysPressed = event.key.replace("Arrow", "");

    let mask = masks[masks.length - 1];
    console.log(mask)

    if (event.key == "h" || event.key == "w")
        presskey[event.key] = !presskey[event.key];

    if (keys.indexOf(keysPressed) > -1) {
        handled = true;
        if (keysPressed == "Left")
            mask.x--;
        else if (keysPressed == "Right")
            mask.x++;
        else if (keysPressed == "Up")
            mask.y--;
        else if (keysPressed == "Down")
            mask.y++;
        else if (presskey['h'] && keysPressed == "+"){
            mask.height++;
        }else if (presskey['h'] && keysPressed == "-"){
            mask.height--;
        }else if (presskey['w'] && keysPressed == "+"){
            mask.width++;
        }else if (presskey['w'] && keysPressed == "-"){
            mask.width--;
        }else if (keysPressed == "+"){
            mask.height++;
            mask.width++;
        }else if (keysPressed == "-"){
            mask.height--;
            mask.width--;
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

    if (masks.length && image){
        formData.append('photo', image);
        formData.append('filters', JSON.stringify(masks) );

        xhr.open('POST', 'generateImage', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var photoInfo = JSON.parse(xhr.responseText);
                if (photoInfo.success){
                    let photo = document.createElement('img');
                    photo.src = photoInfo.file;
                    photo.id = photoInfo.id;
                    let listPhotos  = document.querySelector('.photos-container');
                    listPhotos.appendChild(photo); 
                }
            }
        };
        xhr.send(formData);
    }
}

// ----- TRASH FUNCTION -----
function trash(element, id){
    var url = 'photo/' + id + '/' + document.getElementById("token").innerHTML;;
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', url);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                // paginatePage(pageActual);
            }
        }
    };
    xhr.send();
}