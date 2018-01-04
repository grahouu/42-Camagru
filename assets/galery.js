let pageActual = localStorage.getItem("pageActual") != null ? parseInt(localStorage.getItem("pageActual")) : 1
let galeryContainer = document.querySelector(".galery-container");
let paginateElem = document.querySelector(".paginate");
let pageMax = document.querySelector("#page-max");
var elemPageActual = document.querySelector("#page-actual");

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

// ----- LIKE FUNCTION -----
function like(element, id) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/like/' + id);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            let nbLikes = document.querySelector("#nb-likes\\:" + id)
            let value = nbLikes.innerHTML;
            if (response.success && response.type == "like")
                nbLikes.innerHTML = ++value;
            else
                nbLikes.innerHTML = --value;
        }
    };
    xhr.send();
}

// ----- COMMENT FUNCTION -----
function comment(element, id) {
    var modal = document.getElementById('myModalComment');
    var table = modal.querySelector('table');
    var span = modal.getElementsByClassName("close")[0];
    var btn = modal.getElementsByClassName("submit")[0];
    var xhr = new XMLHttpRequest();

    function addComment(user, comment) {
        var row = table.insertRow(-1);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        cell1.innerHTML = user;
        cell2.innerHTML = comment;
    }

    modal.style.display = "block";

    span.onclick = function () {
        modal.style.display = "none";
        while (table.rows.length > 1) {
            table.deleteRow(table.rows.length - 1);
        }
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            while (table.rows.length > 1) {
                table.deleteRow(table.rows.length - 1);
            }
        }
    }

    xhr.open('GET', 'photo/comment/' + id);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                for (var i in response.data) {
                    addComment(response.data[i].email, response.data[i].comment);
                }
            }
        }
    };
    xhr.send();


    btn.onclick = function (event) {
        var form = document.getElementById('formComment');
        var data = new FormData(form);

        var text = form.elements["comment"].value;
        xhr.open('POST', 'photo/comment/' + id);
        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
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

function paginatePrev() {
    if (elemPageActual.innerHTML <= 1)
        return;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + --pageActual);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                showPhotos(response);
            }
        }
    };
    xhr.send();
}

function paginateNext() {
    if (elemPageActual.innerHTML >= pageMax.innerHTML)
        return;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + ++pageActual);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                showPhotos(response);
            }
        }
    };
    xhr.send();
}

function addPhoto(photo) {
    let html =
        `<a hrel>
        <img src="${photo.photo}" alt="Meadow">
    </a>
    <aside class="photo-box-caption">
        <span class='icons-container'>
            <img src='assets/images/like.png' class='icons' onclick='like(this, ${photo.id})'>
            <span id="nb-likes:${photo.id}"> ${photo.nbLikes} </span>
            <img src='assets/images/comment.png' class='icons' onclick='comment(this, ${photo.id})'>
            <span id="nb-comments:${photo.id}"> ${photo.nbComments} </span>
        </span>
    </aside>`
    let div = document.createElement("div");
    div.className = 'center photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3';
    div.innerHTML = html;
    galeryContainer.appendChild(div);
}

function showPhotos(info) {
    var paras = galeryContainer.getElementsByClassName('photo-box');

    while (paras.length > 0) {
        paras[0].remove();
    }

    for (var i in info.photos) {
        addPhoto(info.photos[i]);
    }

    pageMax.innerHTML = info.pageMax;
    elemPageActual.innerHTML = info.page;
}

function getPhotosPage(page) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + page);
    xhr.onload = function () {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                if (response.TotalPhotos != '0' && !response.photos.length){
                    paginatePage(--pageActual)
                }else if (response.TotalPhotos != '0'){
                    showPhotos(response);
                    paginateElem.style.display = ""
                }
            }
        }
    };
    xhr.send();
}
getPhotosPage(1);