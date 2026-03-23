<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfère Prêt</title>
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.css') }} ">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.js') }} " defer>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">


    <style>
        * {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }

        .form-container h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .form-container .form-group {
            text-align: left;
        }

        .alert-info {
            display: flex;
            align-items: center;
        }

        .alert-info i {
            font-size: 1.2em;
            margin-right: 10px;
        }

        .alert-warning {
            margin-top: 20px;
        }

        .dashboard {
            position: relative;
            background-color: white;
            max-width: 800px;
            min-height: 100vh;
            margin: auto;

            box-shadow: 0 0 12px 0 rgba(0, 0, 0, .2);
            overflow: auto;
            padding: 10px 30px 150px 30px;
            transition: all 200ms linear;
        }

        footer {
            position: fixed;

            display: -webkit-box-flex;
            display: -ms-flex;
            display: flex;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
            width: 700px;
            height: 67px;
            border-radius: 30px;
            box-shadow: 0 0 12px 0 rgba(0, 0, 0, .2);
            border: 1px solid #cfe2ff;
            bottom: 20px;
            overflow: hidden;
            background-color: white;
            z-index: 1000;
        }

        @media screen and (max-width: 800px) {
            footer {
                width: 80%;
                left: 10%;
            }
        }

        footer a i {
            display: flex;
            justify-content: center;
            color: white;
            padding-bottom: .5rem;
            position: relative;
            top: 4px;
            color: var(--bs-link-color);
        }

        /* footer a i:hover {
            display: flex;
            justify-content: center;
            color: white;
            padding-bottom: .5rem;
            position: relative;
            top: 4px;
            color: white;
        } */

        footer a * {
            display: block;
        }

        footer a:hover {
            background-color: #ccebf5;

        }


        footer a {
            text-decoration: none;
            width: 25%;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            padding: 6px;
            transition: all 100ms ease;
            color: var(--bs-link-color);
        }

        i {
            font-style: italic;
        }

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

        .d-grid {
            display: grid !important;
        }

        .menu-icon {
            font-size: 24px;
            /* Adjust icon size as needed */
            color: #000;
            /* Adjust icon color as needed */
            cursor: pointer;
        }

        .icon-circle {
            display: inline-block;
            width: 50px;
            /* Adjust size as needed */
            height: 50px;
            /* Adjust size as needed */
            border-radius: 50%;
            background-color: #f0f0f0;
            /* Adjust background color as needed */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-circle i {
            font-size: 24px;
            /* Adjust icon size as needed */
            color: var(--bs-link-color);
        }

        .dashboard nav {
            display: flex;
            justify-content: space-between;
        }

        .image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0px 5px;

        }

        .imageV {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="failureModal" tabindex="-1" role="dialog" aria-labelledby="failureModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="failureModalLabel">Échec du Virement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Votre solde est insuffissant!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="container my-4"> -->
    <div class="dashboard ">
        <nav class="pt-2">
            <div><i class="fas fa-bars menu-icon"></i> <strong class="fs-4">TRANSFERT</strong></div>
            <a href="{{ route('info') }}" class="icon-circle">
                <i class="fas fa-user"></i>
            </a>
        </nav>
        <hr>

        <div class="d-flex imageV">
            <div>
                <i class="fas fa-paper-plane icon fs-5" style="color: var(--bs-link-color);"></i> <strong
                    class="fs-5 ">Effectuer un transfert sortant</strong>
            </div>
            <div>
                <img src="{{ asset('/image/1.jpg') }}" class="image" alt="Image d'exemple">
                <img src="{{ asset('/image/2.jpg') }}" class="image" alt="Image d'exemple">
                <img src="{{ asset('/image/3.jpg') }}" class="image" alt="Image d'exemple">
                <img src="{{ asset('/image/4.jpg') }}" class="image" alt="Image d'exemple">
                <img src="{{ asset('/image/5.jpg') }}" class="image" alt="Image d'exemple">
            </div>
        </div>
        <h1 class="my-3 fw-bold d-flex justify-content-center">
            {{ number_format($compte->account_balance, 2, ',', ' ') . ' ' . $compte->devise }}</h1>
        <form action="{{ route('virementConfirmation') }}" method="post">

            @csrf
            @method('post')
            <div class="text-left my-4">
                <i class="fas fa-info-circle fs-5" style="color: var(--bs-link-color);"></i> Détails du Tranfert
            </div>
            <div class="form-group my-2">

                <input type="text" class="form-control" id="numerocompte" name="numerocompte" placeholder="">
                <label for="numerocompte">Numéro de Compte <i>(ex: +indi + number ) </i> </label>
                @error('numerocompte')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <input type="text" class="form-control" id="name_servieur" name="name_servieur" placeholder="">
                <label for="name_servieur">Nom du serveur <i>(ex: MOOV, MTN, AIRTEL, WAVE, ORANGE) </i> </label>
                @error('name_servieur')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name" placeholder="">
                <label for="beneficiary_name">Nom du bénéficiaire</label>
                @error('beneficiary_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group my-2">
                <input type="text" class="form-control" id="reason" name="reason" placeholder="">
                <label for="reason">Motif</label>
                @error('reason')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="alert alert-warning text-left my-3">
                <i class="fas fa-exclamation-triangle"></i> Traitement du transfert en 1-3 jours ouvrables. Frais :
                Gratuit
            </div>
            @if ($compte->account_balance == 0)
                <a data-toggle="modal"   data-target="#failureModal"
                    class="btn btn-primary btn-block my-2 d-grid gap-2 d-md-flex">Fond insuffisant</a>
            @else
                <button type="submit"
                    class="btn btn-primary btn-block my-2 d-grid gap-2 d-md-flex justify-content-md-end">Suivant</button>
            @endif
        </form>

        <footer class="cards mt-5">

            <a href="{{ route('showroute') }}" class=" " style="text-decoration: none; ">
                <i class=" fs-4  fas fa-coins"></i>
                <div class="">Solde</div>
            </a>
            <a href="{{ route('carte') }}" class="" style="text-decoration: none; ">
                <i class="fs-4 fas fa-credit-card" "></i>
                        <div class=" ">Ma carte</div>
                    </a>
                    <a href=" {{ route('virement') }}" class="" style="text-decoration: none; border-bottom: 2px #007bff solid;">
                    <i class="fs-4 fas fa-exchange-alt"></i>
                    <div class=" ">Transfert</div>
            </a>
            <a href="{{ route('info') }}" class="" style="text-decoration: none;">
                <i class="fs-4 fas fa-user"></i>
                <div class=" ">Mon compte</div>
            </a>
        </footer>
    </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
