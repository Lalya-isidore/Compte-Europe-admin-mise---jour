<!-- resources/views/pages/create.blade.php -->
@extends('./../layouts/app')
@section('page-content')

<div class="container">
    <div class="row">
        <div class="col-md-3  my-4"></div>
        <div class="col-md-6 card my-4">
            @if(session()->has('error'))
            <div class="alert alert-success"> {{session()->get('error')}} </div>
            @endif
            <h1 class="my-3">Crée un {{ app('region')->appName() }} </h1>

            <form action="{{ route('compte.edit', $compte->id) }}" method="POST">
                @method('put')
                @csrf
 
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="account_balance">Montant à crédité</label>
                        <i style="color: red">requis</i></label>
                        <input type="number" step="0.01" name="account_balance" id="account_balance" class="form-control mt-2" required value={{ old("account_balance") }}> 
                        @error('account_balance')
                        <div class="text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="row my-3">
                    <div class="form-group col-md-6 ">
                        <label for="account_type my-3">Type de Compte</label>
                        <i style="color: red">requis</i></label>
                        <select name="account_type" id="account_type" class="form-select" require value={{ old("account_type") }}>
                            <option value="" disabled="" selected="">Veillez choisi le Type de compte</option>
                            <option value="Professionnel">Professionnel</option>
                            <option value="Standart">Standart</option>
                            <option value="Prépayé">Prépayé</option>
                            <option value="Prêt">Prêt</option>
                        </select>
                        @error('account_type')
                        <div class="text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="account_status my-1">Statut de Compte</label>
                        <i style="color:red">requis</i>
                        <select name="account_status" id="account_status" class="form-select" require value={{ old("account_status") }}>
                            <option value="" disabled="" selected="">Veillez choisi la statut du compte</option>
                            <option value="Activé">Activé</option>
                            <option value="Examen">En examan</option>
                            <option value="Suspendu">Suspendu</option>
                            <option value="Bloque">Bloque</option>
                        </select>
                        @error('account_status')
                        <div class="text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                </div>

                <div class="form-group my-2">
                    <label for="transfer_supported">Support de transfert</label>
                    <i style="color: red">requis</i></label>
                    <input type="text" name="transfer_supported" id="transfer_supported" class="form-control" required value={{ old("transfer_supported") }}>
                    @error('transfer_supported')
                    <div class="text text-danger">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <hr class="my-4">

                <div class="form-group my-2">
                    <label for="token"><strong>Lien de connexion client</strong></label>
                    <p class="text-muted small mb-2">
                        Personnalisez le token utilisé dans le lien <code>/?c=</code>. Laissez vide pour utiliser le numéro de compte par défaut (<code>{{ $compte->numerocompte }}</code>).
                    </p>

                    @php
                        $clientUrl = rtrim(config('regions.europe.client_login_url', 'https://fluxtransfer.world'), '/');
                        $currentToken = $compte->token ?? $compte->numerocompte;
                        $connectionLink = $clientUrl . '/?c=' . $currentToken;
                    @endphp

                    <div class="input-group mb-2">
                        <span class="input-group-text">{{ $clientUrl }}/?c=</span>
                        <input type="text"
                               name="token"
                               id="token"
                               class="form-control @error('token') is-invalid @enderror"
                               value="{{ old('token', $compte->token) }}"
                               placeholder="{{ $compte->numerocompte }}"
                               pattern="[A-Za-z0-9\-_]+"
                               title="Lettres, chiffres, tirets et underscores uniquement">
                        @error('token')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="text-muted small">Lien actuel :</span>
                        <code id="connectionLinkDisplay" class="small">{{ $connectionLink }}</code>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyLink()">Copier</button>
                        @if($compte->token)
                        <form method="POST" action="{{ route('compte.clear-token', $compte->id) }}" class="d-inline" onsubmit="return confirm('Supprimer le token personnalisé ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">Réinitialiser</button>
                        </form>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary my-3">Crée le Compte</button>
            </form>
        </div>
        <div class="col-md-3 my-4">
            
        </div>
    </div>

</div>
<script>
function copyLink() {
    var link = document.getElementById('connectionLinkDisplay').innerText;
    navigator.clipboard.writeText(link).then(function() {
        alert('Lien copié !');
    });
}
document.getElementById('token').addEventListener('input', function() {
    var base = '{{ $clientUrl }}/?c=';
    var val = this.value.trim() || '{{ $compte->numerocompte }}';
    document.getElementById('connectionLinkDisplay').innerText = base + val;
});
</script>
@endsection
