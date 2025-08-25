@extends('layouts.app')

@section('title', 'Contact')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="form-container">
    <h1>Contact</h1>

    <form method="POST" action="{{ route('contact.confirm') }}" novalidate>
        @csrf

        @php
        // セッションの古い入力値取得
        $oldInput = $oldInput ?? [];
        // 電話番号分割
        $tel_parts = isset($oldInput['tel']) ? explode('-', $oldInput['tel'] . '--') : ['','',''];
        @endphp

        {{-- お名前 --}}
        <div class="form-group">
            <label>お名前 <span class="required">※</span></label>
            <div class="name-inputs">
                <div class="input-with-error">
                    <input type="text" name="last_name" placeholder="山田" 
                        value="{{ old('last_name', $oldInput['last_name'] ?? '') }}">
                    @error('last_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-with-error">
                    <input type="text" name="first_name" placeholder="太郎" 
                        value="{{ old('first_name', $oldInput['first_name'] ?? '') }}">
                    @error('first_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 性別 --}}
        <div class="form-group">
            <label>性別 <span class="required">※</span></label>
            <div class="input-with-error"> 
                <div class="gender-group">
                    <input type="radio" name="gender" id="male" value="男性" 
                        {{ old('gender', $oldInput['gender'] ?? '')=='男性' ? 'checked' : '' }}>
                    <label for="male">男性</label>

                    <input type="radio" name="gender" id="female" value="女性" 
                        {{ old('gender', $oldInput['gender'] ?? '')=='女性' ? 'checked' : '' }}>
                    <label for="female">女性</label>

                    <input type="radio" name="gender" id="other" value="その他" 
                        {{ old('gender', $oldInput['gender'] ?? '')=='その他' ? 'checked' : '' }}>
                    <label for="other">その他</label>
                </div>
                @error('gender')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- メールアドレス --}}
        <div class="form-group">
            <label>メールアドレス <span class="required">※</span></label>
            <div class="input-with-error">
                <input type="email" name="email" placeholder="test@example.com" 
                    value="{{ old('email', $oldInput['email'] ?? '') }}">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- 電話番号 --}}
        <div class="form-group">
            <label>電話番号 <span class="required">※</span></label>
            <div class="input-with-error">
                <div class="tel-input-group-wrapper">
                    <div class="tel-input-group">
                        <input type="text" name="tel1" placeholder="080" 
                            value="{{ old('tel1', $tel_parts[0] ?? '') }}">
                        <span class="tel-sep">-</span>
                        <input type="text" name="tel2" placeholder="1234" 
                            value="{{ old('tel2', $tel_parts[1] ?? '') }}">
                        <span class="tel-sep">-</span>
                        <input type="text" name="tel3" placeholder="5678" 
                            value="{{ old('tel3', $tel_parts[2] ?? '') }}">
                    </div>
                    @error('tel')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        {{-- 住所 --}}
        <div class="form-group">
            <label>住所 <span class="required">※</span></label>
            <div class="input-with-error">
                <input type="text" name="address" placeholder="東京都渋谷区千駄ヶ谷1-2-3" 
                    value="{{ old('address', $oldInput['address'] ?? '') }}">
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- 建物名 --}}
        <div class="form-group">
            <label>建物名</label>
            <div class="input-with-error">
                <input type="text" name="building" placeholder="千駄ヶ谷マンション104" 
                    value="{{ old('building', $oldInput['building'] ?? '') }}">
                @error('building')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- お問い合わせの種類 --}}
        <div class="form-group category-group">
            <label class="category-label">お問い合わせの種類 <span class="required">※</span></label>
            <div class="input-with-error">
                <select name="category_id">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $oldInput['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
                </select>
                @error('category_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- お問い合わせ内容 --}}
        <div class="form-group">
            <label>お問い合わせ内容 <span class="required">※</span></label>
            <div class="input-with-error">
                <textarea name="content" rows="5" placeholder="お問い合わせ内容を記入してください">{{ old('content', $oldInput['content'] ?? '') }}</textarea>
                @error('content')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- 送信ボタン --}}
        <div class="form-actions">
            <button type="submit">確認画面</button>
        </div>

    </form>
</div>
@endsection