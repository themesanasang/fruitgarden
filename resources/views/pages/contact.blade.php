@extends('layouts.app')

@section('content')

<div class="uk-section uk-section-muted uk-section-xsmall">
    <div class="uk-container">
        <h2 class="uk-text-center">
            <span>
                ติดต่อเรา
            </span>
        </h2>
    </div>
</div>

<div class="uk-section uk-section-small">
    <div class="uk-container">
        <dl class="uk-description-list uk-description-list-divider">
            <dt>ที่อยู่:</dt>
            <dd><?php  echo App\_helpers\DataOther::getContactAddress(); ?></dd>
            <dt>เกี่ยวกับเรา:</dt>
            <dd><?php  echo App\_helpers\DataOther::getContactAbout(); ?></dd>
            <dt>เบอร์โทรศัพท์:</dt>
            <dd><?php  echo App\_helpers\DataOther::getContactPhone(); ?></dd>
            <dt>ติดตาม:</dt>
            <dd>
                <ul class="uk-list ">
                    <li><a href="<?php  echo App\_helpers\DataOther::getContactFacebook(); ?>" target="_blank">Facebook</a></li>
                    <li><a href="<?php  echo App\_helpers\DataOther::getContactInstagram(); ?>" target="_blank">Instagram</a></li>
                    <li><a href="<?php  echo App\_helpers\DataOther::getContactTwitter(); ?>" target="_blank">Twitter</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</div>

@endsection
