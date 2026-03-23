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

        .account-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: left;
        }

        .account-container h5 {
            margin-top: 20px;
        }

        .account-container .alert-warning {
            text-align: center;
        }

        .account-container .info-section {
            margin-top: 20px;
        }

        .account-container .info-section h6 {
            margin-bottom: 10px;
        }

        .account-container .info-section p {
            margin: 0;
        }

        .btn-logout {
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
    </style>
</head>

<body>
    <div class="dashboard  ">
        <nav class="pt-2">
            <div><i class="fas fa-bars menu-icon"></i> <strong class="fs-4">TRANSFERT</strong></div>
            <a href="{{route('info')}}" class="icon-circle" style="display:inline-flex;align-items:center;">
                <img src="{{ $compte->photo_url }}" alt="Photo de profil" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(0,0,0,0.06);">
            </a>

        </nav>
        <hr>
        <div class="alert alert-warning">
            Pour mettre à jour les informations de votre compte, veuillez contacter notre équipe d'assistance.
        </div>
        <div class="info-section">
            <h6 class="text-info fw-bold fs-4"><i class="fas fa-user "></i> Informations Personnelles</h6>
            <p><strong>Titulaire du compte:</strong> {{$compte->nom.' '.$compte->prenom}} </p>
            <p><strong>Adresse e-mail:</strong> {{$compte->email}} </p>
            <p><strong>Numéro de téléphone:</strong> {{$compte->phone_number}} </p>
            <p><strong>Pays de résidence:</strong> {{$compte->country}} </p>
            <p><strong>Adresse de résidence:</strong> {{$compte->address}} </p>
        </div>
        <div class="info-section">
            <h6 class="text-info fw-bold fs-4"><i class="fas fa-university"></i> Compte et Virement</h6>
            <p><strong>Solde du compte:</strong> {{number_format($compte->account_balance, 2, ',', ' ').' '.$compte->devise}} </p>
            <p><strong>Type de compte:</strong> {{$compte->account_type}} </p>
            <p><strong>Statut du compte:</strong> <span class="text-success">
                    @if($compte-> account_status === 'Activé' )
                    <span class="fw-bold"></span> <i style="background-color: green; border-radius:10%; color:white;
                        font-size:.8rem; padding:.2rem; ">{{$compte->account_status }}</i>

                    @elseif($compte->account_status === 'Examen' )
                    <span class="fw-bold"></span> <i style="background-color:blue; border-radius:10%; color:white; 
                        font-size:.8rem; padding:.2rem; ">{{$compte->account_status }}</i>

                    @elseif($compte->account_status === 'Suspendu' )
                    <span class="fw-bold"></span> <i style="background-color: #e97c23; border-radius:10%; color:white;
                        font-size:.8rem; padding:.2rem; ">{{$compte->account_status }}</i>

                    @elseif($compte->account_status === 'Bloque' )
                    <span class="fw-bold"></span> <i style="background-color: red; border-radius:10%; color:white; 
                        font-size:.8rem; padding:.2rem; ">{{$compte->account_status }}</i>
                    @endif
                </span></p>
            <p><strong>Virement supporté:</strong> {{$compte->transfer_supported}} </p>
            <p><strong>IBAN du bénéficiaire:</strong> <span class="text-danger"> {{$compte->iban}} Aucun IBAN enregistré</span></p>
        </div>
        <form action="{{ route('logoutSous') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger fw-bold">Déconnexion <i class="fas fa-sign-out-alt"></i></button>
        </form>

        <footer class="cards mt-5">

            <a href="{{route('showroute')}}" class=" " style="text-decoration: none; ">
                <i class=" fs-4  fas fa-coins"></i>
                <div class="">Solde</div>
            </a>
            <a href="{{route('carte')}}" class="" style="text-decoration: none; ">
                <i class="fs-4 fas fa-credit-card" "></i>
                        <div class=" ">Ma carte</div>
                    </a>
                    <a href=" {{route('virement')}}" class="" style="text-decoration: none; ">
                    <i class="fs-4 fas fa-exchange-alt"></i>
                    <div class=" ">Transfert</div>
            </a>
            <a href="{{route('info')}}" class="" style="text-decoration: none;border-bottom: 2px #007bff solid;">
                <i class="fs-4 fas fa-user"></i>
                <div class=" ">Mon compte</div>
            </a>
        </footer>

    </div>


    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>