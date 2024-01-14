@extends('layouts.sidenav-layout')
@section('content')
    @include('components.invoice.invoice-info')
    @include('components.invoice.invoice-view')
    @include('components.invoice.invoice-delete')
@endsection