@if ($errors->any())
<div class="alert bg-danger mt-1">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@if (session('success'))
<div class="alert alert-success mt-1">
  <p>{{ session('success') }}</p>
</div>
@endif
