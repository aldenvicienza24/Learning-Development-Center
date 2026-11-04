@extends('admin.layout', ['title' => 'Tambah Program', 'subtitle' => 'Program baru akan muncul secara otomatis di situs web setelah disimpan.'])

@section('content')
    <form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data" class="cms-panel max-w-5xl p-5">
        @csrf
        @include('admin.programs._form')
    </form>
@endsection
