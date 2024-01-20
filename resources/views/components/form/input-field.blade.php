@php
    $class = "";
    foreach($errors as $error){
        if(str_contains($error,$filename))
            $class="border-danger";
    }
@endphp


<div class="form-group">
    @if($label)
    <label for="">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" class="form-control {{ $class }}" name="{{ $name }}" value="{{ $value[0]? $value[0] : $value[1] }}" aria-describedby="helpId" placeholder="{{ $placeholder }}" {{ $required?"required":"" }} @if($type=='date') min="{{ date('Y-m-d')}}" @endif>
    <x-form.error-notif :datas="$errors" :filename="$filename"/>
</div>
