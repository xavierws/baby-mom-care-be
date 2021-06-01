@extends('adminlte::page')

@section('title', 'Survey')

@section('content_header')
    <h1 class="d-inline">SURVEY</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">Daftar Survey
            <a id="tambah" class="btn btn-primary text-white col-3 float-right" href="{{ route('survey.create') }}">Tambah</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Materi</th>
                                <th>Tipe Pertanyaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($survey as $s)
                            <tr>
                                <td>{{ $s->id }}</td>
                                <td>{{ $s->title }}</td>
                                <td>{{ $s->choice_type }}</td>
                                <td>
                                    <a class="btn btn-success text-white" href="{{ route('survey.show', $s->id) }}">Lihat</a>
                                    <a class="btn btn-danger text-white ml-3" href="{{ route('survey.destroy', $s->id) }}">Hapus Survey</a>
                                </td>
                            </tr>
                            @empty
                                <td>TIDAK ADA DATA</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
