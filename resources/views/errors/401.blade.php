@extends('errors.custom')

@section('title', __('Akses Tidak Diizinkan'))
@section('code', '401')
@section('icon', '🔐')
@section('message', __('Anda tidak memiliki otorisasi untuk mengakses halaman ini. Silakan login untuk melanjutkan.'))
