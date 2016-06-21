function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

var targetLast = null;
var element = document.getElementById("image-selector");
var startbutton = document.getElementById("startbutton");

element.onclick = function(event) {
    var target = getEventTarget(event);

    if (targetLast)
        targetLast.classList.remove("selected");

    if (target == targetLast){
        targetLast = null
    }else{
        target.classList.add("selected");
        targetLast = target;
    }

}

function sendPhoto(image) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'generateImage');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log("good");
            //var userInfo = JSON.parse(xhr.responseText);
        }
    };
    xhr.send(JSON.stringify({
        filter: (targetLast ? targetLast.id:null),
        photo: image
    }));
}
