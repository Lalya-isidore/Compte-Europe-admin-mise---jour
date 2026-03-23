<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfère Prêt</title>
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.css') }} ">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('bootstrap/bootstrap.js') }} " defer>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

</head>

<body class="container ">

    <style>
        * {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-container {
            max-width: 400px;
            margin: 50px auto;
            text-align: center;
        }

        .card-custom {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            height: 12rem;
        }

        .card-number {
            font-size: 1.5em;
            letter-spacing: 2px;
        }

        .card-name {
            margin-top: 10px;
            font-size: 1.2em;
        }

        .card-expiry,
        .card-cvv {

            font-size: .7rem;
            margin-top: 5px;

        }

        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid #007bff;
            width: 30px;
            height: 30px;
            animation: spin 2s linear infinite;
            display: flex;
            justify-content: center;
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

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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
        <div class="dashboard">
            <nav class="pt-2">
                <div><i class="fas fa-bars menu-icon"></i> <strong class="fs-4">TRANSFERT</strong></div>
                <a href="{{route('info')}}" class="icon-circle">
                    <i class="fas fa-user"></i>
                </a>

            </nav>
            <hr>
            <div class="alert alert-info">
                Félicitations, votre carte de débit est disponible. Avant toute usage, vous devez activer votre carte pour
                accélérer le transfert des fonds crédité sur votre compte.
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card-custom">
                        <div class="card-number fw-bold">{{$compte->card_number}} </div>
                        <div class="card-name fw-bold">{{$compte->nom.' '. $compte->prenom}}</div>
                        @php
                        // Ajout de 2 ans à la date actuelle
                        $futureDate = \Carbon\Carbon::parse($compte->created_at)->addYears(2)->format('m/Y');
                        @endphp

                        <div class="row">
                            <div class="col-md-8 fw-bold">
                                <div class="card-expiry ">VALIDE JUSQU'AU : {{ $futureDate }} </div>
                            </div>
                            <div class="col-md-4">
                                <i class="card-cvv d-flex justify-content-end fw-bold">CVV: {{$compte->cvv}} </i>
                            </div>
                        </div>
                        <i class="card-visa fs-2 fw-bold d-flex justify-content-end"> VISA</i>
                    </div>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-success" data-toggle="modal" data-target="#carteActive">Activer ma carte</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#carteBloque">Bloquer ma carte</button>
                </div>
            </div>
            <!-- Modal active la carte -->
            <div class="modal fade" id="carteActive" tabindex="-1" role="dialog" aria-labelledby="carteActive" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title color-red" id="failureModalLabel" style="color: #f3f3f3;"><i class="fas fa-exclamation-triangle"></i>
                                Alert</h5>
                            <button type="button" class="close bg-danger fs-3" style="color: #f3f3f3; border:0px; " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>L’activation de votre carte de débit n’est pas disponible pour des raisons de sécurité, veuillez réessayer plus tard...</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal bloqué la carte -->
            <div class="modal fade" id="carteBloque" tabindex="-1" role="dialog" aria-labelledby="carteBloque" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title color-red" id="failureModalLabel" style="color: #f3f3f3;"><i class="fas fa-exclamation-triangle"></i>
                                Alert</h5>
                            <button type="button" class="close bg-danger fs-3" style="color: #f3f3f3; border:0px; " data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Cette action n’est pas autorisée, veuillez d’abord activer votre carte de débit.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <h5>Transaction(s) par carte</h5>
                <div class="card">


                    <div class="loader"></div>
                </div>
            </div>

            <footer class="cards mt-5">

                <a href="{{route('showroute')}}" class=" " style="text-decoration: none; ">
                    <i class=" fs-4  fas fa-coins" "></i>
                    <div class=" ">Solde</div>
                </a>
                <a href=" {{route('carte')}}" class="" style="text-decoration: none; border-bottom: 2px #007bff solid; ">
                        <i class="fs-4 fas fa-credit-card"></i>
                        <div class=" ">Ma carte</div>
                </a>
                <a href="{{route('virement')}}" class="" style="text-decoration: none;">
                    <i class="fs-4 fas fa-exchange-alt"></i>
                    <div class=" ">Transfert</div>
                </a>
                <a href="{{route('info')}}" class="" style="text-decoration: none;">
                    <i class="fs-4 fas fa-user"></i>
                    <div class=" ">Mon compte</div>
                </a>
            </footer>
        </div>
        <div class="col-md-2"></div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </div>
        </div>
    </body>

</html>