@php
    $errclass = "";
    foreach($errors as $error){
        if(str_contains($error,$filename))
            $errclass="border-danger";
    }
@endphp
<div class="form-group">
    <label for="">{{ $label }}</label>
    <textarea class="form-control {{ $errclass }} {{ $class }}" name="{{ $name }}" rows="3">{{ $value[0]?$value[0]:$value[1] }}</textarea>
    <x-form.error-notif :datas="$errors" :filename="$filename"/>
</div>
