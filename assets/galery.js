let pageActual      = localStorage.getItem("pageActual") != null ? parseInt(localStorage.getItem("pageActual")) : 1
let galeryContainer  = document.querySelector(".galery-container");
let pageMax         = document.querySelector("#page-max");

function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

console.log(pageActual)

function addPhoto(photo){
    let html =
    `<a hrel>
        <img src="${photo.photo}" alt="Meadow">
    </a>
    <aside class="photo-box-caption">
        <span>
            by <a href>Les Haines</a>
        </span>
    </aside>`
    let div = document.createElement("div");
    div.className = 'photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3';
	div.innerHTML = html;
    galeryContainer.appendChild(div)








    // var li = document.createElement("li");

    // var photo = document.createElement('img');
    // photo.src = "/camagru/" + photoInfo.photo;
    // photo.className = "photo";
    // li.appendChild(photo);

    // var div = document.createElement('div');
    // div.className = "icons";

    // if (userId == photoInfo.idUser){
    //     var trash = document.createElement('img');
    //     trash.src = "/camagru/assets/images/trash.png";
    //     trash.className = "icons";
    //     trash.setAttribute("onclick", "trash(this, "+ photoInfo.id +")");
    //     div.appendChild(trash);
    // }

    // var like = document.createElement('img');
    // like.src = "/camagru/assets/images/like.png";
    // like.className = "icons";
    // like.setAttribute("onclick", "like(this, "+ photoInfo.id +")");
    // div.appendChild(like);

    // var nbLikes = document.createElement('span');
    // nbLikes.innerHTML = photoInfo.nbLikes;
    // nbLikes.setAttribute("id", "nb-likes:" + photoInfo.id)
    // div.appendChild(nbLikes);

    // var comment = document.createElement('img');
    // comment.src = "/camagru/assets/images/comment.png";
    // comment.className = "icons";
    // comment.setAttribute("onclick", "comment(this, "+ photoInfo.id +")");
    // div.appendChild(comment);

    // var nbComments = document.createElement('span');
    // nbComments.innerHTML = photoInfo.nbComments;
    // nbComments.setAttribute("id", "nb-comments:" + photoInfo.id)
    // div.appendChild(nbComments);

    // li.appendChild(div);

    //imagesList.appendChild(li);
    // imagesList.insertBefore(li, elemPaginate);
}

function showPhotos(info) {
    galeryContainer.innerHTML = '';

    // elemPageActual.innerHTML = info.page;
    // pageMax.innerHTML = info.pageMax;
    // userId = info.idUser;
    // userToken = info.tokenUser;

    for (var i in info.photos){
        addPhoto(info.photos[i]);
    }
}

function getPhotosPage(page) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/paginate/' + page);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                if (response.TotalPhotos != '0' && !response.photos.length)
                    paginatePage(--pageActual);
                else
                    showPhotos(response);
            }
        }
    };
    xhr.send();
}
getPhotosPage(1);