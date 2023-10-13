@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Name field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $user->name }}">
                            </div>

                            <!-- Surname field -->
                            <div class="mb-3">
                                <label for="surname" class="form-label">{{ __('Surname') }}</label>
                                <input type="text" name="surname" class="form-control" id="surname"
                                    value="{{ $user->surname }}">
                            </div>

                            <!-- Company Name field -->
                            <div class="mb-3">
                                <label for="company_name" class="form-label">{{ __('Company Name') }}</label>
                                <input type="text" name="company_name" class="form-control" id="company_name"
                                    value="{{ $user->company_name }}">
                            </div>

                            <!-- Phone field -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Phone') }}</label>
                                <input type="text" name="phone" class="form-control" id="phone"
                                    value="{{ $user->phone }}">
                            </div>

                            <!-- Email field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    value="{{ $user->email }}">
                            </div>

                            <!-- pass field -->
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation"
                                    id="password_confirmation">
                            </div>



                            <!-- Status field -->
                            <div class="mb-3">
                                <label for="status" class="form-label">{{ __('Status') }}</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="enabled" {{ $user->status == 'enabled' ? 'selected' : '' }}>Enabled
                                    </option>
                                    <option value="disabled" {{ $user->status == 'disabled' ? 'selected' : '' }}>Disabled
                                    </option>
                                </select>
                            </div>


                            <!-- admin -->
                            <div class="mb-3">
                                <label for="is_admin" class="form-label">{{ __('Admin?') }}</label>
                                <select name="is_admin" class="form-control" id="is_admin">
                                    <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>Нет</option>
                                    <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Да</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Update User') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
