@extends('layouts.app')

@section('title', 'お問い合わせ詳細')

@section('content')
<h1>お問い合わせ詳細</h1>

<table class="detail-table">
    <tr><th>お名前</th><td>{{ $contact->last_name }} {{ $contact->first_name }}</td></tr>
    <tr><th>性別</th><td>{{ $contact->gender }}</td></tr>
    <tr><th>メールアドレス</th><td>{{ $contact->email }}</td></tr>
    <tr><th>お問い合わせの種類</th><td>{{ $contact->category->name ?? '未設定' }}</td></tr>
    <tr><th>内容</th><td>{!! nl2br(e($contact->content)) !!}</td></tr>
    <tr><th>登録日</th><td>{{ $contact->created_at->format('Y年m月d日 H:i') }}</td></tr>
</table>

<a href="{{ route('admin.index') }}class="btn-back">一覧に戻る</a>
@endsection