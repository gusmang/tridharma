@extends('layouts.app')

@section('body')
    <div class="peserta row">
        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <h1>User</h1>
                </div>
                <div class="col text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-info">User baru</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    User List
                </div>
                <div class="card-body table-responsive">
                   <table class="table">
                       <thead>
                           <th>Nama</th>
                           <th>Username</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th></th>
                       </thead>
                       <tbody>
                           @foreach($users as $user)
                           <tr>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <x-form.edit-button url="{{ route('user.edit',$user->id) }}"/>
                            </td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

@endsection
