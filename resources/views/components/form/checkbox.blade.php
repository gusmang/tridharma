<div class="form-group">
    <label for="">{{ $mainLabel }}</label>
    <div class="form-inline">
        @foreach($labels as $key=>$label)
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input {{ $key>0?'ml-3':'' }} " name="{{ $name }}" value="{{ $values[$key] }}" >
                {{ $label }}
            </label>
        </div>
        @endforeach

    </div>
    <x-form.error-notif :datas="$errors" :filename="$filename"/>
</div>
