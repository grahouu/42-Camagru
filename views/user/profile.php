<span id="token" style="visibility: hidden;"><?php echo $tokenUser ?></span> 
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
                    echo "<div class='photo-box'>";
                    echo "<a> <img src='".$photo['photo']."' id='".$photo['id']."' alt='photo'> </a>";
                    echo "<aside class='photo-box-caption'>";
                    echo "<span> <img src='http://www.free-icons-download.net/images/trash-can-symbol-icon-504.png' class='icons-trash' onclick='trash(this, ".$photo['id'].")'> </span>";
                    echo "</aside>";
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>

<form class="pure-form pure-form-aligned" method="post">
    <fieldset>
        <div class="pure-control-group">
            <label for="name">Username</label>
            <input id="name" name="name" pattern=".{4,}" type="text" placeholder="Username">
        </div>

        <div class="pure-control-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
        </div>

        <div class="pure-control-group">
            <label for="email">Email Address</label>
            <input id="email" name="email" type="email" placeholder="Email Address">
        </div>

        <div class="pure-controls">
            <label for="cb" class="pure-checkbox">
                <input id="notif" name="notif" type="checkbox" value="true">  Notifications
            </label>

            <button type="submit" class="pure-button pure-button-primary">Submit</button>
        </div>
    </fieldset>
</form>



<script src="assets/camera.js"></script>