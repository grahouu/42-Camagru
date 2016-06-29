// -------------------- LIBRARY -----------------------
var targetLast = null;
var element = document.getElementById("image-selector");
var startbutton = document.getElementById("startbutton");
var imagesList = document.getElementById("images-list");

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

function addPhoto(photoInfo){
    var li = document.createElement("li");

    var photo = document.createElement('img');
    photo.src = "/camagru/" + photoInfo.file;
    photo.className = "photo";
    li.appendChild(photo);

    var div = document.createElement('div');
    div.className = "icons";

    var trash = document.createElement('img');
    trash.src = "/camagru/assets/images/trash.png";
    trash.className = "icons";
    trash.setAttribute("onclick", "trash(this, "+ photoInfo.id +")");
    div.appendChild(trash);

    var like = document.createElement('img');
    like.src = "/camagru/assets/images/like.png";
    like.className = "icons";
    like.setAttribute("onclick", "like(this, "+ photoInfo.id +")");
    div.appendChild(like);

    li.appendChild(div);

    imagesList.appendChild(li);
}

// ---------------------------- HOME ----------------------

function trash(element, id){
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', 'photo/' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                element.parentNode.parentNode.parentNode.removeChild(element.parentNode.parentNode);
            }
        }
    };
    xhr.send();
}

function like(element, id){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/like/' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                console.log("ok like");
            }
        }
    };
    xhr.send();
}

function comment(element, id){
    var modal = document.getElementById('myModalComment');
    var span = modal.getElementsByClassName("close")[0];
    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

element.onclick = function(event) {
    var target = getEventTarget(event);

    if (targetLast)
        targetLast.classList.remove("selected");

    if (target == targetLast){
        targetLast = null
        startbutton.style.display = "none";
    }else{
        target.classList.add("selected");
        startbutton.style.display = "";
        targetLast = target;
    }

}

function sendPhoto(image) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'generateImage');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var photoInfo = JSON.parse(xhr.responseText);
            if (photoInfo.success){
                addPhoto(photoInfo);
            }
        }
    };
    xhr.send(JSON.stringify({
        filter: (targetLast ? targetLast.id:null),
        photo: image
    }));
}
