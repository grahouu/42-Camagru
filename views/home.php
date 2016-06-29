<div class="main">
    <video id="video" autoplay></video>
    <button id="startbutton" style="display: none;">Prendre une photo</button>

    <!-- <div class="bottom">
        <ul id="image-selector" class="images">
            <?php
            foreach ($masks as $mask) {
                echo "<li> <img src='/camagru/assets/mask/".$mask."' id='".$mask."' alt='photo'> </li>";
            }

            ?>
        </ul>
    </div> -->
</div>

<div class="side">

    <!-- <ul class="photos" id="images-list"> -->
    <ul id="image-selector" class="images">
        <?php
        foreach ($masks as $mask) {
            echo "<li> <img src='/camagru/assets/mask/".$mask."' id='".$mask."' alt='photo' class='mask'> </li>";
        }

        ?>
    </ul>

</div>

<div class="side">
    <canvas id="canvas" style="display: none"></canvas>

    <ul class="photos" id="images-list">
        <?php
        foreach ($photos as $photo) {
            echo "<li>";
            echo "<img class='photo' src='/camagru/".$photo['photo']."' alt='photo'>";

            echo "<div class='icons'>";
            if ($photo['idUser'] == $_SESSION['user']['id'])
                echo "<img class='icons' src='/camagru/assets/images/trash.png' onclick='trash(this, ". $photo['id'] .")' alt='trash'>";
            echo "<img class='icons' src='/camagru/assets/images/like.png' onclick='like(this, ". $photo['id'] .")' alt='like'>";
            echo "<img class='icons' src='/camagru/assets/images/comment.png' onclick='comment(this, ". $photo['id'] .")' alt='comment'>";
            echo "</div>";
            echo "</li>";
        }
        ?>
    </ul>

</div>

<!-- The Modal -->
<div id="myModalComment" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">x</span>
      <form class="" method="post">
        <textarea name="comment" maxlength='255' maxlength='2' rows="2" cols="50" placeholder="Saisir un texte ici."></textarea>
        <input type="submit" value="Envoyer">
      </form>
  </div>

</div>

<script src="../assets/application.js"></script>
<script src="../assets/camera.js"></script>
