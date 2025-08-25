@extends('layouts.app')

@section('header-links')
    <a href="{{ route('register') }}" class="link-button">register</a>
@endsection


@section('title', 'Login')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-title">
    <h1>login</h1>

    <div class="login-form-container">
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus placeholder="例: test@example.com" >
            @error('email')
                    <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="例: ********">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="button-container">
            <button type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection