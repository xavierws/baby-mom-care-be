@extends('adminlte::page')

@section('title', 'Survey')

@section('content_header')
    <h1 class="d-inline">JAWABAN KUISIONER</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h6>{{ $patient->mother_name }}</h6>
                    <table class="table table-hover table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Pertanyaan</th>
                                <th>Jawaban</th>
                                <th>Point</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="d-none">{{ $i = 1 }}</div>
                            @forelse ($data as $d)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $d['question'] }}</td>
                                <td>{{ $d['ans'] }}</td>
                                <td>{{ $d['point'] }}</td>
                            </tr>
                            <div class="d-none">{{ $i++ }}</div>
                            @empty
                                <td>TIDAK ADA DATA</td>
                            @endforelse
                        </tbody>
                    </table>
                    <h6>total point : {{ $total }}</h6>
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
