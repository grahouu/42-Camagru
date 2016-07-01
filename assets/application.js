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

    var comment = document.createElement('img');
    comment.src = "/camagru/assets/images/comment.png";
    comment.className = "icons";
    comment.setAttribute("onclick", "comment(this, "+ photoInfo.id +")");
    div.appendChild(comment);

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
    var btn = modal.getElementsByClassName("submit")[0];
    console.log(btn);
    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    btn.onclick = function(event){
        var form = document.getElementById('formComment');
        var data = new FormData(form);

        var text = form.elements["comment"].value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'photo/comment/' + id);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log("okok");
            }
        };
        xhr.send(data);
        console.log(text);
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

// function sendPhoto(image) {
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', 'generateImage');
//     xhr.setRequestHeader('Content-Type', 'application/json');
//     xhr.onload = function() {
//         if (xhr.status === 200) {
//             var photoInfo = JSON.parse(xhr.responseText);
//             if (photoInfo.success){
//                 addPhoto(photoInfo);
//             }
//         }
//     };
//     xhr.send(JSON.stringify({
//         filter: (targetLast ? targetLast.id:null),
//         photo: image
//     }));
// }

function sendPhoto(image) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'generateImage', true);
    var formData = new FormData();

    formData.append('photo', image);
    formData.append('filter', targetLast.id);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var photoInfo = JSON.parse(xhr.responseText);
            if (photoInfo.success){
                addPhoto(photoInfo);
            }
        }
    };
    xhr.send(formData);
}

var form = document.getElementById('file-form');
var fileSelect = document.getElementById('file-select');
var uploadButton = document.getElementById('upload-button');

form.onsubmit = function(event) {
    event.preventDefault();
    uploadButton.innerHTML = 'Uploading...';
    var formData = new FormData();

    formData.append('photo', document.getElementById("preview").src);
    formData.append('filter', targetLast.id);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'generateImage', true);
    xhr.onload = function () {
      if (xhr.status === 200) {
        uploadButton.innerHTML = 'Upload';
        var photoInfo = JSON.parse(xhr.responseText);
        addPhoto(photoInfo);
      } else {
        alert('An error occurred!');
      }
    };
    xhr.send(formData);

}

document.getElementById("file-select").onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };

    // read the image file as a data URL
    reader.readAsDataURL(this.files[0]);
};
