// -------------------- LIBRARY -----------------------
function getEventTarget(e) {
    e = e || window.event;
    return e.target || e.srcElement;
}

function getElementsByAttribute(attribute) {
  var matchingElements = [];
  var allElements = document.getElementsByTagName('*');
  for (var i = 0, n = allElements.length; i < n; i++)
  {
    if (allElements[i].getAttribute(attribute) !== null)
    {
      // Element exists with attribute. Add to array.
      matchingElements.push(allElements[i]);
    }
  }
  return matchingElements;
}

// ---------------------------- HOME ----------------------
var targetLast = null;
var element = document.getElementById("image-selector");
var startbutton = document.getElementById("startbutton");
var imagesList = document.getElementById("images-list");
var elementsOnClick = getElementsByAttribute("onclick");

function trash(element, value){
    var xhr = new XMLHttpRequest();
    xhr.open('DELETE', 'photo/' + value[0]);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success){
                element.parentNode.parentNode.removeChild(element.parentNode);
            }
        }
    };
    xhr.send();
}

function like(element, values){
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'photo/like/' + values[0]);
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

for (var i = 0; i < elementsOnClick.length; i++) {
    elementsOnClick[i].onclick = function(event) {
        var target = getEventTarget(event);
        var strSplit = target.getAttribute("onclick").split(/[(),]+/);
        window[strSplit[0]](target, strSplit.slice(1, (strSplit.length - 1)));
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
            var userInfo = JSON.parse(xhr.responseText);
            if (userInfo.success){
                var li = document.createElement("li");

                var photo = document.createElement('img');
                photo.src = "/camagru/" + userInfo.file;
                li.appendChild(photo);

                var trash = document.createElement('img');
                trash.src = "/camagru/assets/images/trash.png";
                trash.className = "icons";
                li.appendChild(trash);

                imagesList.appendChild(li);
            }
        }
    };
    xhr.send(JSON.stringify({
        filter: (targetLast ? targetLast.id:null),
        photo: image
    }));
}
