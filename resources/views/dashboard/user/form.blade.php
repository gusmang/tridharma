
@extends('layouts.app')
@section('links')
<script src="https://cdn.tiny.cloud/1/7hvgpp2t8p14a5hcbrgxhv7u85cgijjwsqkyrx61tfwwgru1/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('body')
<div class="row justify-content-center mt-3">
    @php $dataErrors= [];  @endphp
    @if ($errors->any())
        @php  $dataErrors = $errors->all();  @endphp
        <!-- <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> -->
    @endif
    <div class=" col-md-6 col-lg-6 pt-5">
        <a href="{{ route('user.index') }}" class="btn btn-info">{{ __('Kembali') }}</a>
        <div class="card mt-3">
            <div class="card-header">
            {{ __('user Form') }}
            </div>

            <div class="card-body">
                <form action="{{ $user?route('user.update',$user->id):route('user.store') }}" method="post" class="">
                    {{ csrf_field() }}
                    @if($user)
                    {{ method_field('PUT') }}
                    @endif

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <x-form.input-field
                                label="First Name"
                                type="text"
                                name="first_name"
                                filename="first name"
                                :value="[old('first_name'), $user?$user->first_name:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div> <div class="form-group col-lg-4">
                            <x-form.input-field
                                label="Last Name"
                                type="text"
                                name="last_name"
                                filename="last name"
                                :value="[old('last_name'), $user?$user->last_name:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="form-group col-lg-4">
                            <x-form.input-field
                                label="Username"
                                type="text"
                                name="name"
                                filename="name"
                                :value="[old('name'), $user?$user->name:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="col-lg-8">
                            <x-form.input-field
                                label="Email"
                                type="email"
                                name="email"
                                filename="email"
                                :value="[old('email'), $user?$user->email:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        @if(!$user)
                        <div class="col-lg-6">
                            <x-form.input-field
                                label="Password"
                                type="password"
                                name="password"
                                filename="password"
                                :value="[old('password'), $user?$user->password:'']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        <div class="col-lg-6">
                            <x-form.input-field
                                label="Password Confirmation"
                                type="password"
                                name="password_confirmation"
                                filename="password confirmation"
                                :value="[old('password_confirmation'), '']"
                                :errors="$dataErrors"
                                :required="true"/>
                        </div>
                        @endif
                        <div class="col-lg-4">
                            <div class="form-group">
                              <label for="">Role</label>
                              <select class="form-control" name="role" required>
                                <option value="admin" @if(($user && $user->role == 'admin') || (old('role') && old('role') == 'admin' )) selected  @endif>Admin</option>
                                <option value="staff" @if(($user && $user->role == 'staff') || (old('role') && old('role') == 'staff' )) selected  @endif>Staff</option>
                              </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

</div>

@php
function checked($value,$data){
    if($value == $data)
      return 'checked';//$value.'|'.$data;
}
@endphp
@endsection

