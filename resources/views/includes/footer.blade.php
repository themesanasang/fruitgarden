<!-- footer  -->
<div class="uk-section uk-section-secondary uk-light uk-section-small">
    <div class="uk-container">
    <div class="uk-grid-match uk-child-width-1-3@m" uk-grid>
        <div>
            <ul class="uk-list ">
                <li><h5 class="">เกี่ยวกับเรา</h5></li>
                <li><?php  echo App\_helpers\DataOther::getContactAbout(); ?></li>
            </ul>
        </div>
        <div>
            <ul class="uk-list ">
                <li><h5 class="">ติดต่อเรา</h5></li>
                <li><?php  echo App\_helpers\DataOther::getContactAddress(); ?></li>
            </ul>
        </div>
        <div>
            <ul class="uk-list ">
                <li><h5 class="">ติดตาม</h5></li>
                <li><a href="<?php  echo App\_helpers\DataOther::getContactFacebook(); ?>" target="_blank">Facebook</a></li>
                <li><a href="<?php  echo App\_helpers\DataOther::getContactInstagram(); ?>" target="_blank">Instagram</a></li>
                <li><a href="<?php  echo App\_helpers\DataOther::getContactTwitter(); ?>" target="_blank">Twitter</a></li>
            </ul>
        </div>
    </div>
    </div>
</div>
<!-- end footer  -->