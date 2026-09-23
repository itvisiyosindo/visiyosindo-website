@extends('errors.custom')

@section('title', __('Terlalu Banyak Permintaan'))
@section('code', '429')
@section('icon', '⚡')
@section('message', __('Anda telah membuat terlalu banyak permintaan. Silakan tunggu beberapa saat sebelum mencoba lagi.'))
