<div class="pure-g galery-container">
    <div style="    font-size: x-large;
    letter-spacing: normal;
    text-align: center;
    width: 100%;"> No photo </div>
</div>

<div class="pure-u-1">
    <div class="l-box paginate" style="display: none;">
        <button onclick='paginatePrev()'>Prev</button>
        <span id='page-actual'>1</span>/<span id='page-max'>1</span>
        <button onclick='paginateNext()'>Next</button>
    </div>
</div>

<!-- The Modal -->
<div id="myModalComment" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">x</span>
    <table class="pure-table">
      <tr>
        <th>User</th>
        <th>Comment</th>
      </tr>
    </table>
    <form class="" id="formComment" method="post">
      <textarea name="comment" maxlength='255' maxlength='2' rows="2" cols="50" placeholder="Saisir un texte ici."></textarea>
      <input type="button" class="submit" value="Envoyer">
    </form>
  </div>

</div>

<script src="assets/galery.js"></script>