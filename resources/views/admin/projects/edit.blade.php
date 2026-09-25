@extends('layouts.admin')

@section('title', 'Edit project')

@section('content')
@include('admin.projects._form', ['project' => $project])
@endsection
