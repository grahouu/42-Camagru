// -------------------- LIBRARY -----------------------
var streaming = false,
video           = document.querySelector('#video'),
canvas          = document.querySelector('#canvas'),
canvasPhotoTmp  = document.querySelector('#photo-tmp'),
btnTakePicture  = document.querySelector('#takepicture'),
imageSelector   = document.querySelector("#image-selector"),
btnGenerate     = document.querySelector("#generate"),
imagesList      = document.querySelector("#images-list"),
form            = document.querySelector('#file-form'),
fileSelect      = document.querySelector('#file-select'),
elemPaginate    = document.querySelector('#paginate'),
ctx             = canvas.getContext('2d'),
ctxPhotoTmp     = canvasPhotoTmp.getContext('2d'),
vendorURL       = null,
width           = 0,
height          = 0,
mask            = null,
pageActual      = 1,
maskpostion     = {'x': 0, y: 0, width: 50, height: 50},
photo           = null,
userId          = null;

var elemPageActual = document.querySelector("#page-actual");
var pageMax = document.querySelector("#page-max");


function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

function addPhoto(photoInfo){
    var li = document.createElement("li");

    var photo = document.createElement('img');
    photo.src = "/camagru/" + photoInfo.photo;
    photo.className = "photo";
    li.appendChild(photo);

    var div = document.createElement('div');
    div.className = "icons";

    console.log(userId, photoInfo.idUser);

    if (userId == photoInfo.idUser){
        var trash = document.createElement('img');
        trash.src = "/camagru/assets/images/trash.png";
        trash.className = "icons";
        trash.setAttribute("onclick", "trash(this, "+ photoInfo.id +")");
        div.appendChild(trash);
    }

    var like = document.createElement('img');
    like.src = "/camagru/assets/images/like.png";
    like.className = "icons";
    like.setAttribute("onclick", "like(this, "+ photoInfo.id +")");
    div.appendChild(like);

    var nbLikes = document.createElement('span');
    nbLikes.innerHTML = photoInfo.nbLikes;
    nbLikes.setAttribute("id", "nb-likes:" + photoInfo.id)
    div.appendChild(nbLikes);

    var comment = document.createElement('img');
    comment.src = "/camagru/assets/images/comment.png";
    comment.className = "icons";
    comment.setAttribute("onclick", "comment(this, "+ photoInfo.id +")");
    div.appendChild(comment);

    var nbComments = document.createElement('span');
    nbComments.innerHTML = photoInfo.nbComments;
    nbComments.setAttribute("id", "nb-comments:" + photoInfo.id)
    div.appendChild(nbComments);

    li.appendChild(div);

    //imagesList.appendChild(li);
    imagesList.insertBefore(li, elemPaginate);
}

navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
navigator.getMedia(
    {
        video: true,
        audio: false
    },
    function(stream) {
        console.log("no error");
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

//Take photo
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

// ---------------------------- HOME ----------------------
function paginate(info) {
    var allPhotos = imagesList.querySelectorAll("li");
    Array.prototype.forEach.call( allPhotos, function( node ) {
        node.parentNode.removeChild( node );
    });

    elemPageActual.innerHTML = info.page;
    pageMax.innerHTML = info.pageMax;
    userId = info.idUser;

    for (var i in info.photos){
        addPhoto(info.photos[i]);
    }
}

function paginatePrev(){

    if (elemPageActual.innerHTML <= 1)
        return;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + --pageActual);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                paginate(response);
            }
        }
    };
    xhr.send();

}

function paginateNext(){

    if (elemPageActual.innerHTML >= pageMax.innerHTML)
        return;

    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + ++pageActual);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                paginate(response);
            }
        }
    };
    xhr.send();
}


function paginatePage(page) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + page);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                if (response.TotalPhotos != '0' && !response.photos.length)
                    paginatePage(--pageActual);
                else
                    paginate(response);
            }
        }
    };
    xhr.send();
}
paginatePage(1);


//** TRASH FUNCTION **
function trash(element, id){
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', 'photo/' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                paginatePage(pageActual);
            }
        }
    };
    xhr.send();
}

//** LIKE FUNCTION **
function like(element, id){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/like/' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                var nbLikes = document.querySelector("#nb-likes\\:" + id)
                var value = nbLikes.innerHTML;
                nbLikes.innerHTML = ++value;
            }
        }
    };
    xhr.send();
}



//** COMMENT FUNCTION **
function comment(element, id){
    var modal = document.getElementById('myModalComment');
    var table = modal.querySelector('table');
    var span = modal.getElementsByClassName("close")[0];
    var btn = modal.getElementsByClassName("submit")[0];
    var xhr = new XMLHttpRequest();

    function addComment(user, comment){
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = user;
        cell2.innerHTML = comment;
        console.log(table.rows.length);
    }

    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
        while (table.rows.length > 1) {
            table.deleteRow(table.rows.length - 1);
        }
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
            while (table.rows.length > 1) {
                table.deleteRow(table.rows.length - 1);
            }
        }
    }

    xhr.open('GET', 'photo/comment/' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                for (var i in response.data){
                    addComment(response.data[i].email, response.data[i].comment);
                }
            }
        }
    };
    xhr.send();


    btn.onclick = function(event){
        var form = document.getElementById('formComment');
        var data = new FormData(form);

        var text = form.elements["comment"].value;
        xhr.open('POST', 'photo/comment/' + id);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success){
                    addComment(response.user, response.comment);
                    var nbComments = document.querySelector("#nb-comments\\:" + id)
                    var value = nbComments.innerHTML;
                    nbComments.innerHTML = ++value;
                }
            }
        };
        xhr.send(data);
    }

}

//** DRAW RENDER FUNCTION **
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

window.addEventListener("keydown", function (event) {
    var handled = false;
    var keys = ["Left", "Right", "Up", "Down", "U+002D", "U+002B"];

    if (event.keyIdentifier !== undefined && keys.indexOf(event.keyIdentifier) > -1) {
        handled = true;
        if (event.keyIdentifier == "Left")
            maskpostion.x--;
        else if (event.keyIdentifier == "Right")
            maskpostion.x++;
        else if (event.keyIdentifier == "Up")
            maskpostion.y--;
        else if (event.keyIdentifier == "Down")
            maskpostion.y++;
        else if (event.keyIdentifier == "U+002D"){
            maskpostion.height--;
            maskpostion.width--;
        }else if (event.keyIdentifier == "U+002B"){
            maskpostion.height++;
            maskpostion.width++;
        }
    }
    if (handled) {
        event.preventDefault();
        render();
    }
}, true);

//** MASK SELECTION FUNCTION **
imageSelector.onclick = function(event) {
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

//** SENDPHOTO FUNCTION **
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
                    paginatePage(pageActual);
                }
            }
        };
        xhr.send(formData);
    }
}

//** FILE SELECT CHANGE **
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
