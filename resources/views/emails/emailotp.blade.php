@extends('emails.view.layout')

@section('title', 'Verification Code')

@section('heading')
Verification Code
@endsection
@php
    $mail_otp = session('mail_otp')
@endphp

@section('content')
    <p style="margin:0 0 25px; font-size:16px; color:#4b5563;">
        Use the following code to complete your action
    </p>

    <div style="display:inline-block; padding:15px 30px; font-size:28px;
        font-weight:bold; letter-spacing:4px; color:#111827;
        background-color:#f3f4f6; border-radius:8px;">
        {{ $mail_otp }}
    </div>

    <p style="margin-top:30px; font-size:14px; color:#6b7280;">
        This code will expire in a few minutes.<br>
        If you didn't request this, please ignore this email.
    </p>
@endsection
