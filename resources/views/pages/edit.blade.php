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

                <button type="submit" class="btn btn-primary my-3">Crée le Compte</button>
            </form>
        </div>
        <div class="col-md-3 my-4">
            
        </div>
    </div>

</div>
@endsection
