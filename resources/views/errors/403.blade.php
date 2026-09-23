@extends('errors.custom')

@section('title', __('Akses Dilarang'))
@section('code', '403')
@section('icon', '⛔')
@section('message', __($exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses sumber daya ini. Hubungi administrator jika Anda merasa ini adalah kesalahan.'))
