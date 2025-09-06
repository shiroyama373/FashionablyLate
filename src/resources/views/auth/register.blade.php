@extends('layouts.app')

@section('header-links')
    <a href="{{ route('login') }}" class="link-button">login</a>
@endsection

@section('title', 'Register')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')

<div class="page-title">
    <h1>Register</h1>
</div>

<div class="register-container">    
    <form method="POST" action="{{ route('register') }}" novalidate>
    @csrf 

        <div class="form-group">
            <label for="name">お名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="例: 山田 太郎">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email"  id="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com">
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" placeholder="例: coachtech 1106">
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div> 

    <div class="form-group">
        <button type="submit">登録</button>
        </div>
    </form>
</div>
@endsection