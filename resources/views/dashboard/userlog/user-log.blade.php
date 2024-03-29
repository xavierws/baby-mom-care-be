@extends('adminlte::page')

@section('title', 'User Log')

@section('content_header')
    <h1 class="d-inline">USER LOG</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">Daftar Materi</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover table-bordered" id="example2">
                        <thead>
                            <tr>
                                <th>Log</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Rumah Sakit</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($userlog as $u)
                            <tr>
                                <td>{{ $u->log }}</td>
                                <td>{{ $u->user->profile_name }}</td>
                                <td>{{ $u->user->user_role }}</td>
                                <td>{{ $u->user->userable->hospital->name }}</td>
                                <td>{{ $u->created_at }}</td>
                            </tr>
                            @empty
                                <td>TIDAK ADA DATA</td>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('excelDownloadLog') }}" class="btn btn-success">download perhitungan log</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(function () {
            // $("#example1").DataTable({
            // "responsive": true, "lengthChange": false, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
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
