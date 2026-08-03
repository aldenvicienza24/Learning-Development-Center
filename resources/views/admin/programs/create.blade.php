@extends('admin.layout', ['title' => 'Tambah Program', 'subtitle' => 'Program baru otomatis muncul di website setelah tersimpan.'])

@section('content')
    <form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data" class="cms-panel max-w-5xl p-5">
        @csrf
        @include('admin.programs._form')
    </form>
@endsection
