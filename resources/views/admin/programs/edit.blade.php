@extends('admin.layout', ['title' => 'Edit Program', 'subtitle' => $program->title])

@section('content')
    <form method="POST" action="{{ route('admin.programs.update', $program) }}" enctype="multipart/form-data" class="cms-panel max-w-5xl p-5">
        @csrf
        @method('PUT')
        @include('admin.programs._form')
    </form>
@endsection
