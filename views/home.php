<div class="main">
  <video id="video" autoplay></video>
  <button id="takepicture">Prendre une photo</button>

  <canvas id="canvas"></canvas>
  <canvas id='photo-tmp' style="display:none;"></canvas>

  <form id="file-form" action="handler.php" method="POST">
    <input type="file" id="file-select" name="photo"/>
  </form>

</br>
<button style="display: none;" type="button" id="generate" onclick="sendPhoto()">GENERATE !</button>

<button style="display: none;" type="button" id="generate" onclick="sendPhoto()">GENERATE !</button>

</div>

<div class="side">
  <ul id="image-selector" class="images">
    <?php
    foreach ($masks as $mask) {
      echo "<li> <img src='/camagru/assets/mask/".$mask."' id='".$mask."' alt='photo' class='mask'> </li>";
    }

    ?>
  </ul>

</div>

<div class="side">

  <ul class="photos" id="images-list">
    <?php
    // foreach ($photos as $photo) {
    //   echo "<li>";
    //   echo "<img class='photo' src='/camagru/".$photo['photo']."' alt='photo'>";
    //
    //   echo "<div class='icons'>";
    //   if ($photo['idUser'] == $_SESSION['user']['id'])
    //   echo "<img class='icons' src='/camagru/assets/images/trash.png' onclick='trash(this, ". $photo['id'] .")' alt='trash'>";
    //   echo "<img class='icons' src='/camagru/assets/images/like.png' onclick='like(this, ". $photo['id'] .")' alt='like'>";
    //   echo "<span id='nb-likes:" . $photo['id']. "'>";
    //   if ($likes[$photo['id']])
    //   echo $likes[$photo['id']];
    //   else
    //   echo "0";
    //   echo "</span>";
    //   echo "<img class='icons' src='/camagru/assets/images/comment.png' onclick='comment(this, ". $photo['id'] .")' alt='comment'>";
    //   echo "<span id='nb-comments:" . $photo['id']. "'>" . count($comments[$photo['id']]) . "</span>";
    //   echo "</div>";
    //   echo "</li>";
    // }
    echo "<div id='paginate'> <button onclick='paginatePrev()'>Prev</button> <span id='page-actual'>1</span>/<span id='page-max'>1</span> <button onclick='paginateNext()'>Next</button> </div>";
    ?>
  </ul>

</div>

<!-- The Modal -->
<div id="myModalComment" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">x</span>
    <table>
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

<script src="../assets/application.js"></script>
<script src="../assets/camera.js"></script>
