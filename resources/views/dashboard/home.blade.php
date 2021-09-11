@extends('adminlte::page')

@section('title', 'Rumah Admin')

@section('content_header')
<h1 class="d-inline">Rumah Admin</h1>
@include('components/validation')
@stop

@section('content')
<div class="card mb-0">
  <div class="card-header">Rumah Admin</div>
  <div class="card-body">
    <h4>Halo {{$user->profile_name}}</h4>
    {{-- <p>Jumlah peserta :</p>
    <div class="row">
      <div class="col-12 col-md-6">
          <table class="table table-borderless table-striped">
            <thead>
              <th>Kompetisi</th>
              <th>Jumlah Peserta</th>
              <th>Ekspor</th>
            </thead>
              <tbody>
                @forelse ($competition as $item)
                <tr>
                  <td class="font-weight-normal">{{strtoupper($item['name'])}}&nbsp;&nbsp;&nbsp;&nbsp; :</td>
                  <td>{{$item['team_count']}}</td>
                  <td>
                    <a href="{{route('admin.peserta.export', $item['id'])}}" class="btn-sm btn-success">Ekspor</a>
                    </td>
                </tr>
                @empty
                <tr>
                  Tidak Ada Data
                </tr>
                @endforelse
              </tbody>
          </table>
      </div> --}}
  </div>
</div>

@stop
