<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Business</title>
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.css') }} ">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.js') }} " defer>
</head>
<style>
    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-control {
        padding: 12px 12px 12px 36px;
    }

    .form-control:focus~label,
    .form-control:not(:placeholder-shown)~label {
        top: -10px;
        left: 12px;
        font-size: 0.75rem;
        color: #007bff;
        background: white;
        padding: 0 5px;
        z-index: 10;
    }

    label {
        position: absolute;
        top: 12px;
        left: 36px;
        color: #aaa;
        font-size: 1rem;
        transition: all 0.2s;
        pointer-events: none;
    }
</style>

<body class="container mt-5">
    <div class="row ">
        <div class="col-md-3"></div>
        <div class="col-md-6 card p-3 shadow">
            <a href="{{route('dashboard')}}">Accueil</a>

            <div>
                <h2>Connexion au Compte</h2>
                <form action="{{ route('sousCompte.Auth') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="form-group">

                        <input type="email" name="email" id="email" class="form-control" required>
                        <label for="email">Adresse Email</label>
                        @error('email')
                        <div class="text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <label for="password">Mot de passe</label>
                        @error('password')
                        <div class="text text-danger">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Se connecter</button>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</body>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#infoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var data = {
                nom: button.data('nom'),
                email: button.data('email'),
                phone: button.data('phone'),
                country: button.data('country'),
                password: button.data('password'),
                codeVirement: button.data('code-virement'),
                address: button.data('address'),
                balance: button.data('balance'),
                devise: button.data('devise'),
                accountType: button.data('account-type'),
                accountStatus: button.data('account-status'),
                transferSupported: button.data('transfer-supported'),
                numerocompte: button.data('numerocompte'),
                compteId: button.data('compte-id')
            };

            fillModal(data);

            // Initialize Clipboard.js for all elements with the class 'copy-icon'
            const clipboard = new ClipboardJS('.copy-icon');

            clipboard.on('success', function(e) {
                const icon = e.trigger;
                icon.classList.remove('fa-copy');
                icon.classList.add('fa-check');
                icon.title = 'Copié';

                setTimeout(() => {
                    icon.classList.remove('fa-check');
                    icon.classList.add('fa-copy');
                    icon.title = 'Copier';
                }, 2000);

                e.clearSelection();
            });

            clipboard.on('error', function(e) {
                console.error('Échec de la copie : ', e);
            });

            function fillModal(data) {
                var modal = $('#infoModal');
                modal.find('#modal-nom').text(data.nom);
                modal.find('#modal-email').text(data.email);
                modal.find('#modal-phone').text(data.phone);
                modal.find('#modal-country').text(data.country);
                modal.find('#modal-password').text(data.password);
                modal.find('#modal-code-virement').text(data.codeVirement);
                modal.find('#modal-address').text(data.address);
                modal.find('#modal-balance').text(data.balance);
                modal.find('#modal-devise-display').text(data.devise);
                modal.find('#modal-account-type').text(data.accountType);
                modal.find('#modal-account-status').text(data.accountStatus);
                modal.find('#modal-transfer-supported').text(data.transferSupported);
                $('#compte-id').val(data.compteId);

                $('#envoyer-email-form').attr('action', `/envoyerEmail/${data.compteId}`);
                $('#envoyer-code-form').attr('action', `/envoyerCodeDeblocage/${data.compteId}`);
                $('#remboursement-form').attr('action', `/rembourser-compte/${data.compteId}`);

                if (data.hasCompletedTransfer) {
                    $('#remboursement-btn').show();
                } else {
                    $('#remboursement-btn').hide();
                }
            }
        });
    });
</script>