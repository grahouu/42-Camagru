<div class="pure-g">
    <div class="pure-u-3-5">
        <div class="pure-g">
            <div class="pure-u-12-24">
                <video id="video" autoplay></video>
            </div>
            <div class="pure-u-12-24">
                <canvas id="canvas"></canvas>
                <canvas id='photo-tmp' style="display:none;"></canvas>
            </div>
        </div>
        <div class="mask-container">
            <?php
            foreach ($masks as $mask) {
                echo "<img src='assets/mask/".$mask."' id='".$mask."' alt='photo' class='mask'>";
            }
            ?>
        </div>
        <div class="pure-u">
            <div class="pure-u-12-24">
                <button id="takepicture">Prendre une photo</button>
            </div>
            <div class="pure-u-12-24">
                <form id="file-form" action="handler.php" method="POST">
                    <input type="file" id="file-select" name="photo"/>
                </form>
            </div>
        </div>

        <bultton style="display: none;" type="button" id="generate" onclick="sendPhoto()">GENERATE !</button>
        
    </div>

    <div class="pure-u-2-5">
        <div class="photos-container">
            <?php
                foreach ($photos as $photo) {
                    echo "<img src='".$photo['photo']."' id='".$photo['id']."' alt='photo' class='mask'>";
                }
            ?>
        </div>
    </div>
</div>



<script src="assets/camera.js"></script>