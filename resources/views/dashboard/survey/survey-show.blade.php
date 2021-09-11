@extends('adminlte::page')

@section('title', 'Survey')

@section('content_header')
    <h1 class="d-inline">SURVEY</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">Daftar Survey
            @if ($survey)
            <a class="btn btn-primary text-white float-right" href="{{route('survey.edit', $id)}}">Ubah</a>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                @if ($survey)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Pertanyaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($questions as $question)
                                <tr>
                                    <td>{{ $question->number }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td>
                                        {{-- <a type="submit" class="btn btn-danger" href="{{ route('survey.destroy.q', $question->id) }}">Hapus Pertanyaan</a> --}}
                                    </td>
                                </tr>
                                {{-- <div class="mb-3 form-group">
                                    <div class="row">
                                        <div class="col-1">
                                            <label for=""></label>
                                        </div>
                                        <div class="col">
                                                <label for="answer">{{ $question->question }}</label>
                                        </div>
                                        <div class="col-1 align-self-center">
                                            <a type="submit" class="btn btn-danger" href="{{ route('survey.destroy', $question->id) }}">Hapus Pertanyaan</a>
                                        </div>
                                    </div>
                                </div> --}}
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                @else
                    <p class='col'>Kuis belum tersedia, silakan buat kuis</p>
                    <br>
                    <a id="tambahKuis" class="btn btn-success text-white col-3" href="{{ route('survey.create', $id) }}">Tambah</a>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>

    </script>
@stop
