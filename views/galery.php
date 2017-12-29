<div class="pure-g galery-container">
    <div class="photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <a href="http://www.dillonmcintosh.tumblr.com/">
            <img src="http://24.media.tumblr.com/d6b9403c704c3e5aa1725c106e8a9430/tumblr_mvyxd9PUpZ1st5lhmo1_1280.jpg"
                    alt="Beach">
        </a>

        <aside class="photo-box-caption">
            <span>by <a href="http://www.dillonmcintosh.tumblr.com/">Dillon McIntosh</a></span>
        </aside>
    </div>

    <div class="photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <a href="https://www.flickr.com/photos/leshaines123/9199788659/in/photolist-f1XjDR-oqUsF4-eGN3fd-uLvGyn-nsUXqP-6tKPeq-h2Bwtz-6oVtec-3vzcD-nhKUBn-eGN7RY-atDkE4-6qpKgh-5qhbkM-eXSJSR-8YGjfD-eXSK7n-c3hvqo-ddvqc2-h1FgsH-4W6bip-dcnDYJ-ejny6W-bEnete-qoSUSt-nyApt1-cs1Paf-oanrNv-dmE5c9-c4Sgiq-nLYPa4-eHQbYp-fn8csk-uq4gKy-fp186j-7ZcaSx-6wMKEA-kERNCe-veHJHy-eGNaj5-4VddEM-rXUqrU-9X8YXf-87nMXX-tKCh7h-u88G4h-nHuLus-9WPUyn-8fjvkU-nKyT33">
            <img src="https://c2.staticflickr.com/6/5515/9199788659_818383d0b8_k.jpg"
                    alt="Meadow">
        </a>

        <aside class="photo-box-caption">
            <span>
                by <a href="https://www.flickr.com/photos/leshaines123/9199788659/in/photolist-f1XjDR-oqUsF4-eGN3fd-uLvGyn-nsUXqP-6tKPeq-h2Bwtz-6oVtec-3vzcD-nhKUBn-eGN7RY-atDkE4-6qpKgh-5qhbkM-eXSJSR-8YGjfD-eXSK7n-c3hvqo-ddvqc2-h1FgsH-4W6bip-dcnDYJ-ejny6W-bEnete-qoSUSt-nyApt1-cs1Paf-oanrNv-dmE5c9-c4Sgiq-nLYPa4-eHQbYp-fn8csk-uq4gKy-fp186j-7ZcaSx-6wMKEA-kERNCe-veHJHy-eGNaj5-4VddEM-rXUqrU-9X8YXf-87nMXX-tKCh7h-u88G4h-nHuLus-9WPUyn-8fjvkU-nKyT33">Les Haines</a>
            </span>
        </aside>
    </div>

    <div class="photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <a href="http://www.nilssonlee.se/">
            <img src="http://24.media.tumblr.com/23e3f4bb271b8bdc415275fb7061f204/tumblr_mve3rvxwaP1st5lhmo1_1280.jpg"
                    alt="City">
        </a>

        <aside class="photo-box-caption">
            <span>
                by <a href="http://www.nilssonlee.se/">Jonas Nilsson Lee</a>
            </span>
        </aside>
    </div>

    <div class="photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <a href="http://www.flickr.com/photos/rulasibai/">
            <img src="http://24.media.tumblr.com/ac840897b5f73fa6bc43f73996f02572/tumblr_mrraat0H431st5lhmo1_1280.jpg"
                    alt="Flowers">
        </a>

        <aside class="photo-box-caption">
            <span>
                by <a href="http://www.flickr.com/photos/rulasibai/">Rula Sibai</a>
            </span>
        </aside>
    </div>

    <div class="photo-box pure-u-1 pure-u-md-1-2 pure-u-lg-1-3">
        <a href="http://www.flickr.com/photos/charliefoster/">
            <img src="http://24.media.tumblr.com/e100564a3e73c9456acddb9f62f96c79/tumblr_mufs8mix841st5lhmo1_1280.jpg"
                    alt="Bridge">
        </a>

        <aside class="photo-box-caption">
            <span>
                by <a href="http://www.flickr.com/photos/charliefoster/">Charlie Foster</a>
            </span>
        </aside>
    </div>

    <div class="photo-box pure-u-1 pure-u-md-1-3">
        <a href="http://www.goodfreephotos.com/">
            <img src="http://25.media.tumblr.com/88b812f5f9c3d7b83560fd635435d538/tumblr_mx3tlblmY21st5lhmo1_1280.jpg"
                    alt="Port">
        </a>

        <aside class="photo-box-caption">
            <span>
                by <a href="http://www.goodfreephotos.com/">Yinan Chen</a>
            </span>
        </aside>
    </div>
</div>

<div class="pure-u-1">
    <div class="l-box paginate">
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