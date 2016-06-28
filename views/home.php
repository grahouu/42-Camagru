<div class="main">
    <video id="video" autoplay></video>
    <button id="startbutton" style="display: none;">Prendre une photo</button>

    <div class="bottom">
        <ul id="image-selector" class="images">
            <?php
            foreach ($masks as $mask) {
                echo "<li> <img src='/camagru/assets/mask/".$mask."' id='".$mask."' alt='photo'> </li>";
            }

            ?>
        </ul>
    </div>
</div>

<div class="side">
    <canvas id="canvas" width="640" height="480" style="display: none"></canvas>

    <ul class="photos" id="images-list">
        <?php
        foreach ($photos as $photo) {
            echo "<li>";
            echo "<img class='photo' src='/camagru/".$photo['photo']."' alt='photo'>";

            echo "<div class='icons'>";
            if ($photo['idUser'] == $_SESSION['user']['id'])
                echo "<img class='icons' src='/camagru/assets/images/trash.png' onclick='trash(". $photo['id'] .")' alt='trash'>";
            echo "<img class='icons' src='/camagru/assets/images/like.png' onclick='like(". $photo['id'] .")' alt='like'>";
            echo "</div>";
            echo "</li>";
        }
        ?>
    </ul>

</div>

<script src="../assets/application.js"></script>
<script src="../assets/camera.js"></script>
