@extends('adminlte::page')

@section('title', 'Kuis')

@section('content_header')
    <h1 class="d-inline">KUIS</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">Daftar Materi</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Materi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="d-none">{{ $i = 1 }}</div>
                            @forelse ($materi as $m)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $m->title }}</td>
                                <td>
                                    <a class="btn btn-success text-white" href="{{ route('kuis.show', $m->id) }}">KUIS</a>
                                </td>
                            </tr>
                            <div class="d-none">{{ $i++ }}</div>
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
    {{-- <script> console.log('Hi!'); </script> --}}
@stop
