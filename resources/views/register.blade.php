<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>register perawat</title>
</head>
<body>
    <div class="container">
        <div class="row mt-2">
            <div class="col">
                <h3>REGISTER PERAWAT</h3>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                               placeholder="Masukkan ulang password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                               placeholder="Masukkan email">
                        <small id="emailHelp" class="form-text text-muted">*Email tidak wajib diisi.</small>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="nurse_name" placeholder="Masukkan nama lengkap anda"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="working_exp">Pengalaman bekerja</label>
                        <input type="number" class="form-control" id="working_exp" name="working_exp"
                               placeholder="Masukkan dalam tahun, contoh: 2" required>
                    </div>
                    <div class="form-group">
                        <label for="education">Tingkat Pendidikan</label>
                        <Select class="form-control" id="education" name="education" required>
                            <option value="sma">SMA Sederajat</option>
                            <option value="diploma">Diploma</option>
                            <option value="s1">Sarjana/S1</option>
                            <option value="s2">Magister/S2</option>
                            <option value="s3">Doktoral/S3</option>
                        </Select>
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor HP</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="contoh: 0812XXXXXXXX" required>
                    </div>
                    <div class="form-group">
                        <label for="hospital">Rumah Sakit</label>
                        <Select class="form-control" id="hospital" name="hospital_id" required>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </Select>
                    </div>
                    <div class="text-sm-right">
                        <button type="submit" class="btn btn-primary col-12 col-sm-3 col-md-2 col-lg-1">Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
