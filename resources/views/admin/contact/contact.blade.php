@extends('layouts.app')

@section('content')

    <h3>ข้อมูลติดต่อ</h3>
    <hr>

    @if ($errors->has('success'))
        <div class="uk-margin-small-top uk-margin-small-bottom uk-text-success uk-text-center">
            {{ $errors->first('success') }}
        </div>
    @endif

    <form class="uk-form-horizontal uk-margin-small uk-grid" method="POST" action="{{ url('contact') }}">
            {{ csrf_field() }}

            <input type="hidden" name="id" value="<?php echo ((count((array)$contact) > 0)?$contact->id:0); ?>">

            <div class="uk-width-1-1@m">
                <div class="uk-margin">
                    <label class="uk-form-label" for="about">เกี่ยวกับเรา</label>
                    <div class="uk-form-controls">
                        <textarea id="about" name="about" class="uk-textarea" rows="4" placeholder="เกี่ยวกับเรา" ><?php echo ((count((array)$contact) > 0)?$contact->about:''); ?></textarea>
                    </div>
                </div>
               
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="phone">เบอร์โทรศัพท์</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="phone" type="text" name="phone" placeholder="เบอร์โทรศัพท์" value="<?php echo ((count((array)$contact) > 0)?$contact->phone:''); ?>">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="facebook">Facebook</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="facebook" type="text" name="facebook" placeholder="facebook" value="<?php echo ((count((array)$contact) > 0)?$contact->facebook:''); ?>">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="instagram">Instagram</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="instagram" type="text" name="instagram" placeholder="instagram" value="<?php echo ((count((array)$contact) > 0)?$contact->instagram:''); ?>">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="phone">Twitter</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="twitter" type="text" name="twitter" placeholder="twitter" value="<?php echo ((count((array)$contact) > 0)?$contact->twitter:''); ?>">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="address">ที่อยู่</label>
                    <div class="uk-form-controls">
                        <textarea id="address" name="address" class="uk-textarea" rows="4" placeholder="ที่อยู่" ><?php echo ((count((array)$contact) > 0)?$contact->address:''); ?></textarea>
                    </div>
                </div>
            
            </div>
                

            <div class="uk-margin-medium-top uk-width-1-1@m">
                <div class="uk-text-center">
                    <button type="submit" class="uk-button uk-button-primary">บันทึก</button>
                </div>
            </div>
    </form>

    
@endsection
