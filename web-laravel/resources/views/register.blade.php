@extends('layouts.argon')

@section('title', 'Daftar')
@section('page-title', 'Register')
@section('breadcrumb', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card mt-5">
                <div class="card-header text-center">
                    <h4>Daftar Baru</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Daftar gagal!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="/register">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection>
<label for="password_confirmation">Konfirmasi Password</label>
<input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password"
    required>
</div>

<button type="submit" class="register-button">Daftar</button>
</form>

<div class="login-link">
    Sudah punya akun?
    <a href="/login">Masuk di sini</a>
</div>
</div>
</div>
</div>
</body>

</html>
