//Création de cookie !
function setUserCookie(element) {
  //-- Recup de l'index selectionne
  var index = element.selectedIndex;
  //-- Recup de la valeur de l'OPTION selectionnee
  var valeur = element.options[index].value;
  //-- Recup du texte de l'OPTION selectionnee
  var texte = element.options[index].text;

  console.debug(element);
  document.cookie = "user_id=" + escape(element.value) + ";expires=Thu, 01-Jan-3000 00:00:01 GMT";
  document.cookie = "username=" + escape(texte) + ";expires=Thu, 01-Jan-3000 00:00:01 GMT";
}

function get_date_heure() {
  var today = new Date;
  var heure = today.getHours();
  var min = today.getMinutes();
  var message;
  if (min < 10) {
    message = heure + "h0" + min;
  } else {
    message = heure + "h" + min;
  }
  min + "m";
  return message;
}

$(function() {
  //Affiche l'heure ou l'efface si on coche ou non la case à cocher
  var toggleHeure = function(checkbox) {
    var $this = $(checkbox);
    var heure = $this.siblings(".heure");
    var hidden = $this.siblings("input[type=hidden]:first");
    if ($this.attr('checked')) {
      heure.val(get_date_heure()).prop('readonly', '');
      hidden.val(1);
    } else {
      heure.val('').prop('readonly', 'readonly');
      hidden.val(0);
    }
  };

  var checkboxes = $(".bon_mauvais input[type=checkbox]");
  checkboxes.click(function() {
    toggleHeure(this);
  });
  
  var deleteLinks = $("[data-method=delete]").click(function(e){
    var $this = $(this);
    if(!confirm($this.data('confirm')))
      e.preventDefault();
  });

});
