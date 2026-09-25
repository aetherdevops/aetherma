@extends('layouts.admin')

@section('title', 'Add project')

@section('content')
@include('admin.projects._form', ['project' => null])
@endsection
