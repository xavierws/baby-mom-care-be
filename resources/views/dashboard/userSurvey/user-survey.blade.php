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
                    <table class="table table-hover table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pasien</th>
                                <th>Jenis Survey</th>
                                <th>Urutan Survey</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($patients[] as $patient)
                            <tr>
                                <td>{{ $patient['patient_id'] }}</td>
                                <td>{{ $patient['name'] }}</td>
                                <td>{{ $patient['survey_title'] }}</td>
                                <td>{{ $patient['order'] }}</td>
                                <td>
                                    <a class="btn btn-success text-white" href="{{ route('usersurvey.show', ['id' => $patient['patient_id'], 'order' => $patient['order']]) }}">Lihat</a>
                                    {{-- <a class="btn btn-danger text-white ml-3" href="{{ route('survey.destroy', $s->id) }}">Hapus Survey</a> --}}
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
    {{-- <script> console.log('Hi!'); </script> --}}
    <script>
        $(function () {
            // $("#example1").DataTable({
            // "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#data-table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            });
        });
    </script>
@stop
