@extends('./../layouts/app')
@section('page-content')
    @if (session()->has('success'))
        <div class="alert alert-success"> {{ session()->get('success') }} </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger"> {{ session()->get('error') }} </div>
    @endif

    <div class="reset-wrapper" style="display:flex;justify-content:center;padding:40px 20px;">
        <div class="reset-card" style="width:100%;max-width:520px;background:#fff;border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,0.08);padding:28px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
                <h2 style="margin:0;color:#0b74c9;font-weight:700;font-size:22px;">Réinitialiser le mot de passe</h2>
                <a href="{{ route('connexion') }}" class="btn btn-outline-secondary" style="font-size:14px;padding:6px 12px;border-radius:8px;">← Retour</a>
            </div>

            <p class="text-muted" style="margin-bottom:18px;">Entrez l'adresse e‑mail associée à votre compte. Vous recevrez un lien sécurisé pour définir un nouveau mot de passe.</p>

            <form method="POST" action="{{ route('password.update') }}" class="form-product form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div style="margin-bottom:12px;">
                    <label for="email" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Adresse e‑mail</label>
                    <input type="email" placeholder="Adresse email" class="form-control my-2 input @error('email') is-invalid @enderror" name="email" id="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="text text-danger" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom:12px;">
                    <label for="password" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Nouveau mot de passe</label>
                    <input type="password" placeholder="Nouveau mot de passe" class="form-control my-2 input @error('password') is-invalid @enderror" name="password" id="password" required autocomplete="new-password">
                    @error('password')
                        <div class="text text-danger" style="margin-top:6px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom:18px;">
                    <label for="password-confirm" style="display:block;font-weight:600;margin-bottom:6px;color:#333;">Confirmer le nouveau mot de passe</label>
                    <input type="password" placeholder="Confirmer le nouveau mot de passe" class="form-control my-2 input" name="password_confirmation" id="password-confirm" required autocomplete="new-password">
                </div>

                <div style="display:flex;gap:12px;align-items:center;">
                    <button type="submit" class="btn btn-primary" style="flex:1;padding:12px 18px;border-radius:10px;background:linear-gradient(90deg,#1676d2,#2fb1e6);border:none;color:#fff;font-weight:700;">Réinitialiser le mot de passe</button>
                    <a href="{{ route('connexion') }}" class="btn btn-link" style="color:#666;text-decoration:none;">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Small improvements kept local to this page */
        .form .input { width:100%; padding:12px 14px; border-radius:8px; border:1px solid #e6eef6; box-shadow:none; }
        .form .input:focus { outline:none; border-color:#bfe6ff; box-shadow:0 4px 18px rgba(47,177,230,0.12); }
        @media (max-width:480px){ .reset-card{ padding:18px; } }
    </style>
@endsection
