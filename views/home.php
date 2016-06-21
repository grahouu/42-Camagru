<div class="main">
    <video id="video" autoplay></video>
    <button id="startbutton">Prendre une photo</button>

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

    <ul class="photos">
        <?php
        foreach ($photos as $photo) {
            echo "<li> <img src='/camagru/".$photo['photo']."' alt='photo'> </li>";
        }
        ?>
    </ul>

</div>

<script src="../assets/application.js"></script>
<script src="../assets/camera.js"></script>
