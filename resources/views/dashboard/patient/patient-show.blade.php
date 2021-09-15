@extends('adminlte::page')

@section('title', 'Pasien')

@section('content_header')
    <h1 class="d-inline">PASIEN</h1>
    @include('components.validation')
@stop

@section('content')
    <div class="card mb-0">
        <div class="card-header">Daftar Pasien</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <table class="table table-hover table-bordered" id="example2">
                        <thead>
                            <tr>
{{--                                <th>Log</th>--}}
                                <th>Nama Bayi</th>
                                <th>Jenis Kelamin</th>
                                <th>Lama Rawat</th>
                                <th>Usia Gestasi</th>
                                <th>Berat Badan Lahir</th>
                                <th>Berat Badan Bayi</th>
                                <th>Panjang Badan Lahir</th>
                                <th>Panjang Badan Bayi</th>
                                <th>Nama Ibu</th>
                                <th>Nama Ayah</th>
                                <th>Telepon</th>
                                {{-- <th>Role</th> --}}
                                <th>Rumah Sakit</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user as $u)
                            <tr>
{{--                                <td>{{ $u->log }}</td>--}}
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->baby_name }}</td>
                                <td>{{ $u->userable->mother_name }}</td>
                                <td>{{ $u->userable->father_name }}</td>
                                <td>{{ $u->userable->phone }}</td>
                                {{-- <td>{{ $u->user_role }}</td> --}}
                                <td>{{ $u->userable->hospital->name }}</td>
                                <td>{{ $u->created_at }}</td>
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
