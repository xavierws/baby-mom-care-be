@extends('adminlte::page')

@section('title', 'Kuis')

@section('content_header')
    <h1 class="d-inline">KUIS</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">Daftar Kuis
            @if ($quiz)
            <a class="btn btn-primary text-white float-right" href="{{route('kuis.edit', $id)}}">Ubah</a>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                @if ($quiz)
                    <form>
                        @forelse ($questions as $question)
                        <div class="mb-3 form-group">
                            <div class="row">
                                <div class="col">
                                        <label for="answer">{{ $question->question }}</label>
                                        <select multiple name="" id="answer" class="form-control">
                                            @foreach ($question->choices as $choice)
                                                <option value="" disabled {{ $choice->is_true == 1? "selected":""}}>{{ $choice->choice }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col-1 align-self-center">
                                    <a type="submit" class="btn btn-danger" href="{{ route('kuis.destroy', $question->id) }}">Hapus Pertanyaan</a>
                                </div>
                            </div>
                        </div>
                        @empty

                        @endforelse
                    </form>
                @else
                    <p class='col'>Kuis belum tersedia, silakan buat kuis</p>
                    <br>
                    <a id="tambahKuis" class="btn btn-success text-white col-3" href="{{ route('kuis.create', $id) }}">Tambah KUIS</a>
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
