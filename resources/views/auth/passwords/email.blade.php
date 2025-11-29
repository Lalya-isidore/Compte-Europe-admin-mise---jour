@extends('./../layouts/app')
@section('page-content')
    @if (session()->has('success'))
        <div class="alert alert-success"> {{ session()->get('success') }} </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger"> {{ session()->get('error') }} </div>
    @endif

    <div class="request-wrapper" style="display:flex;justify-content:center;padding:40px 20px;">
        <div class="request-card" style="width:100%;max-width:520px;background:#fff;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.08);padding:28px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
                <h2 style="margin:0;color:#0b74c9;font-weight:700;font-size:22px;">Réinitialiser le mot de passe</h2>
                <a href="{{ route('connexion') }}" class="btn btn-outline-secondary" style="font-size:14px;padding:6px 12px;border-radius:8px;">← Retour</a>
            </div>

            <p class="text-muted" style="margin-bottom:18px;">Saisissez l'adresse e‑mail associée à votre compte. Nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>

            <form action="{{ route('password.email') }}" method="post" class="form-product form">
                @csrf
                <div style="margin-bottom:12px;">
                    <label for="email" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Adresse e‑mail</label>
                    <input type="email" placeholder="E-mail" class="form-control my-2 input @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="text text-danger" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display:flex;gap:12px;align-items:center;">
                    <button type="submit" class="btn btn-primary" style="flex:1;padding:12px 18px;border-radius:10px;background:linear-gradient(90deg,#1676d2,#2fb1e6);border:none;color:#fff;font-weight:700;">Envoyer le lien de réinitialisation</button>
                    <a href="{{ route('connexion') }}" class="btn btn-link" style="color:#666;text-decoration:none;">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form .input { width:100%; padding:12px 14px; border-radius:8px; border:1px solid #e6eef6; box-shadow:none; }
        .form .input:focus { outline:none; border-color:#bfe6ff; box-shadow:0 4px 18px rgba(47,177,230,0.12); }
        @media (max-width:480px){ .request-card{ padding:18px; } }
    </style>
@endsection
