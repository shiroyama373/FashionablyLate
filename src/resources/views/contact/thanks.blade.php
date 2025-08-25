@extends('layouts.app')

@section('title', '送信完了')

@php
    $noHeaderFooter = true;
@endphp

@section('css')
        <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks-container">
    <div class="thanks-bg-text">Thank you</div>

    <div class="thanks-message">
        <h1>お問い合わせありがとうございました</h1>

        <a href="{{ route('contact.create') }}" class="thanks-button">Home</a>
    </div>
</div>
@endsection