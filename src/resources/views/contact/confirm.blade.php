@extends('layouts.app')

@section('title', 'Contact Confirm')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm-container">
    <h1>Confirm</h1>

    <form method="POST" action="{{ route('contact.store') }}">
        @csrf

        {{-- hiddenで値を送信 --}}
        <input type="hidden" name="last_name" value="{{ $validated['last_name'] }}">
        <input type="hidden" name="first_name" value="{{ $validated['first_name'] }}">
        <input type="hidden" name="gender" value="{{ $validated['gender'] }}">
        <input type="hidden" name="email" value="{{ $validated['email'] }}">
        <input type="hidden" name="tel" value="{{ $validated['tel'] }}">
        <input type="hidden" name="category_id" value="{{ $validated['category_id'] }}">
        <input type="hidden" name="content" value="{{ $validated['content'] }}">

        <table>
            <tr>
                <th>お名前</th>
                <td>{{ $validated['last_name'] }}　{{ $validated['first_name'] }}</td>  <!-- 全角スペース -->
            </tr>
            <tr>
                <th>性別</th>
                <td>{{ $validated['gender'] }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td>{{ $validated['email'] }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td>{{ $validated['tel'] }}</td>
            </tr>
            <tr>
                <th>お問い合わせの種類</th>
                <td>{{ $validated['category'] }}</td>
            </tr>
            <tr>
                <th>お問い合せの内容</th>
                <td>{{ $validated['content'] }}</td>
            </tr>
        </table>

        <div class="form-actions">
            <button type="submit" name="action" value="send" class="btn-submit">送信</button>
            <button type="submit" name="action" value="modify" class="btn-edit">修正</button>
        </div>
    </form>
</div>
@endsection