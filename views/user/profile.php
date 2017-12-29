<span id="token" style="visibility: hidden;"><?php echo $tokenUser ?></span> 
<div class="pure-g">
    <div class="pure-u-lg-3-5 pure-u-sm-1">
        <div class="pure-g">
            <div class="pure-u-lg-12-24 pure-u-sm-1">
                <video id="video" autoplay></video>
            </div>
            <div class="pure-u-lg-12-24 pure-u-sm-1">
                <canvas id="canvas" stlye="width: 100%;"></canvas>
                <canvas id='photo-tmp' style="display:none;"></canvas>
            </div>
        </div>
        <div class="pure-g">
            <div class="mask-container pure-u-sm-1">
                <?php
                foreach ($masks as $mask) {
                    echo "<img src='assets/mask/".$mask."' id='".$mask."' alt='photo' class='mask'>";
                }
                ?>
            </div>
        </div>
        <div class="pure-g center">
            <div class="pure-u-11-24">
                <button id="takepicture">Prendre une photo</button>
            </div>
            <div class="pure-u-2-24">
                OR
            </div>
            <div class="pure-u-11-24">
                <form id="file-form" action="handler.php" method="POST">
                    <input type="file" id="file-select" name="photo"/>
                </form>
            </div>
        </div>
        <div class="pure-g">
            <div class="pure-u-1 center">
                <button type="button" class="pure-button" id="generate" onclick="sendPhoto()" style="display: none;">
                    <i class="fa fa-cog"></i>
                    Generate !
                </button>
            </div>
        </div>

        <div class="pure-g">
            <div class="pure-u-1 center">
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

            </div>
        </div>
        
    </div>

    <div class="pure-u-lg-2-5 pure-u-sm-1">
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


<script src="assets/camera.js"></script>