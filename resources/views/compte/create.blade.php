@extends('layouts.admin')

@section('title', 'Gestion des Comptes - Flash Compte')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active">Mon compte</li>
    </ol>
@endsection

@section('content')
<style>
    /* Overlay de chargement */
    .loading-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); display:flex; align-items:center; justify-content:center; z-index:9999; backdrop-filter: blur(2px); }
    .loading-overlay .spinner-border { width:3rem; height:3rem; border-width:0.3em; }

    .modern-page-header {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 1.5rem 1rem 1.2rem 1rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px rgba(102,126,234,0.08);
        text-align: left;
    }
    .modern-page-header h1 {
        color: #fff;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-shadow: 0 2px 8px rgba(102,126,234,0.15);
    }
    .modern-page-header .header-icon {
        background: rgba(255,255,255,0.18);
        padding: 0.75rem;
        border-radius: 0.75rem;
        font-size: 1.5rem;
        box-shadow: 0 2px 8px rgba(102,126,234,0.10);
    }

    .info-cards-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }
    @media (max-width: 900px) {
        .info-cards-row {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
    }

    .info-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .summary-card {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        height: 100%;
    }

    .summary-card .summary-card-content {
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .info-card.info-primary {
        border-color: #4CAF50;
        background: linear-gradient(135deg, #e8f5e9 0%, #ffffff 100%);
    }

    .info-card.info-warning {
        border-color: #FF9800;
        background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%);
    }

    .info-card.info-success {
        border-color: #2196F3;
        background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
    }

    .info-card .icon {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }

    .info-card.info-primary .icon { color: #4CAF50; }
    .info-card.info-warning .icon { color: #FF9800; }
    .info-card.info-success .icon { color: #2196F3; }

    .info-card h4 {
        font-size: 0.75rem;
        color: #666;
        margin-bottom: 0.35rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .info-card .value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #333;
    }

    .modern-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .modern-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }

    .modern-card-header h4 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card-body {
        padding: 2rem;
    }

    .form-label-modern {
        font-weight: 600;
        color: #444;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-control-modern {
        border: 2px solid #e0e0e0;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .form-select-modern {
        border: 2px solid #e0e0e0;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-select-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-modern-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .required-star {
        color: #e74c3c;
        font-weight: bold;
    }

    .compte-item {
        background: white;
        border: 2px solid #f0f0f0;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .compte-item:hover {
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.15);
        transform: translateX(5px);
    }

    .compte-info {
        flex: 1;
        min-width: 200px;
    }
    
    .compte-item .btn-details-modern {
        flex-shrink: 0;
        margin-left: auto;
    }

    .compte-name {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
    }

    .compte-balance {
        color: #666;
        font-size: 0.95rem;
    }

    .status-badge-modern {
        padding: 0.35rem 0.85rem;
        border-radius: 2rem;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: white !important;
    }

    .btn-details-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-details-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .form-switch-modern .form-check-input {
        -webkit-appearance: none;
        appearance: none;
        width: 44px;
        height: 26px;
        background: #e6e6e6;
        border-radius: 999px;
        position: relative;
        cursor: pointer;
        border: 0;
        transition: background-color 0.18s ease, box-shadow 0.18s ease;
        box-shadow: inset 0 0 0 1px rgba(0,0,0,0.03);
        display: inline-block;
    }

    /* Label inside the track: changes between OFF / ON */
    .form-switch-modern .form-check-input::before {
        content: 'OFF';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.72rem;
        font-weight: 700;
        color: #444;
        pointer-events: none;
        transition: color 0.12s ease, content 0.12s ease;
        letter-spacing: 0.6px;
    }

    .form-switch-modern .form-check-input::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 4px;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        transition: left 0.18s ease, transform 0.18s ease;
    }

    .form-switch-modern .form-check-input:checked {
        background-color: #667eea;
        box-shadow: none;
    }

    .form-switch-modern .form-check-input:checked::after {
        left: calc(100% - 4px - 18px);
    }

    /* Change label text & color when checked */
    .form-switch-modern .form-check-input:checked::before {
        content: 'ON';
        color: #fff;
    }

    /* Visible focus ring for accessibility */
    .form-switch-modern .form-check-input:focus-visible {
        outline: none;
        box-shadow: 0 0 0 4px rgba(102,126,234,0.25), inset 0 0 0 1px rgba(0,0,0,0.03);
    }

    .form-switch-modern .form-check-input:focus {
        outline: none;
    }

    .alert-modern {
        border: none;
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        border-left: 4px solid;
    }

    .alert-modern.alert-info {
        background: #e3f2fd;
        border-left-color: #2196F3;
        color: #0d47a1;
    }

    .alert-modern.alert-success {
        background: #e8f5e9;
        border-left-color: #4CAF50;
        color: #1b5e20;
    }

    .alert-modern.alert-warning {
        background: #fff3e0;
        border-left-color: #FF9800;
        color: #e65100;
    }

    .alert-modern.alert-danger {
        background: #ffebee;
        border-left-color: #f44336;
        color: #b71c1c;
    }

    .section-divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #667eea, transparent);
        margin: 2rem 0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #999;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .modern-page-header {
            padding: 1rem 0.5rem 1rem 0.5rem;
        }
        .modern-page-header h1 {
            font-size: 1.2rem;
            flex-direction: column;
            gap: 0.5rem;
            text-align: left;
        }
        .info-cards-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        .summary-card {
            flex-direction: row;
            align-items: center;
            padding: 0.85rem;
            gap: 0.75rem;
        }
        .summary-card .icon {
            margin-bottom: 0;
            font-size: 1.5rem;
        }
        .summary-card .summary-card-content {
            flex: 1;
        }
        .summary-card h4 {
            font-size: 0.7rem;
            margin-bottom: 0;
        }
        .summary-card .value {
            font-size: 1.2rem;
        }
        .info-card {
            padding: 0.7rem;
            font-size: 0.95rem;
        }
        .modern-card-header {
            padding: 1rem;
            font-size: 1rem;
        }
        .modern-card-body {
            padding: 1rem;
        }
        .compte-item {
            flex-wrap: wrap;
            padding: 0.7rem;
        }
        .compte-item .btn-details-modern {
            width: 100%;
            margin-left: 0;
            margin-top: 0.5rem;
        }
        .form-control-modern, .form-select-modern {
            padding: 0.5rem 0.7rem;
            font-size: 0.9rem;
        }
        .btn-modern-primary {
            padding: 0.7rem 1.2rem;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {
        .historique-recharges-card {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            max-width: 98vw;
        }
        .form-switch-modern .form-check-input {
            width: 36px;
            height: 22px;
        }
        .form-switch-modern label {
            font-size: 0.95rem;
        }
    }

</style>

{{--  MARGE GAUCHE / DROITE  --}}
<div class="container-fluid px-lg-4 px-md-3 px-2 py-4">

    <!-- En-tête moderne -->
    <div class="modern-page-header">
        <h1>
            <span class="header-icon"><i class="fas fa-wallet"></i></span>
            Gestion des FlashComptes
        </h1>
    </div>

    @if (session('success'))
        <div class="alert alert-modern alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-modern alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->has('error'))
        <div class="alert alert-modern alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $errors->first('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $fieldErrorMessages = collect($errors->getMessages())
            ->except('error')
            ->flatMap(function ($messages) {
                return $messages;
            })
            ->filter()
            ->values();
        $compteCreated = session('compte_created');
        $availableCredits = auth()->user()->credit_user ?? 0;
    @endphp

    @if ($fieldErrorMessages->isNotEmpty())
        <div class="alert alert-modern alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Veuillez corriger les champs suivants :</strong>
            <ul class="mb-0 mt-2">
                @foreach ($fieldErrorMessages as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Cartes d'information -->
    <div class="info-cards-row">
        <div class="info-card summary-card info-primary">
            <div class="icon"><i class="fas fa-coins"></i></div>
            <div class="summary-card-content">
                <h4>Coût de création</h4>
                <!-- NOUVEAU COÛT -->
                <div class="value">4 000 Crédits</div>
            </div>
        </div>
        
        <div class="info-card summary-card info-success">
            <div class="icon"><i class="fas fa-wallet"></i></div>
            <div class="summary-card-content">
                <h4>Crédit disponible</h4>
                <div class="value">{{ number_format($availableCredits, 0, ',', ' ') }}</div>
            </div>
        </div>
        
        <div class="info-card summary-card info-warning">
            <div class="icon"><i class="fas fa-credit-card"></i></div>
            <div class="summary-card-content">
                <h4>Besoin de crédits ?</h4>
                <div class="value" style="font-size: 1rem; margin-top: 0.5rem;">
                    <a href="{{ route('recharge.index') }}" class="text-decoration-none" style="color: #FF9800; font-weight: 600;">
                        Recharger →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CRÉER UN COMPTE ===== -->
    <div class="row mt-4">
        <div class="col-lg-6 mb-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h4><i class="fas fa-user-plus"></i> Créer un FlashCompte</h4>
                </div>
                <div class="modern-card-body">
                    <form id="createCompteForm" action="{{ route('compte.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label-modern">Nom <span class="required-star">*</span></label>
                                <input type="text" name="nom" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label-modern">Prénom <span class="required-star">*</span></label>
                                <input type="text" name="prenom" class="form-control form-control-modern" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Email <span class="required-star">*</span></label>
                            <input type="email" name="email" class="form-control form-control-modern" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Photo de profil (optionnel)</label>
                            <input type="file" name="photo" class="form-control form-control-modern" accept="image/*">
                            <small class="form-text text-muted"><i class="fas fa-info-circle"></i> Formats acceptés : JPG, PNG, GIF (max 2MB)</small>
                            @error('photo')
                                <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-modern">Téléphone <span class="required-star">*</span></label>
                                <input type="text" name="phone_number" class="form-control form-control-modern" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-modern">Pays <span class="required-star">*</span></label>
                                <select class="form-select form-select-modern" name="country" required id="country">
                                <option disabled selected>
                                    Sélectionnez un pays
                                </option>
                                <option value="Afghanistan (+93)" data-tel="+93" data-code="AF">
                                    🇦🇫 Afghanistan (+93)
                                </option>
                                <option value="Afrique du Sud (+27)" data-tel="+27" data-code="ZA">
                                    🇿🇦 Afrique du Sud (+27)
                                </option>
                                <option value="Albanie (+355)" data-tel="+355" data-code="AL">
                                    🇦🇱 Albanie (+355)
                                </option>
                                <option value="Algérie (+213)" data-tel="+213" data-code="DZ">
                                    🇩🇿 Algérie (+213)
                                </option>
                                <option value="Allemagne (+49)" data-tel="+49" data-code="DE">
                                    🇩🇪 Allemagne (+49)
                                </option>
                                <option value="Andorre (+376)" data-tel="+376" data-code="AD">
                                    🇦🇩 Andorre (+376)
                                </option>
                                <option value="Angola (+244)" data-tel="+244" data-code="AO">
                                    🇦🇴 Angola (+244)
                                </option>
                                <option value="Anguilla (+1264)" data-tel="+1264" data-code="AI">
                                    🇦🇮 Anguilla (+1264)
                                </option>
                                <option value="Antarctique (+672)" data-tel="+672" data-code="AQ">
                                    🇦🇶 Antarctique (+672)
                                </option>
                                <option value="Antigua-et-Barbuda (+1268)" data-tel="+1268" data-code="AG">
                                    🇦🇬 Antigua-et-Barbuda (+1268)
                                </option>
                                <option value="Arabie saoudite (+966)" data-tel="+966" data-code="SA">
                                    🇸🇦 Arabie saoudite (+966)
                                </option>
                                <option value="Argentine (+54)" data-tel="+54" data-code="AR">
                                    🇦🇷 Argentine (+54)
                                </option>
                                <option value="Arménie (+374)" data-tel="+374" data-code="AM">
                                    🇦🇲 Arménie (+374)
                                </option>
                                <option value="Aruba (+297)" data-tel="+297" data-code="AW">
                                    🇦🇼 Aruba (+297)
                                </option>
                                <option value="Australie (+61)" data-tel="+61" data-code="AU">
                                    🇦🇺 Australie (+61)
                                </option>
                                <option value="Autriche (+43)" data-tel="+43" data-code="AT">
                                    🇦🇹 Autriche (+43)
                                </option>
                                <option value="Azerbaïdjan (+994)" data-tel="+994" data-code="AZ">
                                    🇦🇿 Azerbaïdjan (+994)
                                </option>
                                <option value="Bahamas (+1242)" data-tel="+1242" data-code="BS">
                                    🇧🇸 Bahamas (+1242)
                                </option>
                                <option value="Bahreïn (+973)" data-tel="+973" data-code="BH">
                                    🇧🇭 Bahreïn (+973)
                                </option>
                                <option value="Bangladesh (+880)" data-tel="+880" data-code="BD">
                                    🇧🇩 Bangladesh (+880)
                                </option>
                                <option value="Barbade (+1246)" data-tel="+1246" data-code="BB">
                                    🇧🇧 Barbade (+1246)
                                </option>
                                <option value="Belgique (+32)" data-tel="+32" data-code="BE">
                                    🇧🇪 Belgique (+32)
                                </option>
                                <option value="Belize (+501)" data-tel="+501" data-code="BZ">
                                    🇧🇿 Belize (+501)
                                </option>
                                <option value="Bermudes (+1441)" data-tel="+1441" data-code="BM">
                                    🇧🇲 Bermudes (+1441)
                                </option>
                                <option value="Bhoutan (+975)" data-tel="+975" data-code="BT">
                                    🇧🇹 Bhoutan (+975)
                                </option>
                                <option value="Bolivie (+591)" data-tel="+591" data-code="BO">
                                    🇧🇴 Bolivie (+591)
                                </option>
                                <option value="Bonaire, Saint Eustache et Saba (+599)" data-tel="+599" data-code="BQ">
                                    🇧🇶 Bonaire, Saint Eustache et Saba (+599)
                                </option>
                                <option value="Bosnie-Herzégovine (+387)" data-tel="+387" data-code="BA">
                                    🇧🇦 Bosnie-Herzégovine (+387)
                                </option>
                                <option value="Botswana (+267)" data-tel="+267" data-code="BW">
                                    🇧🇼 Botswana (+267)
                                </option>
                                <option value="Brunéi Darussalam (+673)" data-tel="+673" data-code="BN">
                                    🇧🇳 Brunéi Darussalam (+673)
                                </option>
                                <option value="Brésil (+55)" data-tel="+55" data-code="BR">
                                    🇧🇷 Brésil (+55)
                                </option>
                                <option value="Bulgarie (+359)" data-tel="+359" data-code="BG">
                                    🇧🇬 Bulgarie (+359)
                                </option>
                                <option value="Burkina Faso (+226)" data-tel="+226" data-code="BF">
                                    🇧🇫 Burkina Faso (+226)
                                </option>
                                <option value="Burundi (+257)" data-tel="+257" data-code="BI">
                                    🇧🇮 Burundi (+257)
                                </option>
                                <option value="Bélarus (+375)" data-tel="+375" data-code="BY">
                                    🇧🇾 Bélarus (+375)
                                </option>
                                <option value="Bénin (+229)" data-tel="+229" data-code="BJ">
                                    🇧🇯 Bénin (+229)
                                </option>
                                <option value="Cambodge (+855)" data-tel="+855" data-code="KH">
                                    🇰🇭 Cambodge (+855)
                                </option>
                                <option value="Cameroun (+237)" data-tel="+237" data-code="CM">
                                    🇨🇲 Cameroun (+237)
                                </option>
                                <option value="Canada (+1)" data-tel="+1" data-code="CA">
                                    🇨🇦 Canada (+1)
                                </option>
                                <option value="Cap-Vert (+238)" data-tel="+238" data-code="CV">
                                    🇨🇻 Cap-Vert (+238)
                                </option>
                                <option value="Chili (+56)" data-tel="+56" data-code="CL">
                                    🇨🇱 Chili (+56)
                                </option>
                                <option value="Chine (+86)" data-tel="+86" data-code="CN">
                                    🇨🇳 Chine (+86)
                                </option>
                                <option value="Chypre (+357)" data-tel="+357" data-code="CY">
                                    🇨🇾 Chypre (+357)
                                </option>
                                <option value="Colombie (+57)" data-tel="+57" data-code="CO">
                                    🇨🇴 Colombie (+57)
                                </option>
                                <option value="Comores (+269)" data-tel="+269" data-code="KM">
                                    🇰🇲 Comores (+269)
                                </option>
                                <option value="Congo-Brazzaville (+242)" data-tel="+242" data-code="CG">
                                    🇨🇬 Congo-Brazzaville (+242)
                                </option>
                                <option value="Corée du Nord (+850)" data-tel="+850" data-code="KP">
                                    🇰🇵 Corée du Nord (+850)
                                </option>
                                <option value="Corée du Sud (+82)" data-tel="+82" data-code="KR">
                                    🇰🇷 Corée du Sud (+82)
                                </option>
                                <option value="Costa Rica (+506)" data-tel="+506" data-code="CR">
                                    🇨🇷 Costa Rica (+506)
                                </option>
                                <option value="Croatie (+385)" data-tel="+385" data-code="HR">
                                    🇭🇷 Croatie (+385)
                                </option>
                                <option value="Cuba (+53)" data-tel="+53" data-code="CU">
                                    🇨🇺 Cuba (+53)
                                </option>
                                <option value="Curacao (+599)" data-tel="+599" data-code="CW">
                                    🇨🇼 Curacao (+599)
                                </option>
                                <option value="Côte d’Ivoire (+225)" data-tel="+225" data-code="CI">
                                    🇨🇮 Côte d’Ivoire (+225)
                                </option>
                                <option value="Danemark (+45)" data-tel="+45" data-code="DK">
                                    🇩🇰 Danemark (+45)
                                </option>
                                <option value="Djibouti (+253)" data-tel="+253" data-code="DJ">
                                    🇩🇯 Djibouti (+253)
                                </option>
                                <option value="Dominique (+1767)" data-tel="+1767" data-code="DM">
                                    🇩🇲 Dominique (+1767)
                                </option>
                                <option value="Égypte (+20)" data-tel="+20" data-code="EG">
                                    🇪🇬 Égypte (+20)
                                </option>
                                <option value="El Salvador (+503)" data-tel="+503" data-code="SV">
                                    🇸🇻 El Salvador (+503)
                                </option>
                                <option value="Émirats arabes unis (+971)" data-tel="+971" data-code="AE">
                                    🇦🇪 Émirats arabes unis (+971)
                                </option>
                                <option value="Équateur (+593)" data-tel="+593" data-code="EC">
                                    🇪🇨 Équateur (+593)
                                </option>
                                <option value="Érythrée (+291)" data-tel="+291" data-code="ER">
                                    🇪🇷 Érythrée (+291)
                                </option>
                                <option value="Espagne (+34)" data-tel="+34" data-code="ES">
                                    🇪🇸 Espagne (+34)
                                </option>
                                <option value="Estonie (+372)" data-tel="+372" data-code="EE">
                                    🇪🇪 Estonie (+372)
                                </option>
                                <option value="État de la Cité du Vatican (+379)" data-tel="+379" data-code="VA">
                                    🇻🇦 État de la Cité du Vatican (+379)
                                </option>
                                <option value="États fédérés de Micronésie (+691)" data-tel="+691" data-code="FM">
                                    🇫🇲 États fédérés de Micronésie (+691)
                                </option>
                                <option value="États-Unis (+1)" data-tel="+1" data-code="US">
                                    🇺🇸 États-Unis (+1)
                                </option>
                                <option value="Éthiopie (+251)" data-tel="+251" data-code="ET">
                                    🇪🇹 Éthiopie (+251)
                                </option>
                                <option value="Fidji (+679)" data-tel="+679" data-code="FJ">
                                    🇫🇯 Fidji (+679)
                                </option>
                                <option value="Finlande (+358)" data-tel="+358" data-code="FI">
                                    🇫🇮 Finlande (+358)
                                </option>
                                <option value="France (+33)" data-tel="+33" data-code="FR" selected="">
                                    🇫🇷 France (+33)
                                </option>
                                <option value="Gabon (+241)" data-tel="+241" data-code="GA">
                                    🇬🇦 Gabon (+241)
                                </option>
                                <option value="Gambie (+220)" data-tel="+220" data-code="GM">
                                    🇬🇲 Gambie (+220)
                                </option>
                                <option value="Ghana (+233)" data-tel="+233" data-code="GH">
                                    🇬🇭 Ghana (+233)
                                </option>
                                <option value="Gibraltar (+350)" data-tel="+350" data-code="GI">
                                    🇬🇮 Gibraltar (+350)
                                </option>
                                <option value="Grenade (+1473)" data-tel="+1473" data-code="GD">
                                    🇬🇩 Grenade (+1473)
                                </option>
                                <option value="Groenland (+299)" data-tel="+299" data-code="GL">
                                    🇬🇱 Groenland (+299)
                                </option>
                                <option value="Grèce (+30)" data-tel="+30" data-code="GR">
                                    🇬🇷 Grèce (+30)
                                </option>
                                <option value="Guadeloupe (+590)" data-tel="+590" data-code="GP">
                                    🇬🇵 Guadeloupe (+590)
                                </option>
                                <option value="Guam (+1671)" data-tel="+1671" data-code="GU">
                                    🇬🇺 Guam (+1671)
                                </option>
                                <option value="Guatemala (+502)" data-tel="+502" data-code="GT">
                                    🇬🇹 Guatemala (+502)
                                </option>
                                <option value="Guernesey (+44)" data-tel="+44" data-code="GG">
                                    🇬🇬 Guernesey (+44)
                                </option>
                                <option value="Guinée (+224)" data-tel="+224" data-code="GN">
                                    🇬🇳 Guinée (+224)
                                </option>
                                <option value="Guinée équatoriale (+240)" data-tel="+240" data-code="GQ">
                                    🇬🇶 Guinée équatoriale (+240)
                                </option>
                                <option value="Guinée-Bissau (+245)" data-tel="+245" data-code="GW">
                                    🇬🇼 Guinée-Bissau (+245)
                                </option>
                                <option value="Guyana (+592)" data-tel="+592" data-code="GY">
                                    🇬🇾 Guyana (+592)
                                </option>
                                <option value="Guyane française (+594)" data-tel="+594" data-code="GF">
                                    🇬🇫 Guyane française (+594)
                                </option>
                                <option value="Géorgie (+995)" data-tel="+995" data-code="GE">
                                    🇬🇪 Géorgie (+995)
                                </option>
                                <option value="Géorgie du Sud et les îles Sandwich du Sud (+500)" data-tel="+500"
                                    data-code="GS">
                                    🇬🇸 Géorgie du Sud et les îles Sandwich du Sud (+500)
                                </option>
                                <option value="Haïti (+509)" data-tel="+509" data-code="HT">
                                    🇭🇹 Haïti (+509)
                                </option>
                                <option value="Honduras (+504)" data-tel="+504" data-code="HN">
                                    🇭🇳 Honduras (+504)
                                </option>
                                <option value="Hongrie (+36)" data-tel="+36" data-code="HU">
                                    🇭🇺 Hongrie (+36)
                                </option>
                                <option value="Île Bouvet (+47)" data-tel="+47" data-code="BV">
                                    🇧🇻 Île Bouvet (+47)
                                </option>
                                <option value="Île Christmas (+61)" data-tel="+61" data-code="CX">
                                    🇨🇽 Île Christmas (+61)
                                </option>
                                <option value="Île Norfolk (+672)" data-tel="+672" data-code="NF">
                                    🇳🇫 Île Norfolk (+672)
                                </option>
                                <option value="Île de Man (+44)" data-tel="+44" data-code="IM">
                                    🇮🇲 Île de Man (+44)
                                </option>
                                <option value="Îles Caïmans (+1345)" data-tel="+1345" data-code="KY">
                                    🇰🇾 Îles Caïmans (+1345)
                                </option>
                                <option value="Îles Cocos - Keeling (+61)" data-tel="+61" data-code="CC">
                                    🇨🇨 Îles Cocos - Keeling (+61)
                                </option>
                                <option value="Îles Cook (+682)" data-tel="+682" data-code="CK">
                                    🇨🇰 Îles Cook (+682)
                                </option>
                                <option value="Îles Féroé (+298)" data-tel="+298" data-code="FO">
                                    🇫🇴 Îles Féroé (+298)
                                </option>
                                <option value="Îles Heard et MacDonald (+577)" data-tel="+577" data-code="HM">
                                    🇭🇲 Îles Heard et MacDonald (+577)
                                </option>
                                <option value="Îles Malouines (+500)" data-tel="+500" data-code="FK">
                                    🇫🇰 Îles Malouines (+500)
                                </option>
                                <option value="Îles Mariannes du Nord (+1670)" data-tel="+1670" data-code="MP">
                                    🇲🇵 Îles Mariannes du Nord (+1670)
                                </option>
                                <option value="Îles Marshall (+692)" data-tel="+692" data-code="MH">
                                    🇲🇭 Îles Marshall (+692)
                                </option>
                                <option value="Îles Mineures Éloignées des États-Unis (+1)" data-tel="+1"
                                    data-code="UM">
                                    🇺🇲 Îles Mineures Éloignées des États-Unis (+1)
                                </option>
                                <option value="Îles Salomon (+677)" data-tel="+677" data-code="SB">
                                    🇸🇧 Îles Salomon (+677)
                                </option>
                                <option value="Îles Turks et Caïques (+1649)" data-tel="+1649" data-code="TC">
                                    🇹🇨 Îles Turks et Caïques (+1649)
                                </option>
                                <option value="Îles Vierges britanniques (+1284)" data-tel="+1284" data-code="VG">
                                    🇻🇬 Îles Vierges britanniques (+1284)
                                </option>
                                <option value="Îles Vierges des États-Unis (+1340)" data-tel="+1340" data-code="VI">
                                    🇻🇮 Îles Vierges des États-Unis (+1340)
                                </option>
                                <option value="Îles Åland (+358)" data-tel="+358" data-code="AX">
                                    🇦🇽 Îles Åland (+358)
                                </option>
                                <option value="Inde (+91)" data-tel="+91" data-code="IN">
                                    🇮🇳 Inde (+91)
                                </option>
                                <option value="Indonésie (+62)" data-tel="+62" data-code="ID">
                                    🇮🇩 Indonésie (+62)
                                </option>
                                <option value="Irak (+964)" data-tel="+964" data-code="IQ">
                                    🇮🇶 Irak (+964)
                                </option>
                                <option value="Iran (+98)" data-tel="+98" data-code="IR">
                                    🇮🇷 Iran (+98)
                                </option>
                                <option value="Irlande (+353)" data-tel="+353" data-code="IE">
                                    🇮🇪 Irlande (+353)
                                </option>
                                <option value="Islande (+354)" data-tel="+354" data-code="IS">
                                    🇮🇸 Islande (+354)
                                </option>
                                <option value="Israël (+972)" data-tel="+972" data-code="IL">
                                    🇮🇱 Israël (+972)
                                </option>
                                <option value="Italie (+39)" data-tel="+39" data-code="IT">
                                    🇮🇹 Italie (+39)
                                </option>
                                <option value="Jamaïque (+1876)" data-tel="+1876" data-code="JM">
                                    🇯🇲 Jamaïque (+1876)
                                </option>
                                <option value="Japon (+81)" data-tel="+81" data-code="JP">
                                    🇯🇵 Japon (+81)
                                </option>
                                <option value="Jersey (+44)" data-tel="+44" data-code="JE">
                                    🇯🇪 Jersey (+44)
                                </option>
                                <option value="Jordanie (+962)" data-tel="+962" data-code="JO">
                                    🇯🇴 Jordanie (+962)
                                </option>
                                <option value="Kazakhstan (+7)" data-tel="+7" data-code="KZ">
                                    🇰🇿 Kazakhstan (+7)
                                </option>
                                <option value="Kenya (+254)" data-tel="+254" data-code="KE">
                                    🇰🇪 Kenya (+254)
                                </option>
                                <option value="Kirghizistan (+996)" data-tel="+996" data-code="KG">
                                    🇰🇬 Kirghizistan (+996)
                                </option>
                                <option value="Kiribati (+686)" data-tel="+686" data-code="KI">
                                    🇰🇮 Kiribati (+686)
                                </option>
                                <option value="Kosovo (+383)" data-tel="+383" data-code="XK">
                                    🇽🇰 Kosovo (+383)
                                </option>
                                <option value="Koweït (+965)" data-tel="+965" data-code="KW">
                                    🇰🇼 Koweït (+965)
                                </option>
                                <option value="Laos (+856)" data-tel="+856" data-code="LA">
                                    🇱🇦 Laos (+856)
                                </option>
                                <option value="Lesotho (+266)" data-tel="+266" data-code="LS">
                                    🇱🇸 Lesotho (+266)
                                </option>
                                <option value="Lettonie (+371)" data-tel="+371" data-code="LV">
                                    🇱🇻 Lettonie (+371)
                                </option>
                                <option value="Liban (+961)" data-tel="+961" data-code="LB">
                                    🇱🇧 Liban (+961)
                                </option>
                                <option value="Libye (+218)" data-tel="+218" data-code="LY">
                                    🇱🇾 Libye (+218)
                                </option>
                                <option value="Libéria (+231)" data-tel="+231" data-code="LR">
                                    🇱🇷 Libéria (+231)
                                </option>
                                <option value="Liechtenstein (+423)" data-tel="+423" data-code="LI">
                                    🇱🇮 Liechtenstein (+423)
                                </option>
                                <option value="Lituanie (+370)" data-tel="+370" data-code="LT">
                                    🇱🇹 Lituanie (+370)
                                </option>
                                <option value="Luxembourg (+352)" data-tel="+352" data-code="LU">
                                    🇱🇺 Luxembourg (+352)
                                </option>
                                <option value="Macédoine (+389)" data-tel="+389" data-code="MK">
                                    🇲🇰 Macédoine (+389)
                                </option>
                                <option value="Madagascar (+261)" data-tel="+261" data-code="MG">
                                    🇲🇬 Madagascar (+261)
                                </option>
                                <option value="Malaisie (+60)" data-tel="+60" data-code="MY">
                                    🇲🇾 Malaisie (+60)
                                </option>
                                <option value="Malawi (+265)" data-tel="+265" data-code="MW">
                                    🇲🇼 Malawi (+265)
                                </option>
                                <option value="Maldives (+960)" data-tel="+960" data-code="MV">
                                    🇲🇻 Maldives (+960)
                                </option>
                                <option value="Mali (+223)" data-tel="+223" data-code="ML">
                                    🇲🇱 Mali (+223)
                                </option>
                                <option value="Malte (+356)" data-tel="+356" data-code="MT">
                                    🇲🇹 Malte (+356)
                                </option>
                                <option value="Maroc (+212)" data-tel="+212" data-code="MA">
                                    🇲🇦 Maroc (+212)
                                </option>
                                <option value="Martinique (+596)" data-tel="+596" data-code="MQ">
                                    🇲🇶 Martinique (+596)
                                </option>
                                <option value="Maurice (+230)" data-tel="+230" data-code="MU">
                                    🇲🇺 Maurice (+230)
                                </option>
                                <option value="Mauritanie (+222)" data-tel="+222" data-code="MR">
                                    🇲🇷 Mauritanie (+222)
                                </option>
                                <option value="Mayotte (+262)" data-tel="+262" data-code="YT">
                                    🇾🇹 Mayotte (+262)
                                </option>
                                <option value="Mexique (+52)" data-tel="+52" data-code="MX">
                                    🇲🇽 Mexique (+52)
                                </option>
                                <option value="Moldavie (+373)" data-tel="+373" data-code="MD">
                                    🇲🇩 Moldavie (+373)
                                </option>
                                <option value="Monaco (+377)" data-tel="+377" data-code="MC">
                                    🇲🇨 Monaco (+377)
                                </option>
                                <option value="Mongolie (+976)" data-tel="+976" data-code="MN">
                                    🇲🇳 Mongolie (+976)
                                </option>
                                <option value="Montserrat (+354)" data-tel="+354" data-code="MS">
                                    🇲🇸 Montserrat (+354)
                                </option>
                                <option value="Monténégro (+382)" data-tel="+382" data-code="ME">
                                    🇲🇪 Monténégro (+382)
                                </option>
                                <option value="Mozambique (+258)" data-tel="+258" data-code="MZ">
                                    🇲🇿 Mozambique (+258)
                                </option>
                                <option value="Myanmar (+95)" data-tel="+95" data-code="MM">
                                    🇲🇲 Myanmar (+95)
                                </option>
                                <option value="Namibie (+264)" data-tel="+264" data-code="NA">
                                    🇳🇦 Namibie (+264)
                                </option>
                                <option value="Nauru (+674)" data-tel="+674" data-code="NR">
                                    🇳🇷 Nauru (+674)
                                </option>
                                <option value="Nicaragua (+505)" data-tel="+505" data-code="NI">
                                    🇳🇮 Nicaragua (+505)
                                </option>
                                <option value="Niger (+227)" data-tel="+227" data-code="NE">
                                    🇳🇪 Niger (+227)
                                </option>
                                <option value="Nigéria (+234)" data-tel="+234" data-code="NG">
                                    🇳🇬 Nigéria (+234)
                                </option>
                                <option value="Niue (+683)" data-tel="+683" data-code="NU">
                                    🇳🇺 Niue (+683)
                                </option>
                                <option value="Norvège (+47)" data-tel="+47" data-code="NO">
                                    🇳🇴 Norvège (+47)
                                </option>
                                <option value="Nouvelle-Calédonie (+687)" data-tel="+687" data-code="NC">
                                    🇳🇨 Nouvelle-Calédonie (+687)
                                </option>
                                <option value="Nouvelle-Zélande (+64)" data-tel="+64" data-code="NZ">
                                    🇳🇿 Nouvelle-Zélande (+64)
                                </option>
                                <option value="Népal (+977)" data-tel="+977" data-code="NP">
                                    🇳🇵 Népal (+977)
                                </option>
                                <option value="Oman (+968)" data-tel="+968" data-code="OM">
                                    🇴🇲 Oman (+968)
                                </option>
                                <option value="Ouganda (+256)" data-tel="+256" data-code="UG">
                                    🇺🇬 Ouganda (+256)
                                </option>
                                <option value="Ouzbékistan (+998)" data-tel="+998" data-code="UZ">
                                    🇺🇿 Ouzbékistan (+998)
                                </option>
                                <option value="Pakistan (+92)" data-tel="+92" data-code="PK">
                                    🇵🇰 Pakistan (+92)
                                </option>
                                <option value="Palaos (+680)" data-tel="+680" data-code="PW">
                                    🇵🇼 Palaos (+680)
                                </option>
                                <option value="Panama (+507)" data-tel="+507" data-code="PA">
                                    🇵🇦 Panama (+507)
                                </option>
                                <option value="Papouasie-Nouvelle-Guinée (+675)" data-tel="+675" data-code="PG">
                                    🇵🇬 Papouasie-Nouvelle-Guinée (+675)
                                </option>
                                <option value="Paraguay (+595)" data-tel="+595" data-code="PY">
                                    🇵🇾 Paraguay (+595)
                                </option>
                                <option value="Pays-Bas (+31)" data-tel="+31" data-code="NL">
                                    🇳🇱 Pays-Bas (+31)
                                </option>
                                <option value="Philippines (+63)" data-tel="+63" data-code="PH">
                                    🇵🇭 Philippines (+63)
                                </option>
                                <option value="Pitcairn (+672)" data-tel="+672" data-code="PN">
                                    🇵🇳 Pitcairn (+672)
                                </option>
                                <option value="Pologne (+48)" data-tel="+48" data-code="PL">
                                    🇵🇱 Pologne (+48)
                                </option>
                                <option value="Polynésie française (+689)" data-tel="+689" data-code="PF">
                                    🇵🇫 Polynésie française (+689)
                                </option>
                                <option value="Porto Rico (+1)" data-tel="+1" data-code="PR">
                                    🇵🇷 Porto Rico (+1)
                                </option>
                                <option value="Portugal (+351)" data-tel="+351" data-code="PT">
                                    🇵🇹 Portugal (+351)
                                </option>
                                <option value="Pérou (+51)" data-tel="+51" data-code="PE">
                                    🇵🇪 Pérou (+51)
                                </option>
                                <option value="Qatar (+974)" data-tel="+974" data-code="QA">
                                    🇶🇦 Qatar (+974)
                                </option>
                                <option value="R.A.S. chinoise de Hong Kong (+852)" data-tel="+852" data-code="HK">
                                    🇭🇰 R.A.S. chinoise de Hong Kong (+852)
                                </option>
                                <option value="R.A.S. chinoise de Macao (+853)" data-tel="+853" data-code="MO">
                                    🇲🇴 R.A.S. chinoise de Macao (+853)
                                </option>
                                <option value="Roumanie (+40)" data-tel="+40" data-code="RO">
                                    🇷🇴 Roumanie (+40)
                                </option>
                                <option value="Royaume-Uni (+44)" data-tel="+44" data-code="GB">
                                    🇬🇧 Royaume-Uni (+44)
                                </option>
                                <option value="Russie (+7)" data-tel="+7" data-code="RU">
                                    🇷🇺 Russie (+7)
                                </option>
                                <option value="Rwanda (+250)" data-tel="+250" data-code="RW">
                                    🇷🇼 Rwanda (+250)
                                </option>
                                <option value="République centrafricaine (+236)" data-tel="+236" data-code="CF">
                                    🇨🇫 République centrafricaine (+236)
                                </option>
                                <option value="République dominicaine (+1)" data-tel="+1" data-code="DO">
                                    🇩🇴 République dominicaine (+1)
                                </option>
                                <option value="République démocratique du Congo (+243)" data-tel="+243" data-code="CD">
                                    🇨🇩 République démocratique du Congo (+243)
                                </option>
                                <option value="République tchèque (+420)" data-tel="+420" data-code="CZ">
                                    🇨🇿 République tchèque (+420)
                                </option>
                                <option value="Réunion (+262)" data-tel="+262" data-code="RE">
                                    🇷🇪 Réunion (+262)
                                </option>
                                <option value="Sahara occidental (+212)" data-tel="+212" data-code="EH">
                                    🇪🇭 Sahara occidental (+212)
                                </option>
                                <option value="Saint-Barthélémy (+590)" data-tel="+590" data-code="BL">
                                    🇧🇱 Saint-Barthélémy (+590)
                                </option>
                                <option value="Saint-Kitts-et-Nevis (+1869)" data-tel="+1869" data-code="KN">
                                    🇰🇳 Saint-Kitts-et-Nevis (+1869)
                                </option>
                                <option value="Saint-Marin (+378)" data-tel="+378" data-code="SM">
                                    🇸🇲 Saint-Marin (+378)
                                </option>
                                <option value="Saint-Martin (+590)" data-tel="+590" data-code="MF">
                                    🇲🇫 Saint-Martin (+590)
                                </option>
                                <option value="Saint-Martin (+1721)" data-tel="+1721" data-code="SX">
                                    🇸🇽 Saint-Martin (+1721)
                                </option>
                                <option value="Saint-Pierre-et-Miquelon (+508)" data-tel="+508" data-code="PM">
                                    🇵🇲 Saint-Pierre-et-Miquelon (+508)
                                </option>
                                <option value="Saint-Vincent-et-les Grenadines (+1784)" data-tel="+1784" data-code="VC">
                                    🇻🇨 Saint-Vincent-et-les Grenadines (+1784)
                                </option>
                                <option value="Sainte-Hélène (+290)" data-tel="+290" data-code="SH">
                                    🇸🇭 Sainte-Hélène (+290)
                                </option>
                                <option value="Sainte-Lucie (+358)" data-tel="+358" data-code="LC">
                                    🇱🇨 Sainte-Lucie (+358)
                                </option>
                                <option value="Samoa (+685)" data-tel="+685" data-code="WS">
                                    🇼🇸 Samoa (+685)
                                </option>
                                <option value="Samoa américaines (+1684)" data-tel="+1684" data-code="AS">
                                    🇦🇸 Samoa américaines (+1684)
                                </option>
                                <option value="Sao Tomé-et-Principe (+239)" data-tel="+239" data-code="ST">
                                    🇸🇹 Sao Tomé-et-Principe (+239)
                                </option>
                                <option value="Serbie (+381)" data-tel="+381" data-code="RS">
                                    🇷🇸 Serbie (+381)
                                </option>
                                <option value="Seychelles (+248)" data-tel="+248" data-code="SC">
                                    🇸🇨 Seychelles (+248)
                                </option>
                                <option value="Sierra Leone (+232)" data-tel="+232" data-code="SL">
                                    🇸🇱 Sierra Leone (+232)
                                </option>
                                <option value="Singapour (+65)" data-tel="+65" data-code="SG">
                                    🇸🇬 Singapour (+65)
                                </option>
                                <option value="Slovaquie (+421)" data-tel="+421" data-code="SK">
                                    🇸🇰 Slovaquie (+421)
                                </option>
                                <option value="Slovénie (+386)" data-tel="+386" data-code="SI">
                                    🇸🇮 Slovénie (+386)
                                </option>
                                <option value="Somalie (+252)" data-tel="+252" data-code="SO">
                                    🇸🇴 Somalie (+252)
                                </option>
                                <option value="Soudan (+249)" data-tel="+249" data-code="SD">
                                    🇸🇩 Soudan (+249)
                                </option>
                                <option value="Soudan du sud (+211)" data-tel="+211" data-code="SS">
                                    🇸🇸 Soudan du sud (+211)
                                </option>
                                <option value="Sri Lanka (+94)" data-tel="+94" data-code="LK">
                                    🇱🇰 Sri Lanka (+94)
                                </option>
                                <option value="Suisse (+41)" data-tel="+41" data-code="CH">
                                    🇨🇭 Suisse (+41)
                                </option>
                                <option value="Suriname (+597)" data-tel="+597" data-code="SR">
                                    🇸🇷 Suriname (+597)
                                </option>
                                <option value="Suède (+46)" data-tel="+46" data-code="SE">
                                    🇸🇪 Suède (+46)
                                </option>
                                <option value="Svalbard et Île Jan Mayen (+47)" data-tel="+47" data-code="SJ">
                                    🇸🇯 Svalbard et Île Jan Mayen (+47)
                                </option>
                                <option value="Swaziland (+268)" data-tel="+268" data-code="SZ">
                                    🇸🇿 Swaziland (+268)
                                </option>
                                <option value="Syrie (+963)" data-tel="+963" data-code="SY">
                                    🇸🇾 Syrie (+963)
                                </option>
                                <option value="Sénégal (+221)" data-tel="+221" data-code="SN">
                                    🇸🇳 Sénégal (+221)
                                </option>
                                <option value="Tadjikistan (+992)" data-tel="+992" data-code="TJ">
                                    🇹🇯 Tadjikistan (+992)
                                </option>
                                <option value="Tanzanie (+255)" data-tel="+255" data-code="TZ">
                                    🇹🇿 Tanzanie (+255)
                                </option>
                                <option value="Taïwan (+886)" data-tel="+886" data-code="TW">
                                    🇹🇼 Taïwan (+886)
                                </option>
                                <option value="Tchad (+235)" data-tel="+235" data-code="TD">
                                    🇹🇩 Tchad (+235)
                                </option>
                                <option value="Terres australes françaises (+262)" data-tel="+262" data-code="TF">
                                    🇹🇫 Terres australes françaises (+262)
                                </option>
                                <option value="Territoire britannique de l'océan Indien (+246)" data-tel="+246"
                                    data-code="IO">
                                    🇮🇴 Territoire britannique de l'océan Indien (+246)
                                </option>
                                <option value="Territoire palestinien (+970)" data-tel="+970" data-code="PS">
                                    🇵🇸 Territoire palestinien (+970)
                                </option>
                                <option value="Thaïlande (+66)" data-tel="+66" data-code="TH">
                                    🇹🇭 Thaïlande (+66)
                                </option>
                                <option value="Timor oriental (+670)" data-tel="+670" data-code="TL">
                                    🇹🇱 Timor oriental (+670)
                                </option>
                                <option value="Togo (+228)" data-tel="+228" data-code="TG">
                                    🇹🇬 Togo (+228)
                                </option>
                                <option value="Tokelau (+690)" data-tel="+690" data-code="TK">
                                    🇹🇰 Tokelau (+690)
                                </option>
                                <option value="Tonga (+676)" data-tel="+676" data-code="TO">
                                    🇹🇴 Tonga (+676)
                                </option>
                                <option value="Trinité-et-Tobago (+1868)" data-tel="+1868" data-code="TT">
                                    🇹🇹 Trinité-et-Tobago (+1868)
                                </option>
                                <option value="Tunisie (+216)" data-tel="+216" data-code="TN">
                                    🇹🇳 Tunisie (+216)
                                </option>
                                <option value="Turkménistan (+993)" data-tel="+993" data-code="TM">
                                    🇹🇲 Turkménistan (+993)
                                </option>
                                <option value="Turquie (+90)" data-tel="+90" data-code="TR">
                                    🇹🇷 Turquie (+90)
                                </option>
                                <option value="Tuvalu (+688)" data-tel="+688" data-code="TV">
                                    🇹🇻 Tuvalu (+688)
                                </option>
                                <option value="Ukraine (+380)" data-tel="+380" data-code="UA">
                                    🇺🇦 Ukraine (+380)
                                </option>
                                <option value="Uruguay (+598)" data-tel="+598" data-code="UY">
                                    🇺🇾 Uruguay (+598)
                                </option>
                                <option value="Vanuatu (+678)" data-tel="+678" data-code="VU">
                                    🇻🇺 Vanuatu (+678)
                                </option>
                                <option value="Venezuela (+58)" data-tel="+58" data-code="VE">
                                    🇻🇪 Venezuela (+58)
                                </option>
                                <option value="Viêt Nam (+84)" data-tel="+84" data-code="VN">
                                    🇻🇳 Viêt Nam (+84)
                                </option>
                                <option value="Wallis-et-Futuna (+681)" data-tel="+681" data-code="WF">
                                    🇼🇫 Wallis-et-Futuna (+681)
                                </option>
                                <option value="Yémen (+967)" data-tel="+967" data-code="YE">
                                    🇾🇪 Yémen (+967)
                                </option>
                                <option value="Zambie (+260)" data-tel="+260" data-code="ZM">
                                    🇿🇲 Zambie (+260)
                                </option>
                                <option value="Zimbabwe (+263)" data-tel="+263" data-code="ZW">
                                    🇿🇼 Zimbabwe (+263)
                                </option>
                            </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Adresse <span class="required-star">*</span></label>
                            <input type="text" name="address" class="form-control form-control-modern" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-modern">Devise <span class="required-star">*</span></label>
                                <select name="devise" id="devise" class="form-select form-select-modern" required="">
                                <option value="" disabled="" selected="">Devise disponible...</option>
                                <optgroup label="Europe">
                                    <option value="€">Euro (EUR)</option>
                                    <option value="£">Livre sterling (GBP)</option>
                                    <option value="CHF">Franc suisse (CHF)</option>
                                    <option value="NIO">Cordaba (NIO)</option>
                                    <option value="kr">Couronne norvégienne (NOK)</option>
                                    <option value="kr">Couronne suédoise (SEK)</option>
                                    <option value="krD">Couronne danoise (DKK)</option>
                                    <option value="zł">Złoty polonais (PLN)</option>
                                    <option value="Kč">Couronne tchèque (CZK)</option>
                                    <option value="Ft">Forint hongrois (HUF)</option>
                                    <option value="XPF">Franc Pacifique (XPF)</option>
                                    <option value="RON">Leu roumain (RON)</option>
                                    <option value="лв">Lev bulgare (BGN)</option>
                                    <option value="kn">Kuna croate (HRK)</option>
                                    <option value="дин">Dinar serbe (RSD)</option>
                                    <option value="£">Livre sterling de Jersey (JEP)</option>
                                    <option value="MDL">Leu moldave (MDL)</option>
                                    <option value="ден">Denier macédonien (MKD)</option>
                                    <option value="MK">Mark convertible de Bosnie-Herzégovine (MK)</option>
                                </optgroup>
                                <optgroup label="Asie">
                                    <option value="¥">Yen japonais (JPY)</option>
                                    <option value="￥">Yuan chinois (CNY)</option>
                                    <option value="₩">Won sud-coréen (KRW)</option>
                                    <option value="₹">Roupie indienne (INR)</option>
                                    <option value="Rp">Rupiah indonésienne (IDR)</option>
                                    <option value="RM">Ringgit malaisien (MYR)</option>
                                    <option value="₮">Tugrik Mongol (MNT)</option>
                                    <option value="₱">Peso philippin (PHP)</option>
                                    <option value="S$">Dollar de Singapour (SGD)</option>
                                    <option value="HKD">Dollar de Hong Kong (HKD)</option>
                                    <option value="AED">Dirham arabes (AED)</option>
                                    <option value="฿">Baht thaïlandais (THB)</option>
                                    <option value="₪">Shekel israélien (ILS)</option>
                                    <option value="JOD">Dinar jordanien (JOD)</option>
                                    <option value="PEN">Soles (PEN)</option>
                                    <option value="KGS">Som (KGS)</option>
                                    <option value="KHR">Riel cambodgien (KHR)</option>
                                    <option value="KWD">Dinar koweïtien (KWD)</option>
                                    <option value="Ks">Kyat (MMK)</option>
                                    <option value="P">Pataca de Macao (MOP)</option>
                                    <option value="MVR">Rufiyaa maldivien (MVR)</option>
                                    <option value="Rs">Roupie népalais (NPR)</option>
                                    <option value="OMR">Rial omani (OMR)</option>
                                    <option value="QAR">Rial qatarien (QAR)</option>
                                    <option value="₽">Rouble russe (RUB)</option>
                                    <option value="SAR">Rial saoudien (SAR)</option>
                                    <option value="£S">Livre syrien (SYP)</option>
                                    <option value="ЅМ">Somoni (TJS)</option>
                                    <option value="₺">Livre turque (TRY)</option>
                                    <option value="YER">Rial yéménite (YER)</option>
                                </optgroup>
                                <optgroup label="Amérique du Nord">
                                    <option value="₡">Colón costaricien (CRC)</option>
                                    <option value="$">Dollar américain (USD)</option>
                                    <option value="$ CA">Dollar canadien (CAD)</option>
                                    <option value="RD$"> Peso dominicain (DOP)</option>
                                    <option value="$MXN">Peso mexicain (MXN)</option>
                                    <option value="C$">Oro de cordoue (NIO)</option>
                                    <option value="฿">Balboa panaméen (PAB)</option>
                                    <option value="Qtz">Quetzal (Qtz)</option>
                                </optgroup>
                                <optgroup label="Amérique du Sud">
                                    <option value="R$">Réai brésilien (BRL)</option>
                                    <option value="$">Peso argentin (ARS)</option>
                                    <option value="Bs">Peso boliviano (BOB)</option>
                                    <option value="$">Peso chilien (CLP)</option>
                                    <option value="COL$">Peso colombien (COP)</option>
                                    <option value="S/">Sol péruvien (PEN)</option>
                                    <option value="$U">Peso uruguayen (UYU)</option>
                                    <option value="₲">Guaraní (PYG)</option>
                                </optgroup>
                                <optgroup label="Afrique">
                                    <option value="R">Rand sud-africain (ZAR)</option>
                                    <option value="E£">Livre égyptienne (EGP)</option>
                                    <option value="DA">Dinar algérien (DZD)</option>
                                    <option value="DT">Dinar tunisien (TND)</option>
                                    <option value="DH">Dirham marocain (MAD)</option>
                                    <option value="₦">Nigerian naira (NGN)</option>
                                    <option value="Rs">Roupie mauricienne (MUR)</option>
                                    <option value="KSh">Shilling kényan (KES)</option>
                                    <option value="₵">Cedi ghanéen (GHS)</option>
                                    <option value="XOF">Franc CFA (XOF)</option>
                                    <option value="XAF">Franc CFA (XAF)</option>
                                    <option value="FC">Franc comorien (KMF)</option>
                                    <option value="Ar">Ariary malgache (MGA)</option>
                                    <option value="UM">Ouguiya mauritanien (MRO)</option>
                                    <option value="MK">Kwacha malawite (MWK)</option>
                                    <option value="FRw">Franc rwandais (RWF)</option>
                                </optgroup>
                                <optgroup label="Océanie">
                                    <option value="AU$">Dollar australien (AUD)</option>
                                    <option value="FJ$">Dollar fidjien (FJD)</option>
                                    <option value="$NZ">Dollar néo-zélandais (NZD)</option>
                                    <option value="K">Kina (PGK)</option>
                                </optgroup>
                            </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-modern">Langue <span class="required-star">*</span></label>
                                <select name="lang" class="form-select form-select-modern" required>
                                    <option disabled selected>Langue</option>
                                    <option value="af">Afrikaans</option>
                            <option value="sq">Albanais</option>
                            <option value="de">Allemand</option>
                            <option value="am">Amharique</option>
                            <option value="en">Anglais</option>
                            <option value="ar">Arabe</option>
                            <option value="hy">Arménien</option>
                            <option value="az">Azéri</option>
                            <option value="eu">Basque</option>
                            <option value="bn">Bengali</option>
                            <option value="be">Biélorusse</option>
                            <option value="my">Birman</option>
                            <option value="bs">Bosniaque</option>
                            <option value="bg">Bulgare</option>
                            <option value="ca">Catalan</option>
                            <option value="ceb">Cebuano</option>
                            <option value="ny">Chichewa</option>
                            <option value="zh-CN">Chinois (simplifié)</option>
                            <option value="zh-TW">Chinois (traditionnel)</option>
                            <option value="si">Cingalais</option>
                            <option value="ko">Coréen</option>
                            <option value="co">Corse</option>
                            <option value="ht">Créole haïtien</option>
                            <option value="hr">Croate</option>
                            <option value="da">Danois</option>
                            <option value="es">Espagnol</option>
                            <option value="eo">Espéranto</option>
                            <option value="et">Estonien</option>
                            <option value="fr">Français</option>
                            <option value="fi">Finnois</option>
                            <option value="fy">Frison</option>
                            <option value="gd">Gaélique (Écosse)</option>
                            <option value="gl">Galicien</option>
                            <option value="cy">Gallois</option>
                            <option value="ka">Géorgien</option>
                            <option value="el">Grec</option>
                            <option value="gu">Gujarati</option>
                            <option value="ha">Haoussa</option>
                            <option value="haw">Hawaïen</option>
                            <option value="iw">Hébreu</option>
                            <option value="hi">Hindi</option>
                            <option value="hmn">Hmong</option>
                            <option value="hu">Hongrois</option>
                            <option value="ig">Igbo</option>
                            <option value="id">Indonésien</option>
                            <option value="ga">Irlandais</option>
                            <option value="is">Islandais</option>
                            <option value="it">Italien</option>
                            <option value="ja">Japonais</option>
                            <option value="jw">Javanais</option>
                            <option value="kn">Kannada</option>
                            <option value="kk">Kazakh</option>
                            <option value="km">Khmer</option>
                            <option value="rw">Kinyarwanda</option>
                            <option value="ky">Kirghiz</option>
                            <option value="ku">Kurde</option>
                            <option value="lo">Laotien</option>
                            <option value="la">Latin</option>
                            <option value="lv">Letton</option>
                            <option value="lt">Lituanien</option>
                            <option value="lb">Luxembourgeois</option>
                            <option value="mk">Macédonien</option>
                            <option value="ms">Malaisien</option>
                            <option value="ml">Malayalam</option>
                            <option value="mg">Malgache</option>
                            <option value="mt">Maltais</option>
                            <option value="mi">Maori</option>
                            <option value="mr">Marathi</option>
                            <option value="mn">Mongol</option>
                            <option value="nl">Néerlandais</option>
                            <option value="ne">Népalais</option>
                            <option value="no">Norvégien</option>
                            <option value="or">Odia (oriya)</option>
                            <option value="ug">Ouïgour</option>
                            <option value="uz">Ouzbek</option>
                            <option value="ps">Pachtô</option>
                            <option value="pa">Panjabi</option>
                            <option value="fa">Persan</option>
                            <option value="tl">Philippin</option>
                            <option value="pl">Polonais</option>
                            <option value="pt">Portugais</option>
                            <option value="ro">Roumain</option>
                            <option value="ru">Russe</option>
                            <option value="sm">Samoan</option>
                            <option value="sr">Serbe</option>
                            <option value="st">Sesotho</option>
                            <option value="sn">Shona</option>
                            <option value="sd">Sindhî</option>
                            <option value="sk">Slovaque</option>
                            <option value="sl">Slovène</option>
                            <option value="so">Somali</option>
                            <option value="su">Soundanais</option>
                            <option value="sv">Suédois</option>
                            <option value="sw">Swahili</option>
                            <option value="tg">Tadjik</option>
                            <option value="ta">Tamoul</option>
                            <option value="tt">Tatar</option>
                            <option value="cs">Tchèque</option>
                            <option value="te">Telugu</option>
                            <option value="th">Thaï</option>
                            <option value="tr">Turc</option>
                            <option value="tk">Turkmène</option>
                            <option value="uk">Ukrainien</option>
                            <option value="ur">Urdu</option>
                            <option value="vi">Vietnamien</option>
                            <option value="xh">Xhosa</option>
                            <option value="yi">Yiddish</option>
                            <option value="yo">Yorouba</option>
                            <option value="zu">Zoulou</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label-modern">Type <span class="required-star">*</span></label>
                                <select name="account_type" class="form-select form-select-modern" required>
                                    <option disabled selected>Type</option>
                                    <option>Professionnel</option>
                                    <option>Standard</option>
                                    <option>Prépayé</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-modern">Statut <span class="required-star">*</span></label>
                                <select name="account_status" class="form-select form-select-modern" required>
                                    <option disabled selected>Statut</option>
                                    <option>Activé</option>
                                    <option>Examen</option>
                                    <option>Suspendu</option>
                                    <option>Bloqué</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Solde à créditer <span class="required-star">*</span></label>
                            <input type="number" step="0.01" name="account_balance" class="form-control form-control-modern" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Transferts supportés <span class="required-star">*</span></label>
                            <input type="text" name="transfer_supported" class="form-control form-control-modern" required>
                            <small class="text-muted"><i class="fas fa-info-circle"></i> SEPA, Différé , Permanent ou SWIFT</small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label-modern">% début <span class="required-star">*</span></label>
                                <input type="number" min="0" max="100" name="start_percentage" class="form-control form-control-modern" value="0" required>
                                <small class="text-muted">Mettre 0</small>
                            </div>
                            <div class="col-6">
                                <label class="form-label-modern">% fin <span class="required-star">*</span></label>
                                <input type="number" min="1" max="100" name="end_percentage" class="form-control form-control-modern" required>
                                <small class="text-muted">2-99 = échec, 100 = succès</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label-modern">Message à afficher <span class="required-star">*</span></label>
                            <textarea name="failure_message" rows="2" class="form-control form-control-modern" placeholder="Message à affiché à la fin du virement..." required></textarea>
                        </div>

                        <div class="section-divider"></div>

                        <div class="mb-3">
                            <label class="form-label-modern"><i class="fas fa-envelope"></i> Alerte par e-mail (Obligatoire)</label>
                            <div class="alert-modern alert-info">
                                <i class="fas fa-check-circle me-2"></i>Les alertes par e-mail sont envoyées à l'adresse e-mail du client.<br>
                                <span style="font-weight:600;color:#1b5e20"><i class="fas fa-file-invoice"></i> Un bordereau est également envoyé au client après chaque virement effectué avec succès.</span><br>
                                <strong>NB :</strong> Les messages d'alerte par e-mail sont gratuits et sont intégrés par défaut.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-modern"><i class="fas fa-sms"></i> Alerte par SMS (Facultatif)</label>
                            <div class="form-check form-switch form-switch-modern d-flex align-items-center gap-2 mb-2">
                                <input class="form-check-input" type="checkbox" id="alertSmsToggle" name="alert_sms" value="1"
                                    role="switch"
                                    aria-label="Alerte par SMS"
                                    aria-checked="{{ old('alert_sms') ? 'true' : 'false' }}"
                                    @checked(old('alert_sms'))>
                                <label class="form-check-label form-label-modern mb-0" for="alertSmsToggle">Activer l'alerte SMS d'ouverture</label>
                            </div>
                            <div class="alert-modern alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Un seul SMS sera envoyé :</strong> le message d'ouverture du compte.<br>
                                Tous les autres messages (virements, validation, etc.) seront uniquement par e-mail.<br>
                                <strong>Coût :</strong> 1 000 Crédits (envoi unique).
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="createCompteBtn" class="btn btn-modern-primary">
                                <!-- NOUVEAU TEXTE DU BOUTON -->
                                <i class="fas fa-plus-circle me-2"></i>Créer l'accès client (4 000 Crédits)
                            </button>
                        </div>
                    </form>

                    <script>
                        (function(){
                            var toggle = document.getElementById('alertSmsToggle');
                            if(!toggle) return;
                            // Sync aria-checked on load
                            toggle.setAttribute('aria-checked', toggle.checked ? 'true' : 'false');
                            // Update aria-checked on change
                            toggle.addEventListener('change', function(e){
                                toggle.setAttribute('aria-checked', toggle.checked ? 'true' : 'false');
                            });
                            // Improve keyboard focus outline for browsers not supporting :focus-visible
                            toggle.addEventListener('focus', function(){
                                toggle.classList.add('js-focus');
                            });
                            toggle.addEventListener('blur', function(){
                                toggle.classList.remove('js-focus');
                            });
                        })();
                    </script>
                </div>
            </div>
        </div>

        {{-- COLONNE DROITE : COMPTES EXISTANTS --}}
        <div class="col-lg-6 mb-4">
            <div class="modern-card">
                <div class="modern-card-header">
                    <h4><i class="fas fa-list"></i> Mes comptes créés</h4>
                </div>
                <div class="modern-card-body">
                    @forelse($comptes as $compte)
                        <div class="compte-item">
                            <div class="compte-info">
                                <div class="compte-name">{{ $compte->nom }} {{ $compte->prenom }}</div>
                                <div class="compte-balance">
                                    <i class="fas fa-wallet me-1"></i>{{ number_format($compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}
                                </div>
                                <span class="status-badge-modern
                                    @if($compte->account_status === 'Activé') bg-success
                                    @elseif($compte->account_status === 'Examen') bg-primary
                                    @elseif($compte->account_status === 'Suspendu') bg-warning
                                    @else bg-danger @endif">
                                    {{ $compte->account_status }}
                                </span>
                            </div>
                            <button class="btn btn-details-modern"
                                    data-bs-toggle="modal"
                                    data-bs-target="#infoModal"
                                    data-nom="{{ $compte->nom.' '.$compte->prenom }}"
                                    data-email="{{ $compte->email }}"
                                    data-phone="{{ $compte->phone_number }}"
                                    data-country="{{ $compte->country }}"
                                    data-address="{{ $compte->address }}"
                                    data-balance="{{ number_format($compte->account_balance,2,',',' ') }}"
                                    data-devise="{{ $compte->devise }}"
                                    data-account-type="{{ $compte->account_type }}"
                                    data-account-status="{{ $compte->account_status }}"
                                    data-transfer-supported="{{ $compte->transfer_supported }}"
                                    data-numerocompte="{{ $compte->numerocompte }}"
                                    data-start-percentage="{{ $compte->start_percentage }}"
                                    data-end-percentage="{{ $compte->end_percentage }}"
                                    data-compte-id="{{ $compte->id }}"
                                    data-delete-url="{{ $compte->is_default ? '' : route('account.destroy', $compte->id) }}"
                                    data-is-default="{{ $compte->is_default ? '1' : '0' }}"
                                    data-password="{{ $compte->password }}"
                                    data-code-virement="{{ $compte->code_virement }}"
                                    data-failure-message="{{ $compte->failure_message }}"
                                    data-alert-email="{{ $compte->alert_email ? '1' : '0' }}"
                                    data-alert-sms="{{ $compte->alert_sms ? '1' : '0' }}"
                                    data-code-used="{{ !empty($compte->has_used_unlock_code) ? '1' : '0' }}"
                                    data-creation-cost="{{ 3500 + ($compte->alert_sms ? 1000 : 0) }}"
                                    data-created-at="{{ optional($compte->created_at)->toIso8601String() }}"
                                    data-has-completed-transfer="0">
                                <i class="fas fa-info-circle me-1"></i>Détails
                            </button>
                        </div>
                    @empty
                        <div class="text-center text-muted">Aucun compte pour l’instant.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- FIN CRÉER UN COMPTE -->
<style>
                .copy-icon {
                    margin-left: 10px;
                    cursor: pointer;
                    color: #007BFF;
                    transition: color 0.3s ease;
                }

                .copy-icon.copied {
                    color: #28A745;
                }

                .modaldetail p {
                    font-size: 1rem;
                }

                .carddetail {
                    background-color: #d8dcdd;
                    padding: 15px 15px 0 15px;
                    max-width: 90%;
                    margin: auto;
                    margin-top: -10px;
                    text-transform: lowercase
                }

                .client-access-summary {
                    background-color: #f6f9fc;
                    border-radius: 0.75rem;
                    padding: 1rem 1.25rem;
                    margin-top: 1.5rem;
                    box-shadow: inset 0 0 0 1px rgba(13, 110, 253, 0.1);
                }

                .client-summary-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 0.65rem;
                    font-weight: 600;
                    color: #1d3557;
                    gap: 1rem;
                }

                .client-summary-row:last-child {
                    margin-bottom: 0;
                }

                .client-summary-label {
                    flex: 1;
                    font-size: 0.9rem;
                }

                .client-summary-value {
                    font-size: 0.9rem;
                    font-weight: 500;
                    color: #12263a;
                }

                .detail-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.4rem;
                    border-radius: 999px;
                    font-size: 0.8rem;
                    font-weight: 600;
                    padding: 0.2rem 0.85rem;
                    text-transform: uppercase;
                    letter-spacing: 0.02em;
                    border: 1px solid transparent;
                }

                .detail-badge--usage {
                    background-color: #e6f4ff;
                    color: #0b5394;
                }

                .detail-badge--usage-yes {
                    background-color: #d1f5e0;
                    border-color: transparent;
                    color: #0a7b34;
                }

                .detail-badge--usage-no {
                    background-color: #ffe0e0;
                    border-color: transparent;
                    color: #b7322c;
                }

                .status-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.4rem;
                    border-radius: 999px;
                    font-size: 0.8rem;
                    font-weight: 600;
                    padding: 0.2rem 0.85rem;
                    text-transform: uppercase;
                }

                .status-badge--active {
                    background-color: #d1f5e0;
                    color: #0a7b34;
                }

                .status-badge--inactive {
                    background-color: #ffe5e5;
                    color: #b7322c;
                }

                .state-badge {
                    display: inline-flex;
                    align-items: center;
                    gap: 0.35rem;
                    border-radius: 999px;
                    padding: 0.25rem 0.9rem;
                    font-size: 0.82rem;
                    font-weight: 600;
                }

                .state-badge--active {
                    background-color: #d1f5e0;
                    color: #0a7b34;
                }

                .state-badge--warning {
                    background-color: #fff4d6;
                    color: #ad7a00;
                }

                .state-badge--danger {
                    background-color: #ffe5e5;
                    color: #b7322c;
                }

                .state-badge--info {
                    background-color: #e6f4ff;
                    color: #0b5394;
                }
            </style>
            <style>
                /* ===== MODERN MODAL STYLES ===== */
                .modern-modal {
                    border: none;
                    border-radius: 16px;
                    overflow: hidden;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                }

                .modern-modal-header {
                    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                    padding: 18px 24px; /* encore plus grand pour un header bien visible */
                    border: none;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    min-height: 72px; /* hauteur accrue pour plus de présence */
                    box-shadow: 0 6px 18px rgba(13, 110, 253, 0.18);
                }

                .modern-modal-header .btn-close {
                    filter: brightness(0) invert(1);
                    opacity: 1;
                    width: 1.9rem;
                    height: 1.9rem;
                    font-size: 1.3rem;
                }

                /* Overlay de chargement global et styles spinner */
                .loading-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.8);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    backdrop-filter: blur(2px);
                }

                .spinner-border {
                    width: 3rem;
                    height: 3rem;
                    border-width: 0.3em;
                }

                .modern-modal-header .btn-close:hover {
                    opacity: 0.75;
                }

                .modern-modal-title {
                    color: #ffffff;
                    font-size: 1.2rem; /* augmenté pour une meilleure lisibilité */
                    font-weight: 700;
                    margin: 0;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                }
                .modern-modal-title .fa {
                    font-size: 1.25rem;
                }

                .modern-modal-body {
                    padding: 12px; /* padding réduit pour compacter le contenu */
                    background: #f8f9fa;
                    max-height: 65vh;
                    overflow-y: auto;
                }

                .modern-section {
                    background: #ffffff;
                    border-radius: 10px;
                    padding: 16px;
                    margin-bottom: 16px;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                }

                .modern-section-title {
                    color: #0d6efd;
                    font-size: 1rem;
                    font-weight: 600;
                    margin-bottom: 14px;
                    padding-bottom: 10px;
                    border-bottom: 2px solid #e9ecef;
                    display: flex;
                    align-items: center;
                }

                /* Profile Photo Section */
                .profile-photo-container {
                    display: flex;
                    gap: 16px;
                    align-items: flex-start;
                    padding: 14px;
                    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                    border-radius: 10px;
                }

                .profile-photo-wrapper {
                    flex-shrink: 0;
                }

                .profile-photo {
                    width: 70px;
                    height: 70px;
                    border-radius: 50%;
                    object-fit: cover;
                    border: 3px solid #ffffff;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
                }

                .profile-upload-section {
                    flex: 1;
                }

                .upload-form {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                }

                .upload-label {
                    display: inline-flex;
                    align-items: center;
                    padding: 8px 16px;
                    background: #0d6efd;
                    color: white;
                    border-radius: 6px;
                    cursor: pointer;
                    font-size: 0.85rem;
                    font-weight: 500;
                    transition: all 0.3s ease;
                    width: fit-content;
                }

                .upload-label:hover {
                    background: #0a58ca;
                    transform: translateY(-2px);
                    box-shadow: 0 3px 10px rgba(13, 110, 253, 0.3);
                }

                .upload-input {
                    display: none;
                }

                .file-name {
                    font-size: 0.8rem;
                    color: #6c757d;
                    font-style: italic;
                }

                .btn-upload {
                    padding: 8px 18px;
                    background: linear-gradient(135deg, #28a745 0%, #20873a 100%);
                    color: white;
                    border: none;
                    border-radius: 6px;
                    font-size: 0.85rem;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    width: fit-content;
                }

                .btn-upload:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
                }

                .upload-hint {
                    color: #6c757d;
                    font-size: 0.75rem;
                    margin-top: 2px;
                    display: block;
                }

                /* Info Card */
                .info-card {
                    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                    border-radius: 8px;
                    padding: 12px 16px;
                    border-left: 3px solid #0d6efd;
                }

                .info-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 10px;
                }

                .info-label {
                    color: #6c757d;
                    font-weight: 600;
                    font-size: 0.85rem;
                }

                .info-value {
                    color: #212529;
                    font-weight: 500;
                    font-size: 0.9rem;
                }

                /* Credentials Card */
                .credentials-card {
                    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
                    border-radius: 10px;
                    padding: 16px;
                    color: white;
                }

                .credential-item {
                    padding: 12px 0;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                }

                .credential-item:last-of-type {
                    border-bottom: none;
                }

                .credential-label {
                    font-size: 0.8rem;
                    color: rgba(255, 255, 255, 0.7);
                    margin-bottom: 6px;
                    font-style: italic;
                }

                .credential-value {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    background: rgba(255, 255, 255, 0.1);
                    padding: 10px 12px;
                    border-radius: 6px;
                }

                .credential-text {
                    flex: 1;
                    font-family: 'Courier New', monospace;
                    font-size: 0.9rem;
                    color: #ffffff;
                }

                .btn-copy {
                    background: rgba(255, 255, 255, 0.2);
                    border: none;
                    padding: 6px 10px;
                    border-radius: 5px;
                    color: white;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    font-size: 0.85rem;
                }

                .btn-copy:hover {
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(1.1);
                }

                .access-link {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 10px 18px;
                    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                    color: white;
                    text-decoration: none;
                    border-radius: 6px;
                    font-size: 0.9rem;
                    font-weight: 600;
                    margin-top: 12px;
                    transition: all 0.3s ease;
                    text-transform: lowercase;
                }

                .access-link:hover {
                    color: white;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
                }

                /* Action Buttons */
                .action-buttons-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 12px;
                    margin-top: 14px;
                }

                .btn-action {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 10px 16px;
                    border: none;
                    border-radius: 8px;
                    font-weight: 600;
                    font-size: 0.85rem;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    color: white;
                }

                .btn-action-primary {
                    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                }

                .btn-action-primary:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
                }

                .btn-action-warning {
                    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
                }

                .btn-action-warning:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
                }

                /* Info Grid */
                .info-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 12px;
                }

                .info-item {
                    display: flex;
                    align-items: flex-start;
                    gap: 10px;
                    padding: 12px;
                    background: white;
                    border-radius: 8px;
                    border-left: 3px solid #0d6efd;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
                }

                .info-icon {
                    color: #0d6efd;
                    font-size: 1.1rem;
                    margin-top: 2px;
                }

                .info-item-label {
                    font-size: 0.8rem;
                    color: #6c757d;
                    font-weight: 600;
                    margin-bottom: 3px;
                }

                .info-item-value {
                    font-size: 0.85rem;
                    color: #212529;
                    font-weight: 500;
                }

                /* Account Overview */
                .account-overview {
                    display: flex;
                    flex-direction: column;
                    gap: 14px;
                }

                .balance-card {
                    background: linear-gradient(135deg, #28a745 0%, #20873a 100%);
                    border-radius: 10px;
                    padding: 16px;
                    text-align: center;
                    color: white;
                    box-shadow: 0 3px 12px rgba(40, 167, 69, 0.2);
                }

                .balance-label {
                    font-size: 0.85rem;
                    opacity: 0.9;
                    margin-bottom: 6px;
                }

                .balance-amount {
                    font-size: 1.8rem;
                    font-weight: 700;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 6px;
                }

                .balance-currency {
                    font-size: 1.2rem;
                    opacity: 0.9;
                }

                /* Info Grid 2 Columns */
                .info-grid-2col {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                    gap: 10px;
                }

                .info-card-item {
                    background: #f8f9fa;
                    padding: 10px 14px;
                    border-radius: 6px;
                    border-left: 3px solid #0d6efd;
                }

                .info-card-label {
                    display: block;
                    font-size: 0.75rem;
                    color: #6c757d;
                    font-weight: 600;
                    margin-bottom: 4px;
                }

                .info-card-value {
                    display: block;
                    font-size: 0.85rem;
                    color: #212529;
                    font-weight: 500;
                }

                /* Message Card */
                .message-card {
                    background: linear-gradient(135deg, #e7f3ff 0%, #cfe2ff 100%);
                    border-radius: 8px;
                    padding: 12px 16px;
                    border-left: 3px solid #0d6efd;
                }

                .message-label {
                    font-size: 0.8rem;
                    color: #004085;
                    font-weight: 600;
                    margin-bottom: 6px;
                }

                .message-content {
                    font-size: 0.85rem;
                    color: #0d6efd;
                    font-weight: 500;
                }

                /* Unlock Code Card */
                .unlock-code-card {
                    background: linear-gradient(135deg, #212529 0%, #343a40 100%);
                    border-radius: 10px;
                    padding: 14px 18px;
                    color: white;
                }

                .unlock-label {
                    font-size: 0.8rem;
                    color: rgba(255, 255, 255, 0.8);
                    margin-bottom: 10px;
                    display: flex;
                    align-items: center;
                }

                .unlock-value {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .code-display {
                    flex: 1;
                    background: rgba(255, 255, 255, 0.1);
                    padding: 10px 14px;
                    border-radius: 6px;
                    font-family: 'Courier New', monospace;
                    font-size: 0.95rem;
                    font-weight: 700;
                    letter-spacing: 1.5px;
                    text-align: center;
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .profile-photo-container {
                        flex-direction: column;
                    }

                    .balance-amount {
                        font-size: 2rem;
                    }

                    .info-grid,
                    .info-grid-2col,
                    .action-buttons-grid {
                        grid-template-columns: 1fr;
                    }
                }

                /* Remboursement Section */
                .remboursement-section {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 16px;
                    margin-top: 16px;
                    text-align: center;
                }

                .remboursement-hint {
                    display: block;
                    color: #6c757d;
                    font-size: 0.8rem;
                    margin-bottom: 12px;
                }

                .btn-remboursement {
                    background: linear-gradient(135deg, #28a745 0%, #20873a 100%);
                    color: white;
                    border: none;
                    padding: 10px 24px;
                    border-radius: 8px;
                    font-size: 0.9rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                }

                .btn-remboursement:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
                }

                /* Edit Section */
                .edit-section-divider {
                    height: 1px;
                    background: linear-gradient(to right, transparent, #dee2e6, transparent);
                    margin: 24px 0 16px;
                }

                .btn-toggle-edit {
                    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                    color: white;
                    border: none;
                    padding: 12px 32px;
                    border-radius: 10px;
                    font-size: 0.95rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
                }

                .btn-toggle-edit:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.3);
                }

                .toggle-icon {
                    font-size: 0.8rem;
                    transition: transform 0.3s ease;
                }

                .btn-toggle-edit.active .toggle-icon {
                    transform: rotate(180deg);
                }

                .forms-container {
                    margin-top: 20px;
                    padding: 0 10px;
                }

                /* Edit Form Cards */
                .edit-form-card {
                    background: white;
                    border-radius: 10px;
                    padding: 20px;
                    margin-bottom: 16px;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                    border-left: 4px solid #0d6efd;
                }

                .edit-form-title {
                    color: #212529;
                    font-size: 0.95rem;
                    font-weight: 600;
                    margin-bottom: 16px;
                    display: flex;
                    align-items: center;
                }

                .form-group-modern {
                    display: flex;
                    gap: 12px;
                    align-items: stretch;
                }

                .form-control-modern {
                    flex: 1;
                    padding: 10px 16px;
                    border: 2px solid #e9ecef;
                    border-radius: 8px;
                    font-size: 0.9rem;
                    transition: all 0.3s ease;
                }

                .form-control-modern:focus {
                    outline: none;
                    border-color: #0d6efd;
                    box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
                }

                .btn-submit-modern {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 8px;
                    font-size: 0.85rem;
                    font-weight: 600;
                    color: white;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    white-space: nowrap;
                    display: flex;
                    align-items: center;
                }

                .btn-submit-success {
                    background: linear-gradient(135deg, #28a745 0%, #20873a 100%);
                }

                .btn-submit-success:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
                }

                .btn-submit-danger {
                    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                }

                .btn-submit-danger:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
                }

                .btn-submit-primary {
                    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                }

                .btn-submit-primary:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
                }

                /* Textarea */
                .form-textarea {
                    resize: vertical;
                    min-height: 80px;
                }

                /* Percentage Grid */
                .percentage-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 16px;
                    margin-bottom: 16px;
                }

                .percentage-item {
                    display: flex;
                    flex-direction: column;
                }

                .percentage-label {
                    font-size: 0.85rem;
                    font-weight: 600;
                    color: #495057;
                    margin-bottom: 8px;
                    display: flex;
                    align-items: center;
                }

                .percentage-hint {
                    color: #6c757d;
                    font-size: 0.75rem;
                    margin-top: 6px;
                    font-style: italic;
                }

                /* Delete Account Section */
                .delete-account-section {
                    background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
                    border: 2px solid #dc3545;
                    border-radius: 10px;
                    padding: 20px;
                    margin-top: 20px;
                    text-align: center;
                }

                .delete-warning {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px;
                    color: #dc3545;
                    font-size: 1rem;
                    font-weight: 700;
                    margin-bottom: 16px;
                }

                .delete-warning i {
                    font-size: 1.3rem;
                }

                .btn-delete-account {
                    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                    color: white;
                    border: none;
                    padding: 12px 32px;
                    border-radius: 8px;
                    font-size: 0.95rem;
                    font-weight: 700;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: inline-flex;
                    align-items: center;
                    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
                }

                .btn-delete-account:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 16px rgba(220, 53, 69, 0.4);
                }

                .delete-disabled-message {
                    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
                    border: 2px solid #17a2b8;
                    border-radius: 10px;
                    padding: 16px;
                    margin-top: 20px;
                    text-align: center;
                    color: #0c5460;
                    font-weight: 600;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                /* Modal Footer */
                .modern-modal-footer {
                    background: #f8f9fa;
                    border-top: 1px solid #dee2e6;
                    padding: 14px 20px;
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                }

                .modern-modal-footer .btn {
                    padding: 8px 18px;
                    font-size: 0.9rem;
                    font-weight: 500;
                    border-radius: 6px;
                    display: flex;
                    align-items: center;
                    transition: all 0.3s ease;
                }

                .modern-modal-footer .btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
                }

                /* Legacy styles for compatibility */
                .header2 {
                    background-color: cadetblue;
                    color: #f3f3f3;
                }

                .succes {
                    color: #f3f3f3;
                }

                /* ===== RESPONSIVE MOBILE - PAGE HEADER ===== */
                @media (max-width: 767px) {
                    .modern-page-header {
                        padding: 1.25rem;
                        margin-bottom: 1.5rem;
                    }

                    .modern-page-header h1 {
                        font-size: 1.5rem;
                        gap: 0.75rem;
                    }

                    .modern-page-header .header-icon {
                        padding: 0.6rem;
                        font-size: 1.25rem;
                    }
                }

                @media (max-width: 575px) {
                    .modern-page-header {
                        padding: 1rem;
                        margin-bottom: 1rem;
                        border-radius: 0.75rem;
                    }

                    .modern-page-header h1 {
                        font-size: 1.35rem;
                        gap: 0.65rem;
                    }

                    .modern-page-header .header-icon {
                        padding: 0.5rem;
                        font-size: 1.15rem;
                    }
                }

                @media (max-width: 380px) {
                    .modern-page-header {
                        padding: 0.85rem;
                    }

                    .modern-page-header h1 {
                        font-size: 1.2rem;
                        gap: 0.5rem;
                    }

                    .modern-page-header .header-icon {
                        padding: 0.45rem;
                        font-size: 1rem;
                    }
                }

                /* ===== RESPONSIVE MOBILE - INFO CARDS ===== */
                @media (max-width: 991px) {
                    /* 2 colonnes sur tablettes */
                    .info-cards-row {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 0.75rem;
                    }

                    .info-card {
                        padding: 0.85rem;
                    }

                    .info-card .icon {
                        font-size: 1.5rem;
                    }

                    .info-card .value {
                        font-size: 1.25rem;
                    }
                }

                @media (max-width: 767px) {
                    /* 1 colonne sur mobile - Layout horizontal */
                    .info-cards-row {
                        grid-template-columns: 1fr;
                        gap: 0.75rem;
                        margin-bottom: 1.5rem;
                    }

                    .info-card {
                        padding: 0.75rem 1rem;
                        display: grid;
                        grid-template-columns: auto 1fr;
                        grid-template-rows: auto auto;
                        gap: 0.5rem 1rem;
                        align-items: center;
                    }

                    .info-card .icon {
                        grid-row: 1 / 3;
                        font-size: 2.25rem;
                        margin-bottom: 0;
                    }

                    .info-card h4 {
                        grid-column: 2;
                        grid-row: 1;
                        font-size: 0.7rem;
                        margin-bottom: 0;
                        align-self: end;
                    }

                    .info-card .value {
                        grid-column: 2;
                        grid-row: 2;
                        font-size: 1.2rem;
                        align-self: start;
                    }

                    .info-card:hover {
                        transform: translateY(-2px);
                    }
                }

                @media (max-width: 575px) {
                    .info-cards-row {
                        gap: 0.5rem;
                        margin-bottom: 1rem;
                    }

                    .info-card {
                        padding: 0.65rem 0.85rem;
                        gap: 0.4rem 0.85rem;
                    }

                    .info-card .icon {
                        font-size: 2rem;
                    }

                    .info-card h4 {
                        font-size: 0.65rem;
                        letter-spacing: 0.3px;
                    }

                    .info-card .value {
                        font-size: 1.1rem;
                    }
                }

                @media (max-width: 380px) {
                    .info-card {
                        padding: 0.55rem 0.7rem;
                        gap: 0.35rem 0.7rem;
                    }

                    .info-card .icon {
                        font-size: 1.75rem;
                    }

                    .info-card h4 {
                        font-size: 0.6rem;
                        letter-spacing: 0.2px;
                    }

                    .info-card .value {
                        font-size: 1rem;
                    }
                }

                /* ===== RESPONSIVE MOBILE - CARDS PRINCIPALES ===== */
                @media (max-width: 767px) {
                    .modern-card {
                        border-radius: 0.75rem;
                        margin-bottom: 1rem;
                    }

                    .modern-card-header {
                        padding: 1rem;
                    }

                    .modern-card-header h4 {
                        font-size: 1.1rem;
                    }

                    .modern-card-body {
                        padding: 1rem;
                    }
                }

                @media (max-width: 575px) {
                    .modern-card {
                        border-radius: 0.65rem;
                    }

                    .modern-card-header {
                        padding: 0.85rem;
                    }

                    .modern-card-header h4 {
                        font-size: 1rem;
                    }

                    .modern-card-body {
                        padding: 0.85rem;
                    }
                }

                @media (max-width: 380px) {
                    .modern-card-header {
                        padding: 0.75rem;
                    }

                    .modern-card-header h4 {
                        font-size: 0.95rem;
                    }

                    .modern-card-body {
                        padding: 0.75rem;
                    }
                }

                /* ===== RESPONSIVE MOBILE - MODAL COMPTE ===== */
                @media (max-width: 767px) {
                    /* Form Group - Passage en colonne */
                    .form-group-modern {
                        flex-direction: column;
                        gap: 10px;
                    }

                    /* Input prend toute la largeur */
                    .form-control-modern {
                        width: 100%;
                        padding: 12px 14px;
                        font-size: 16px; /* Évite le zoom iOS */
                    }

                    /* Bouton prend toute la largeur */
                    .btn-submit-modern {
                        width: 100%;
                        padding: 12px 20px;
                        justify-content: center;
                        font-size: 0.9rem;
                    }

                    /* Edit Form Card plus compact */
                    .edit-form-card {
                        padding: 16px;
                        margin-bottom: 12px;
                    }

                    .edit-form-title {
                        font-size: 0.9rem;
                        margin-bottom: 12px;
                    }

                    /* Percentage Grid en colonne */
                    .percentage-grid {
                        grid-template-columns: 1fr;
                        gap: 12px;
                    }

                    /* Delete Section */
                    .delete-account-section {
                        padding: 16px;
                    }

                    .btn-delete-account {
                        width: 100%;
                        padding: 12px 24px;
                        font-size: 0.9rem;
                    }

                    /* Modal Footer responsive */
                    .modern-modal-footer {
                        flex-direction: column;
                        gap: 8px;
                    }

                    .modern-modal-footer .btn {
                        width: 100%;
                        justify-content: center;
                    }
                }

                /* Très petits écrans */
                @media (max-width: 575px) {
                    .form-group-modern {
                        gap: 8px;
                    }

                    .form-control-modern {
                        padding: 10px 12px;
                        font-size: 15px;
                    }

                    .btn-submit-modern {
                        padding: 10px 16px;
                        font-size: 0.85rem;
                    }

                    .edit-form-card {
                        padding: 12px;
                        margin-bottom: 10px;
                    }

                    .percentage-grid {
                        gap: 10px;
                    }

                    .delete-account-section {
                        padding: 12px;
                    }

                    .btn-delete-account {
                        padding: 10px 20px;
                        font-size: 0.85rem;
                    }
                }

                /* Ultra petits écrans */
                @media (max-width: 380px) {
                    .form-control-modern {
                        padding: 8px 10px;
                        font-size: 14px;
                    }

                    .btn-submit-modern {
                        padding: 9px 14px;
                        font-size: 0.8rem;
                    }

                    .edit-form-card {
                        padding: 10px;
                    }

                    .edit-form-title {
                        font-size: 0.85rem;
                    }

                    .btn-delete-account {
                        padding: 9px 16px;
                        font-size: 0.8rem;
                    }

                    .delete-warning {
                        font-size: 0.9rem;
                    }
                }
            </style>
            

            <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered account-modal-dialog" role="document">
                    <div class="modal-content modern-modal">
                        <div class="modal-header modern-modal-header">
                            <h5 class="modal-title modern-modal-title" id="infoModalLabel">
                                <i class="fas fa-user-circle me-2"></i>
                                Détail de l'accès client
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modern-modal-body modal-detail-layout">
                            <div class="detail-pane mb-4">
                            <div class="info-section modern-section">
                                <h6 class="modern-section-title">
                                    <i class="fas fa-user me-2"></i>
                                    Informations Personnelles
                                </h6>
                                
                                <!-- Photo de profil et upload -->
                                <div class="profile-photo-container mb-4">
                                    <div class="profile-photo-wrapper">
                                        <img id="modal-photo" src="" alt="Photo actuelle" class="profile-photo" style="display:none">
                                    </div>

                                    <div class="profile-upload-section">
                                        <form id="updatePhotoForm" method="POST" action="#" enctype="multipart/form-data"
                                              data-action-template="{{ route('compte.updatePhoto', ['id' => '__ID__']) }}" class="upload-form" style="width:100%;">
                                            @csrf
                                            <div class="upload-controls" style="display:flex;align-items:center;justify-content:center;gap:16px;width:100%;max-width:480px;margin:0 auto;">
                                                <label for="photo-input" class="upload-label" style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;padding:10px 16px;background:#0d6efd;color:#fff;border-radius:8px;">
                                                    <i class="fas fa-camera me-2"></i>
                                                    <span>Choisir un fichier</span>
                                                </label>
                                                <input type="file" name="photo" id="photo-input" class="upload-input" accept="image/*" required style="display:none;">
                                                <button class="btn-upload" type="submit" style="white-space:nowrap;padding:10px 18px;background:#198754;color:#fff;border-radius:8px;border:0;">
                                                    <i class="fas fa-upload me-1"></i> Uploader
                                                </button>
                                            </div>
                                            <span class="file-name" id="file-name-display" style="display:block;color:#6c757d;margin-top:12px;text-align:center;">Aucun fichier sélectionné</span>
                                        </form>
                                        <small class="upload-hint">Formats acceptés : JPG, PNG, GIF (max 2MB)</small>
                                    </div>
                                </div>

                                <div class="info-card mb-3">
                                    <div class="info-row">
                                        <span class="info-label">Titulaire du compte:</span>
                                        <span class="info-value" id="modal-nom"></span>
                                    </div>
                                </div>

                                <div class="credentials-card">
                                    <div class="credential-item">
                                        <div class="credential-label">
                                            <i class="fas fa-envelope me-2"></i>
                                            adresse e-mail:
                                        </div>
                                        <div class="credential-value">
                                            <span id="modal-email" class="credential-text"></span>
                                            <button type="button" class="btn-copy" data-clipboard-target="#modal-email" title="Copier">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="credential-item">
                                        <div class="credential-label">
                                            <i class="fas fa-key me-2"></i>
                                            mot de passe:
                                        </div>
                                        <div class="credential-value">
                                            <span id="modal-password" class="credential-text"></span>
                                            <button type="button" class="btn-copy" data-clipboard-target="#modal-password" title="Copier">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <a href="https://fluxtransfer.world/" target="_blank" class="access-link">
                                        <i class="fas fa-external-link-alt me-2"></i>
                                        accéder à l'espace client
                                    </a>
                                </div>
                                
                                @isset($compte)
                                    <div class="action-buttons-grid">
                                        <form id="envoyer-email-form" method="POST" action="#" data-action-template="{{ route('comptes.envoyerEmail', ['id' => '__ID__']) }}">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-primary">
                                                <i class="fas fa-envelope me-2"></i>
                                                Envoyer les coordonnées par email
                                            </button>
                                        </form>
                                        
                                        <form id="envoyer-code-form" method="POST" action="#" data-action-template="{{ route('comptes.envoyerCodeDeblocage', ['id' => '__ID__']) }}">
                                            @csrf
                                            <button type="submit" class="btn-action btn-action-warning">
                                                <i class="fas fa-lock me-2"></i>
                                                Envoyer le Code de déblocage
                                            </button>
                                        </form>
                                    </div>
                                @endisset

                                <div class="info-grid mt-4">
                                    <div class="info-item">
                                        <i class="fas fa-phone info-icon"></i>
                                        <div>
                                            <div class="info-item-label">Numéro de téléphone:</div>
                                            <div class="info-item-value" id="modal-phone"></div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-globe info-icon"></i>
                                        <div>
                                            <div class="info-item-label">Pays de résidence:</div>
                                            <div class="info-item-value" id="modal-country"></div>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <i class="fas fa-map-marker-alt info-icon"></i>
                                        <div>
                                            <div class="info-item-label">Adresse de résidence:</div>
                                            <div class="info-item-value" id="modal-address"></div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="info-section modern-section mt-4">
                                <h6 class="modern-section-title">
                                    <i class="fas fa-university me-2"></i>
                                    Compte et Virement
                                </h6>
                                
                                <div class="account-overview">
                                    <div class="balance-card">
                                        <div class="balance-label">Solde du compte</div>
                                        <div class="balance-amount">
                                            <span id="modal-balance"></span>
                                            <span id="modal-devise-display" class="balance-currency"></span>
                                        </div>
                                    </div>

                                    <div class="info-grid-2col">
                                        <div class="info-card-item">
                                            <span class="info-card-label">Type de compte:</span>
                                            <span class="info-card-value" id="modal-account-type"></span>
                                        </div>
                                        <div class="info-card-item">
                                            <span class="info-card-label">Statut du compte:</span>
                                            <span class="info-card-value" id="modal-account-status"></span>
                                        </div>
                                        <div class="info-card-item">
                                            <span class="info-card-label">Virement supporté:</span>
                                            <span class="info-card-value" id="modal-transfer-supported"></span>
                                        </div>
                                        <div class="info-card-item">
                                            <span class="info-card-label">Pourcentage de début:</span>
                                            <span class="info-card-value"><span id="modal-start-percentage"></span>%</span>
                                        </div>
                                        <div class="info-card-item">
                                            <span class="info-card-label">Pourcentage de fin:</span>
                                            <span class="info-card-value"><span id="modal-end-percentage"></span>%</span>
                                        </div>
                                    </div>

                                    <div class="message-card">
                                        <div class="message-label">
                                            <i class="fas fa-comment-dots me-2"></i>
                                            Message à afficher:
                                        </div>
                                        <div class="message-content" id="modal-failure-message"></div>
                                    </div>

                                    <div class="unlock-code-card">
                                        <div class="unlock-label">
                                            <i class="fas fa-unlock-alt me-2"></i>
                                            Code de déblocage:
                                        </div>
                                        <div class="unlock-value">
                                            <span class="code-display" id="modal-code-virement"></span>
                                            <button type="button" class="btn-copy" data-clipboard-target="#modal-code-virement" title="Copier">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" id="compte-id">

                                <div class="client-access-summary mt-4">
                                    <p class="client-summary-row">
                                        <span class="client-summary-label">Code déjà utilisé :</span>
                                        <span id="modal-code-used" class="detail-badge detail-badge--usage">—</span>
                                    </p>
                                    <p class="client-summary-row">
                                        <span class="client-summary-label">Alert Mail Pro :</span>
                                        <span id="modal-alert-email" class="status-badge status-badge--inactive">—</span>
                                    </p>
                                    <p class="client-summary-row">
                                        <span class="client-summary-label">Alert SMS Pro :</span>
                                        <span id="modal-alert-sms" class="status-badge status-badge--inactive">—</span>
                                    </p>
                                    <p class="client-summary-row">
                                        <span class="client-summary-label">Coût de création :</span>
                                        <span id="modal-creation-cost" class="client-summary-value">—</span>
                                    </p>
                                    <p class="client-summary-row">
                                        <span class="client-summary-label">Date de création :</span>
                                        <span id="modal-created-at" class="client-summary-value">—</span>
                                    </p>
                                    <p class="client-summary-row mb-0">
                                        <span class="client-summary-label">État :</span>
                                        <span id="modal-state-pill" class="state-badge state-badge--info">—</span>
                                    </p>
                                </div>
                            </div>

                            @isset($compte)
                                <div class="remboursement-section">
                                    <small class="remboursement-hint">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Recréditer le compte après un transfert
                                    </small>
                                    <form id="remboursement-form" method="POST" action="#" data-action-template="{{ route('comptes.rembourserCompte', ['id' => '__ID__']) }}">
                                        @csrf
                                        <button type="submit" class="btn-remboursement" id="remboursement-btn">
                                            <i class="fas fa-redo-alt me-2"></i>
                                            Rembourser le Solde
                                        </button>
                                    </form>
                                </div>
                            @endisset

                            <div class="edit-pane">
                                <div class="edit-section-divider"></div>
                                <div class="text-center my-3">
                                    <button id="toggleFormsBtn" class="btn-toggle-edit w-100">
                                        <i class="fas fa-edit me-2"></i>
                                        Modifier les informations Client
                                        <i class="fas fa-chevron-down ms-2 toggle-icon"></i>
                                    </button>
                                </div>

                        <div id="formsContainer" class="forms-container" style="display: none;">
                            
                            <!-- Statut de Compte -->
                            <div class="edit-form-card">
                                <h6 class="edit-form-title">
                                    <i class="fas fa-toggle-on me-2"></i>
                                    Statut de Compte
                                </h6>
                                <form id="changeStatusForm" method="POST" action="#" data-action-template="{{ route('update.status', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="compte_id" id="statusCompteId">
                                    <div class="form-group-modern">
                                        <select name="account_status" id="account_status" class="form-control-modern">
                                            <option value="" disabled selected>Activé</option>
                                            <option value="Activé">Activé</option>
                                            <option value="Examen">En examen</option>
                                            <option value="Suspendu">Suspendu</option>
                                            <option value="Bloqué">Bloqué</option>
                                        </select>
                                        <button type="submit" class="btn-submit-modern btn-submit-success">
                                            <i class="fas fa-check me-2"></i>
                                            Changer le statut du compte
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Compléter le Solde -->
                            <div class="edit-form-card">
                                <h6 class="edit-form-title">
                                    <i class="fas fa-plus-circle me-2" style="color: #28a745;"></i>
                                    Compléter le solde de <span style="color: #28a745; font-weight: 700;">+</span>
                                </h6>
                                <form id="plusSolde" method="POST" action="#" data-action-template="{{ route('update.solde', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="compte_id" id="plusSoldeCompteId">
                                    <div class="form-group-modern">
                                        <input type="number" class="form-control-modern" name="montant"
                                            placeholder="Entrer le montant à ajouter au compte" required>
                                        <button type="submit" class="btn-submit-modern btn-submit-success">
                                            <i class="fas fa-arrow-up me-2"></i>
                                            Compléter le solde du compte
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Diminuer le Solde -->
                            <div class="edit-form-card">
                                <h6 class="edit-form-title">
                                    <i class="fas fa-minus-circle me-2" style="color: #dc3545;"></i>
                                    Diminuer le solde de <span style="color: #dc3545; font-weight: 700;">-</span>
                                </h6>
                                <form id="moinsSolde" method="POST" action="#" data-action-template="{{ route('diminuer.solde', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="compte_id" id="moinsSoldeCompteId">
                                    <div class="form-group-modern">
                                        <input type="number" class="form-control-modern" name="montant"
                                            placeholder="Entrer le montant à soustraire du compte" required>
                                        <button type="submit" class="btn-submit-modern btn-submit-danger">
                                            <i class="fas fa-arrow-down me-2"></i>
                                            Diminuer le solde du compte
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Message et Pourcentages -->
                            <div class="edit-form-card">
                                <h6 class="edit-form-title">
                                    <i class="fas fa-comment-alt me-2" style="color: #0d6efd;"></i>
                                    Message
                                </h6>
                                <form id="messagePercentageForm" method="POST" action="#" data-action-template="{{ route('modifier.messagePourcentages', ['id' => '__ID__']) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="compte_id" id="messagePercentageCompteId">
                                    
                                    <div class="mb-3">
                                        <textarea class="form-control-modern form-textarea" id="modal_failure_message" name="failuremessage" 
                                            placeholder="Entrer le message à afficher au client" rows="3" required></textarea>
                                    </div>

                                    <div class="percentage-grid">
                                        <div class="percentage-item">
                                            <label class="percentage-label">
                                                <i class="fas fa-play me-1"></i>
                                                Pourcentage de Début
                                            </label>
                                            <input type="number" class="form-control-modern" id="modal_start_percentage"
                                                name="start_percentage" min="0" max="99" value="0" required>
                                            <small class="percentage-hint">Adapter le point de départ (0 = début&nbsp;; la réussite n'intervient qu'une fois le % de fin à 100).</small>
                                        </div>
                                        
                                        <div class="percentage-item">
                                            <label class="percentage-label">
                                                <i class="fas fa-flag-checkered me-1"></i>
                                                Pourcentage de Fin
                                            </label>
                                            <input type="number" class="form-control-modern" id="modal_end_percentage" 
                                                name="end_percentage" min="1" max="100" placeholder="Valeur entre 1 et 100" required>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn-submit-modern btn-submit-primary">
                                            <i class="fas fa-sync-alt me-2"></i>
                                            Mettre à jour le message et les pourcentages
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Supprimer le Compte -->
                            <div id="deleteAccountSection" class="delete-account-section">
                                <div class="delete-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Supprimer définitivement ce compte</span>
                                </div>
                                <form id="deleteAccountForm" method="POST" action="" data-delete-base="{{ url('/delete-account') }}" onsubmit="return confirmDelete();">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" id="deleteCompteId" name="compte_id">
                                    <button type="submit" class="btn-delete-account">
                                        <i class="fas fa-trash-alt me-2"></i>
                                        Supprimer le compte
                                    </button>
                                </form>
                            </div>
                            
                            <div id="deleteAccountDisabledMessage" class="delete-disabled-message d-none">
                                <i class="fas fa-info-circle me-2"></i>
                                Ce compte principal a été créé automatiquement et ne peut pas être supprimé.
                            </div>
                        </div>
                            </div>
                        </div>
                        <!-- FIN formsContainer -->
                    <!-- FIN modal-body -->

            <style>
                /* Mobile-specific modal adjustments: reduce header size and make forms area scrollable */
                @media (max-width: 575.98px) {
                    .modal-dialog.modal-dialog-centered {
                        max-width: 92% !important;
                        margin: 0 8px;
                    }

                    .modern-modal {
                        border-radius: 12px;
                    }

                    .modern-modal-header {
                        padding: 10px 12px;
                        min-height: 56px;
                    }

                    .modern-modal-title {
                        font-size: 1rem;
                    }

                    .modern-modal-body {
                        padding: 8px;
                        max-height: 60vh; /* leave room for header and footer */
                        overflow-y: auto;
                    }

                    /* Keep the edit forms compact and scrollable so they don't expand the modal too much */
                    .forms-container {
                        max-height: 40vh;
                        overflow-y: auto;
                        padding: 6px 6px 12px;
                    }

                    .edit-form-card {
                        padding: 10px;
                        margin-bottom: 10px;
                    }
                }
            </style>
            <style>
                .account-modal-dialog {
                    width: calc(100vw - 24px);
                    max-width: 600px;
                    margin: 1.5rem auto;
                }
                .modal-detail-layout {
                    max-height: 68vh;
                    overflow-y: auto;
                    padding-right: 8px;
                }
                .detail-pane {
                    padding-right: 0;
                }
                .edit-pane {
                    padding-top: 12px;
                }
            </style>

<script>
                function confirmDelete() {
                    return confirm('Êtes-vous sûr de vouloir supprimer ce compte ? Cette action est irréversible.');
                }

                document.addEventListener('DOMContentLoaded', function() {
                    var infoModal = document.getElementById('infoModal');
                    var deleteForm = document.getElementById('deleteAccountForm');
                    var hiddenField = document.getElementById('deleteCompteId');
                    var detailButtons = document.querySelectorAll('[data-bs-target="#infoModal"]');
                    var deleteSection = document.getElementById('deleteAccountSection');
                    var deleteDisabledMessage = document.getElementById('deleteAccountDisabledMessage');

                    function buildDeleteUrl(id) {
                        var base = deleteForm ? deleteForm.getAttribute('data-delete-base') : '';
                        if (!base || !id) {
                            return '';
                        }
                        return base.replace(/\/$/, '') + '/' + id;
                    }

                    function applyDeleteContext(trigger) {
                        if (!trigger || !deleteForm) {
                            return;
                        }
                        var dataset = trigger.dataset || {};
                        var compteId = trigger.getAttribute('data-compte-id') || dataset.compteId || '';
                        var rawDefaultFlag = trigger.getAttribute('data-is-default');
                        if (rawDefaultFlag === null && typeof dataset.isDefault !== 'undefined') {
                            rawDefaultFlag = dataset.isDefault;
                        }
                        var isDefault = rawDefaultFlag === '1' || rawDefaultFlag === 'true';
                        if (deleteSection) {
                            deleteSection.classList.toggle('d-none', isDefault);
                        }
                        if (deleteDisabledMessage) {
                            deleteDisabledMessage.classList.toggle('d-none', !isDefault);
                        }
                        if (hiddenField) {
                            hiddenField.value = compteId;
                        }
                        if (isDefault) {
                            deleteForm.removeAttribute('action');
                            return;
                        }
                        var deleteUrl = trigger.getAttribute('data-delete-url') || dataset.deleteUrl;
                        if (!deleteUrl) {
                            deleteUrl = buildDeleteUrl(compteId);
                        }
                        if (deleteUrl) {
                            deleteForm.setAttribute('action', deleteUrl);
                        }
                    }

                    if (detailButtons.length && deleteForm) {
                        detailButtons.forEach(function(button) {
                            button.addEventListener('click', function() {
                                applyDeleteContext(button);
                            });
                        });
                    }

                    if (infoModal && deleteForm) {
                        infoModal.addEventListener('show.bs.modal', function(event) {
                            applyDeleteContext(event.relatedTarget);
                        });
                    }

                    if (deleteForm) {
                        deleteForm.addEventListener('submit', function() {
                            var currentAction = deleteForm.getAttribute('action');
                            if (deleteSection && deleteSection.classList.contains('d-none')) {
                                return;
                            }
                            if (!currentAction) {
                                var fallbackId = hiddenField ? hiddenField.value : '';
                                var fallbackUrl = buildDeleteUrl(fallbackId);
                                if (fallbackUrl) {
                                    deleteForm.setAttribute('action', fallbackUrl);
                                }
                            }
                        });
                    }
                });

                // Gestion de l'affichage du nom de fichier sélectionné
                document.addEventListener('DOMContentLoaded', function() {
                    const photoInput = document.getElementById('photo-input');
                    const fileNameDisplay = document.getElementById('file-name-display');
                    
                    if (photoInput && fileNameDisplay) {
                        photoInput.addEventListener('change', function(e) {
                            if (e.target.files.length > 0) {
                                const fileName = e.target.files[0].name;
                                fileNameDisplay.textContent = fileName;
                                fileNameDisplay.style.fontStyle = 'normal';
                                fileNameDisplay.style.color = '#28a745';
                            } else {
                                fileNameDisplay.textContent = 'Aucun fichier sélectionné';
                                fileNameDisplay.style.fontStyle = 'italic';
                                fileNameDisplay.style.color = '#6c757d';
                            }
                        });
                    }
                });
            </script>

                <div class="modal-footer modern-modal-footer" style="position: relative; width: 100%;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fermer
                    </button>
                </div>
            </div>
        </div>

<style>
  .small-text {
    font-size: 0.875rem; /* Taille du texte légèrement plus petite */
    color: #6c757d; /* Couleur gris moyen */
    font-weight: 600; /* Poids du texte semi-gras */
    margin-top: 10px; /* Marge supérieure */
    display: block; /* Affichage en bloc pour contrôler les marges */
    font-style: italic; /* Texte en italique */

  }
</style>

        <div class="modal fade" id="messageChangeReminderModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Rappel important</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0" data-reminder-body></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Compris</button>
                    </div>
                </div>
            </div>
        </div>



        </div>


    </div>
    <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var alertSmsToggle = document.getElementById('alertSmsToggle');
                    var createCompteBtn = document.getElementById('createCompteBtn');
                    // NOUVEAU COÛT DE BASE
                    var baseCost = 4000;
                    var smsCost = 1000;

                    function updateSubmitLabel() {
                        if (!createCompteBtn) {
                            return;
                        }
                        var total = alertSmsToggle && alertSmsToggle.checked ? baseCost + smsCost : baseCost;
                        createCompteBtn.textContent = 'Créer l\'accès client (' + total.toLocaleString('fr-FR') + ' Crédits)';
                    }

                    if (alertSmsToggle) {
                        alertSmsToggle.addEventListener('change', updateSubmitLabel);
                    }

                    updateSubmitLabel();

                    var toggleFormsBtn = document.getElementById('toggleFormsBtn');
                    var formsContainer = document.getElementById('formsContainer');
                    if (toggleFormsBtn && formsContainer) {
                        toggleFormsBtn.addEventListener('click', function() {
                            var shouldShow = formsContainer.style.display === 'none' || formsContainer.style.display === '';
                            formsContainer.style.display = shouldShow ? 'block' : 'none';
                            
                            // Toggle active class for icon rotation
                            toggleFormsBtn.classList.toggle('active');
                        });
                    }
                });
            </script>
    <script>
        let currentCompteId = '';
        let changeReminderModalInstance = null;
        let percentageReminderShown = false;
        let messageReminderShown = false;

        function showMessagePercentageReminder(target) {
            const modalElement = document.getElementById('messageChangeReminderModal');
            if (!modalElement) {
                return;
            }

            const body = modalElement.querySelector('[data-reminder-body]');
            if (body) {
                if (target === 'percentage') {
                    body.textContent = "Vous avez modifié le message. N'oubliez pas de mettre à jour le pourcentage de fin avant de valider.";
                } else {
                    body.textContent = "Vous avez modifié le pourcentage de fin. N'oubliez pas de mettre à jour le message avant de valider.";
                }
            }

            if (!changeReminderModalInstance) {
                changeReminderModalInstance = new bootstrap.Modal(modalElement);
            }

            changeReminderModalInstance.show();
        }

        function populateModal(data) {
            console.log('Populating modal with data:', data);

            // Mettre à jour l'action du formulaire AVANT tout
            const photoForm = document.getElementById('updatePhotoForm');
            if (photoForm && data.compteId) {
                const template = photoForm.getAttribute('data-action-template');
                const actionUrl = template.replace('__ID__', data.compteId);
                photoForm.setAttribute('action', actionUrl);
                console.log('Action du formulaire photo définie:', actionUrl);
            }

            // Utiliser JavaScript vanilla au lieu de jQuery
            const setElementText = (id, value) => {
                const element = document.getElementById(id);
                if (element) element.textContent = value || '';
            };
            const setElementValue = (id, value) => {
                const element = document.getElementById(id);
                if (element) element.value = value != null ? value : '';
            };
            const resolveStartPercentage = () => {
                const candidates = [data.startPercentage, data.start_percentage];
                for (const candidate of candidates) {
                    if (candidate === undefined || candidate === null) {
                        continue;
                    }
                    const trimmed = String(candidate).trim();
                    if (trimmed.length) {
                        return trimmed;
                    }
                }
                return '0';
            };
            const resolvedStartPercentage = resolveStartPercentage();

            setElementText('modal-nom', data.nom);
            setElementText('modal-email', data.email);
            setElementText('modal-phone', data.phone || data.phone_number);
            setElementText('modal-country', data.country);
            setElementText('modal-password', data.password);
            setElementText('modal-code-virement', data.codeVirement || data.code_virement);
            const resolvedAddress = (data.address && data.address.trim() !== '') ? data.address : 'Cotonou-Bénin';
            setElementText('modal-address', resolvedAddress);
            // show currency and amount together: put devise before the formatted balance
            setElementText('modal-devise', data.devise);
            (function(){
                var devise = data.devise || data.devise_code || data.currency || '';
                var balance = data.balance || '';
                var display = '';
                if (devise && balance) {
                    display = devise + ' ' + balance;
                } else if (balance) {
                    display = balance;
                } else if (devise) {
                    display = devise;
                }
                setElementText('modal-balance', display);
            })();
            setElementText('modal-account-type', data.accountType || data.account_type);
            setElementText('modal-account-status', data.accountStatus || data.account_status);
            const currentFailureMessage = (data.failureMessage || data.failure_message || '').trim();
            setElementText('modal-failure-message', currentFailureMessage);
            setElementText('modal-transfer-supported', data.transferSupported || data.transfer_supported);
            setElementText('modal-start-percentage', resolvedStartPercentage);
            setElementText('modal-end-percentage', data.endPercentage || data.end_percentage);

            const messagePercentageForm = document.getElementById('messagePercentageForm');
            if (messagePercentageForm) {
                const endValue = String(data.endPercentage || data.end_percentage || '').trim();

                // reset reminder flags for the currently inspected compte
                percentageReminderShown = false;
                messageReminderShown = false;

                setElementValue('modal_start_percentage', resolvedStartPercentage);

                messagePercentageForm.dataset.originalMessage = currentFailureMessage;
                messagePercentageForm.dataset.originalEnd = endValue;
                messagePercentageForm.dataset.originalStart = resolvedStartPercentage;
                messagePercentageForm.dataset.messageEdited = 'false';
                messagePercentageForm.dataset.endEdited = 'false';
                messagePercentageForm.dataset.startEdited = 'false';

                const messageInput = messagePercentageForm.querySelector('textarea[name="failuremessage"]');
                if (messageInput) {
                    messageInput.value = currentFailureMessage;
                    if (!messageInput.dataset.listenerAttached) {
                        messageInput.addEventListener('input', function () {
                            const form = document.getElementById('messagePercentageForm');
                            if (!form) {
                                return;
                            }
                            const original = (form.dataset.originalMessage || '').trim();
                            const currentValue = (this.value || '').trim();
                            const changed = currentValue.length > 0 && currentValue !== original;
                            form.dataset.messageEdited = changed ? 'true' : 'false';

                            if (changed && form.dataset.endEdited !== 'true' && !percentageReminderShown) {
                                showMessagePercentageReminder('percentage');
                                percentageReminderShown = true;
                            }
                        });
                        messageInput.dataset.listenerAttached = 'true';
                    }
                }

                const startInput = messagePercentageForm.querySelector('#modal_start_percentage');
                if (startInput) {
                    startInput.value = resolvedStartPercentage;
                    if (!startInput.dataset.listenerAttached) {
                        startInput.addEventListener('input', function () {
                            const form = document.getElementById('messagePercentageForm');
                            if (!form) {
                                return;
                            }
                            const original = (form.dataset.originalStart || '').trim();
                            const currentValue = (this.value || '').trim();
                            const changed = currentValue.length > 0 && currentValue !== original;
                            form.dataset.startEdited = changed ? 'true' : 'false';
                        });
                        startInput.dataset.listenerAttached = 'true';
                    }
                }

                const endInput = messagePercentageForm.querySelector('#modal_end_percentage');
                if (endInput) {
                    endInput.value = endValue;
                    if (!endInput.dataset.listenerAttached) {
                        endInput.addEventListener('input', function () {
                            const form = document.getElementById('messagePercentageForm');
                            if (!form) {
                                return;
                            }
                            const original = (form.dataset.originalEnd || '').trim();
                            const currentValue = (this.value || '').trim();
                            const changed = currentValue.length > 0 && currentValue !== original;
                            form.dataset.endEdited = changed ? 'true' : 'false';

                            if (changed && form.dataset.messageEdited !== 'true' && !messageReminderShown) {
                                showMessagePercentageReminder('message');
                                messageReminderShown = true;
                            }
                        });
                        endInput.dataset.listenerAttached = 'true';
                    }
                }
            }

            // 🔴 Gérer l'affichage de la photo même si elle est null
            const modalPhoto = document.getElementById('modal-photo');
            if (modalPhoto) {
                // Le serveur envoie photo_url déjà formatée avec asset() - l'utiliser directement
                if (data.photo_url) {
                    modalPhoto.src = data.photo_url;
                    console.log('Photo URL reçue:', data.photo_url);
                    modalPhoto.style.display = 'block';
                } else if (data.photo_path) {
                    // Fallback si seulement photo_path est disponible
                    if (data.photo_path.startsWith('http://') || data.photo_path.startsWith('https://')) {
                        modalPhoto.src = data.photo_path;
                        console.log('Photo path (URL externe):', data.photo_path);
                    } else {
                        const cleanPath = data.photo_path.replace(/^\/?(storage\/)?/, '');
                        const fullUrl = appBaseUrl + '/storage/' + cleanPath;
                        modalPhoto.src = fullUrl;
                        console.log('Photo path (construite):', fullUrl);
                    }
                    modalPhoto.style.display = 'block';
                } else {
                    // Avatar par défaut si aucune photo
                    const defaultAvatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.nom || '')}&background=007bff&color=fff&size=72`;
                    modalPhoto.src = defaultAvatar;
                    console.log('Photo avatar par défaut:', defaultAvatar);
                    modalPhoto.style.display = 'block';
                }
            }

            if (data.compteId) {
                setFormAction('#envoyer-email-form', data.compteId);
                setFormAction('#envoyer-code-form', data.compteId);
                setFormAction('#remboursement-form', data.compteId);
                setFormAction('#changeStatusForm', data.compteId);
                setFormAction('#plusSolde', data.compteId);
                setFormAction('#moinsSolde', data.compteId);
                setFormAction('#messagePercentageForm', data.compteId);
                setElementValue('compte-id', data.compteId);
                setElementValue('statusCompteId', data.compteId);
                setElementValue('plusSoldeCompteId', data.compteId);
                setElementValue('moinsSoldeCompteId', data.compteId);
                setElementValue('messagePercentageCompteId', data.compteId);
                setElementValue('deleteCompteId', data.compteId);
                currentCompteId = data.compteId;
            }

            if (typeof data.accountStatus !== 'undefined' && data.accountStatus !== null) {
                setElementValue('account_status', data.accountStatus);
            }
            if (typeof data.endPercentage !== 'undefined' && data.endPercentage !== null) {
                setElementValue('modal_end_percentage', data.endPercentage);
            }
            if (typeof data.failureMessage !== 'undefined' && data.failureMessage !== null) {
                const failureMessageInput = document.querySelector('#messagePercentageForm input[name="failuremessage"]');
                if (failureMessageInput) {
                    failureMessageInput.value = data.failureMessage;
                }
            }

            updateAlertBadges(data.alertEmail, data.alertSms);
            updateCodeUsageBadge(data.codeUsed);
            updateCreationCost(data.creationCost);
            updateCreationDate(data.createdAt);
            updateStateBadge(data.accountStatus);
            // Utiliser canRefund si disponible (balance == 0 && transfert complété), sinon fallback existant
            var refundFlag = typeof data.canRefund !== 'undefined' ? data.canRefund : data.hasCompletedTransfer;
            toggleRemboursementForm(refundFlag);
        }

        function updateAlertBadges(alertEmail, alertSms) {
            const emailBadge = document.getElementById('modal-alert-email');
            const smsBadge = document.getElementById('modal-alert-sms');

            if (emailBadge) {
                emailBadge.classList.remove('status-badge--active', 'status-badge--inactive');
                emailBadge.textContent = '—';
            }
            
            if (smsBadge) {
                smsBadge.classList.remove('status-badge--active', 'status-badge--inactive');
                smsBadge.textContent = '—';
            }

            if (emailBadge) {
                const hasExplicitEmailValue = alertEmail !== undefined && alertEmail !== null && alertEmail !== '';
                const normalizedEmail = String(alertEmail).toLowerCase();
                const isActiveEmail = hasExplicitEmailValue
                    ? (normalizedEmail === '1' || normalizedEmail === 'true' || alertEmail === true)
                    : true;
                const emailIcon = isActiveEmail ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
                emailBadge.innerHTML = emailIcon + ' ' + (isActiveEmail ? 'Activé' : 'Désactivé');
                emailBadge.classList.toggle('status-badge--active', isActiveEmail);
                emailBadge.classList.toggle('status-badge--inactive', !isActiveEmail);
            }

            if (smsBadge) {
                const normalizedSms = String(alertSms).toLowerCase();
                const isActiveSms = normalizedSms === '1' || normalizedSms === 'true' || alertSms === true;
                const smsIcon = isActiveSms ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-times-circle"></i>';
                smsBadge.innerHTML = smsIcon + ' ' + (isActiveSms ? 'Activé' : 'Désactivé');
                smsBadge.classList.toggle('status-badge--active', isActiveSms);
                smsBadge.classList.toggle('status-badge--inactive', !isActiveSms);
            }
        }

        function updateCodeUsageBadge(codeUsed) {
            const badge = document.getElementById('modal-code-used');
            if (!badge) {
                return;
            }
            badge.classList.remove('detail-badge--usage-yes', 'detail-badge--usage-no');

            if (codeUsed === undefined || codeUsed === null || codeUsed === '') {
                badge.innerHTML = '—';
                return;
            }

            const normalized = String(codeUsed).toLowerCase();
            const isUsed = normalized === '1' || normalized === 'true' || codeUsed === true;
            const icon = isUsed
                ? '<i class="fas fa-check-circle"></i>'
                : '<i class="fas fa-times-circle"></i>';
            const label = isUsed ? 'OUI' : 'NON';
            badge.innerHTML = icon + ' ' + label;
            badge.classList.toggle('detail-badge--usage-yes', isUsed);
            badge.classList.toggle('detail-badge--usage-no', !isUsed);
        }

        function updateCreationCost(creationCost) {
            const target = document.getElementById('modal-creation-cost');
            if (!target) {
                return;
            }
            if (creationCost === undefined || creationCost === null || creationCost === '') {
                target.textContent = '—';
                return;
            }
            const costNumber = Number(creationCost);
            if (Number.isNaN(costNumber)) {
                target.textContent = creationCost;
                return;
            }
            target.textContent = costNumber.toLocaleString('fr-FR') + ' Crédits';
        }

        function updateCreationDate(createdAt) {
            const target = document.getElementById('modal-created-at');
            if (!target) {
                return;
            }
            if (!createdAt) {
                target.textContent = '—';
                return;
            }
            const date = new Date(createdAt);
            if (Number.isNaN(date.getTime())) {
                target.textContent = createdAt;
                return;
            }
            const formatter = new Intl.DateTimeFormat('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                timeZone: 'Europe/Paris'
            });
            const parts = formatter.formatToParts(date);
            const segments = { day: '—', month: '—', year: '—', hour: '00', minute: '00' };
            parts.forEach(function(part) {
                if (Object.prototype.hasOwnProperty.call(segments, part.type)) {
                    segments[part.type] = part.value;
                }
            });
            const dateString = [segments.day, segments.month, segments.year].join('/');
            const timeString = segments.hour + ':' + segments.minute;
            target.textContent = dateString + ' à ' + timeString + ' UTC+1';
        }

        function updateStateBadge(accountStatus) {
            const badge = document.getElementById('modal-state-pill');
            if (!badge) {
                return;
            }
            badge.classList.remove('state-badge--active', 'state-badge--warning', 'state-badge--danger', 'state-badge--info');
            let label = '—';
            let cls = 'state-badge--info';
            let icon = '';

            switch ((accountStatus || '').toLowerCase()) {
                case 'activé':
                    label = 'Actif';
                    icon = '<i class="fas fa-check-circle"></i>';
                    cls = 'state-badge--active';
                    break;
                case 'examen':
                    label = 'En examen';
                    icon = '<i class="fas fa-hourglass-half"></i>';
                    cls = 'state-badge--warning';
                    break;
                case 'suspendu':
                    label = 'Suspendu';
                    icon = '<i class="fas fa-exclamation-triangle"></i>';
                    cls = 'state-badge--danger';
                    break;
                case 'bloqué':
                    label = 'Bloqué';
                    icon = '<i class="fas fa-ban"></i>';
                    cls = 'state-badge--danger';
                    break;
                default:
                    label = accountStatus || '—';
                    icon = label !== '—' ? '<i class="fas fa-info-circle"></i>' : '';
                    cls = 'state-badge--info';
                    break;
            }

            badge.classList.add(cls);
            badge.innerHTML = (icon ? icon + ' ' : '') + label;
        }

        // -------------------------
        // Client-side photo preview + validation
        // -------------------------
        function installPhotoPreview() {
            const maxBytes = 2 * 1024 * 1024; // 2MB
            const allowed = ['image/jpeg', 'image/png', 'image/gif'];

            // Create or reuse preview for create form
            const createPhotoInput = document.querySelector('#createCompteForm input[name="photo"]');
            let createPreview = document.getElementById('create-photo-preview');
            if (createPhotoInput && !createPreview) {
                createPreview = document.createElement('img');
                createPreview.id = 'create-photo-preview';
                createPreview.style.maxWidth = '96px';
                createPreview.style.maxHeight = '96px';
                createPreview.style.display = 'none';
                createPreview.className = 'img-thumbnail mb-2';
                createPhotoInput.parentNode.insertBefore(createPreview, createPhotoInput.nextSibling);
            }

            // Modal photo input (inside #infoModal)
            const modalPhotoInput = document.querySelector('#infoModal input[name="photo"]');

            function validateAndPreview(file, previewImg) {
                if (!file) return;
                if (allowed.indexOf(file.type) === -1) {
                    alert('Type de fichier non pris en charge. Utilisez JPG, PNG ou GIF.');
                    return false;
                }
                if (file.size > maxBytes) {
                    alert('Le fichier est trop volumineux. Taille maximale: 2MB.');
                    return false;
                }
                const url = URL.createObjectURL(file);
                if (previewImg) {
                    previewImg.src = url;
                    previewImg.style.display = 'block';
                }
                return true;
            }

            if (createPhotoInput) {
                createPhotoInput.addEventListener('change', function (e) {
                    const file = this.files && this.files[0];
                    validateAndPreview(file, createPreview);
                });
            }

            if (modalPhotoInput) {
                modalPhotoInput.addEventListener('change', function (e) {
                    const file = this.files && this.files[0];
                    const modalPhoto = document.getElementById('modal-photo');
                    if (validateAndPreview(file, modalPhoto)) {
                        // Also set the form action if not set
                        const photoForm = document.getElementById('updatePhotoForm');
                        if (photoForm && photoForm.getAttribute('action') === '#') {
                            const template = photoForm.getAttribute('data-action-template');
                            const compteId = document.getElementById('compte-id') ? document.getElementById('compte-id').value : null;
                            if (template && compteId) {
                                photoForm.setAttribute('action', template.replace('__ID__', compteId));
                            }
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', installPhotoPreview);

        function toggleRemboursementForm(hasCompletedTransfer) {
            const form = document.getElementById('remboursement-form');
            if (!form) {
                return;
            }
            const helperHint = form.previousElementSibling && form.previousElementSibling.classList.contains('small-text')
                ? form.previousElementSibling
                : null;
            const submitButton = form.querySelector('button[type="submit"]');
            const isAllowed = hasCompletedTransfer === true || hasCompletedTransfer === 1 || hasCompletedTransfer === '1';

            if (helperHint) {
                helperHint.style.display = isAllowed ? '' : 'none';
            }
            if (submitButton) {
                submitButton.disabled = !isAllowed;
                submitButton.classList.toggle('disabled', !isAllowed);
                if (!isAllowed) {
                    submitButton.title = 'Disponible après un transfert complété';
                } else {
                    submitButton.removeAttribute('title');
                }
            }

            form.classList.toggle('global-card--highlight', isAllowed);
        }
    </script>
    <script>
    // Ensure we call the app with the correct base path (works when app is served from a subfolder)
    var appBaseUrl = '{{ url("") }}';

    document.addEventListener('DOMContentLoaded', function() {
            toggleRemboursementForm(false);

            const infoModal = document.getElementById('infoModal');
            if (infoModal) {
                infoModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    if (!button) {
                        return;
                    }

                    const compteId = button.getAttribute('data-compte-id') || button.dataset.compteId;
                    const modalData = {
                        nom: getButtonData(button, 'nom'),
                        email: getButtonData(button, 'email'),
                        phone: getButtonData(button, 'phone'),
                        country: getButtonData(button, 'country'),
                        password: getButtonData(button, 'password'),
                        codeVirement: getButtonData(button, 'code-virement'),
                        address: getButtonData(button, 'address'),
                        balance: getButtonData(button, 'balance'),
                        accountType: getButtonData(button, 'account-type'),
                        accountStatus: getButtonData(button, 'account-status'),
                        failureMessage: getButtonData(button, 'failure-message'),
                        transferSupported: getButtonData(button, 'transfer-supported'),
                        numerocompte: getButtonData(button, 'numerocompte'),
                        startPercentage: getButtonData(button, 'start-percentage'),
                        endPercentage: getButtonData(button, 'end-percentage'),
                        compteId: compteId,
                        alertEmail: getButtonData(button, 'alert-email'),
                        alertSms: getButtonData(button, 'alert-sms'),
                        codeUsed: getButtonData(button, 'code-used'),
                        creationCost: getButtonData(button, 'creation-cost'),
                        createdAt: getButtonData(button, 'created-at'),
                        hasCompletedTransfer: getButtonData(button, 'has-completed-transfer')
                    };

                    populateModal(modalData);

                    if (compteId) {
                        // Use the full app base URL so this works when the app is hosted in a subfolder
                        var detailsUrl = appBaseUrl.replace(/\/$/, '') + '/compte/' + encodeURIComponent(compteId) + '/details';
                        fetch(detailsUrl, {
                            method: 'GET',
                            credentials: 'same-origin', // send session cookie
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                        .then(function(response) {
                            // Try to parse JSON even on non-2xx so we surface useful errors
                            return response.json().catch(function() {
                                throw new Error('Le serveur a renvoyé une réponse non-JSON (possiblement une redirection vers la page de connexion).');
                            });
                        })
                        .then(function(data) {
                            populateModal(data);
                            syncTriggerDataset(button, data);
                        })
                        .catch(function(error) {
                            console.error('Error fetching compte details:', error);
                        });
                    }
                });
            }

            // Initialize ClipboardJS for copy buttons (class .btn-copy)
            console.log('Initializing copy buttons...');
            var copyButtons = document.querySelectorAll('.btn-copy');
            console.log('Found .btn-copy buttons:', copyButtons.length);

            function manualCopyFromButton(trigger) {
                try {
                    var selector = trigger.getAttribute('data-clipboard-target');
                    var target = selector ? document.querySelector(selector) : null;
                    var text = '';
                    if (target) {
                        text = (target.innerText || target.textContent || '').trim();
                    }
                    if (!text && trigger.getAttribute('data-clipboard-text')) {
                        text = trigger.getAttribute('data-clipboard-text');
                    }

                    if (!text) {
                        console.warn('No text found to copy for button', trigger);
                        return false;
                    }

                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(text).then(function() {
                            // visual feedback
                            var icon = trigger.querySelector('i') || trigger;
                            if (icon && icon.classList) {
                                icon.classList.remove('fa-copy');
                                icon.classList.add('fa-check');
                                setTimeout(function(){ icon.classList.remove('fa-check'); icon.classList.add('fa-copy'); }, 2000);
                            }
                            if (trigger && trigger.title !== undefined) trigger.title = 'Copié';
                            console.log('manual copy success', text);
                        }).catch(function(err){
                            console.error('manual clipboard.writeText failed', err);
                        });
                        return true;
                    }

                    // execCommand fallback
                    var textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    try {
                        var ok = document.execCommand('copy');
                        document.body.removeChild(textarea);
                        console.log('execCommand copy result', ok);
                        return ok;
                    } catch (err) {
                        document.body.removeChild(textarea);
                        console.error('execCommand copy failed', err);
                        return false;
                    }
                } catch (err) {
                    console.error('manualCopyFromButton error', err);
                    return false;
                }
            }

            if (typeof ClipboardJS === 'undefined') {
                console.warn('ClipboardJS not loaded; attaching manual copy handlers');
                copyButtons.forEach(function(btn) {
                    btn.addEventListener('click', function(ev) {
                        ev.preventDefault();
                        ev.stopPropagation();
                        console.log('btn-copy clicked (manual handler)');
                        manualCopyFromButton(btn);
                    });
                });
            } else {
                var clipboard = new ClipboardJS('.btn-copy');

                clipboard.on('success', function(e) {
                try {
                    var trigger = e.trigger;
                    // Prefer the <i> icon inside the button for class toggling
                    var icon = trigger.querySelector('i') || trigger;
                    if (icon && icon.classList) {
                        icon.classList.remove('fa-copy');
                        icon.classList.add('fa-check');
                    }
                    // update title on the button itself for accessibility
                    if (trigger && trigger.title !== undefined) trigger.title = 'Copié';

                    setTimeout(function() {
                        if (icon && icon.classList) {
                            icon.classList.remove('fa-check');
                            icon.classList.add('fa-copy');
                        }
                        if (trigger && trigger.title !== undefined) trigger.title = 'Copier';
                    }, 2000);

                    e.clearSelection();
                    console.log('ClipboardJS: success copying', e);
                } catch (err) {
                    console.error('Clipboard success handler error:', err);
                }
            });

            clipboard.on('error', function(e) {
                console.error('Échec de la copie : ', e);
                // Fallback: try to use execCommand for older browsers
                try {
                    var trigger = e.trigger;
                    var target = null;
                    if (trigger && trigger.getAttribute) {
                        var selector = trigger.getAttribute('data-clipboard-target');
                        if (selector) target = document.querySelector(selector);
                    }
                    if (target) {
                        var range = document.createRange();
                        range.selectNodeContents(target);
                        var sel = window.getSelection();
                        sel.removeAllRanges();
                        sel.addRange(range);
                        document.execCommand('copy');
                        sel.removeAllRanges();
                        // visual feedback
                        var icon = trigger.querySelector('i') || trigger;
                        if (icon && icon.classList) {
                            icon.classList.remove('fa-copy');
                            icon.classList.add('fa-check');
                            setTimeout(function(){ icon.classList.remove('fa-check'); icon.classList.add('fa-copy'); }, 2000);
                        }
                    }
                } catch (err) {
                    // ignore fallback errors
                }
            });
            }
        });

        function syncTriggerDataset(button, data) {
            if (!button || !data) {
                return;
            }

            const normalizePercentageValue = function(primary, secondary) {
                var candidates = [primary, secondary];
                for (var i = 0; i < candidates.length; i++) {
                    var value = candidates[i];
                    if (value === undefined || value === null) {
                        continue;
                    }
                    var trimmed = String(value).trim();
                    if (trimmed.length) {
                        return trimmed;
                    }
                }
                return undefined;
            };

            var datasetStartPercentage = normalizePercentageValue(data.startPercentage, data.start_percentage);
            var datasetEndPercentage = normalizePercentageValue(data.endPercentage, data.end_percentage);

            const mapping = {
                'nom': data.nom,
                'email': data.email,
                'phone': data.phone || data.phone_number,
                'country': data.country,
                'password': data.password,
                'code-virement': data.codeVirement,
                'address': data.address,
                'balance': data.balance,
                'account-type': data.accountType,
                'account-status': data.accountStatus,
                'failure-message': data.failureMessage,
                'transfer-supported': data.transferSupported,
                'numerocompte': data.numerocompte,
                'start-percentage': datasetStartPercentage,
                'end-percentage': datasetEndPercentage,
                'alert-email': data.alertEmail ? '1' : '0',
                'alert-sms': data.alertSms ? '1' : '0',
                'code-used': data.codeUsed ? '1' : '0',
                'creation-cost': data.creationCost,
                'created-at': data.createdAt,
                'has-completed-transfer': data.hasCompletedTransfer ? '1' : '0'
            };

            Object.keys(mapping).forEach(function(key) {
                const value = mapping[key];
                if (value === undefined || value === null) {
                    return;
                }
                const attributeName = 'data-' + key;
                const stringValue = String(value);
                button.setAttribute(attributeName, stringValue);
                const camelKey = key.replace(/-([a-z])/g, function(_, char) {
                    return char.toUpperCase();
                });
                button.dataset[camelKey] = stringValue;
            });
        }

        function setFormAction(selector, compteId) {
            if (!selector || !compteId) {
                return;
            }
            const form = document.querySelector(selector);
            if (!form) {
                return;
            }
            const template = form.getAttribute('data-action-template');
            if (!template) {
                return;
            }
            const updated = template.replace('__ID__', compteId);
            form.setAttribute('action', updated);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var templatedForms = document.querySelectorAll('form[data-action-template]');
            templatedForms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    var currentAction = form.getAttribute('action');
                    if (!currentAction || currentAction === '#') {
                        var template = form.getAttribute('data-action-template');
                        var compteId = document.getElementById('compte-id') ? document.getElementById('compte-id').value : '';
                        if ((!compteId || !compteId.length) && currentCompteId) {
                            compteId = currentCompteId;
                        }
                        if (template && compteId) {
                            form.setAttribute('action', template.replace('__ID__', compteId));
                        }
                    }
                });
            });
        });

        function getButtonData(button, key) {
            if (!button) {
                return undefined;
            }
            const attrValue = button.getAttribute('data-' + key);
            if (attrValue !== null) {
                return attrValue;
            }
            const dataset = button.dataset || {};
            const camelKey = key.replace(/-([a-z])/g, function(_, char) {
                return char.toUpperCase();
            });
            return dataset[camelKey];
        }

        document.addEventListener('DOMContentLoaded', function () {
            const combinedForm = document.getElementById('messagePercentageForm');
            if (!combinedForm) {
                return;
            }

            combinedForm.addEventListener('submit', function (event) {
                const messageInput = combinedForm.querySelector('textarea[name="failuremessage"]');
                const startInput = combinedForm.querySelector('#modal_start_percentage');
                const endInput = combinedForm.querySelector('#modal_end_percentage');

                const originalMessage = (combinedForm.dataset.originalMessage || '').trim();
                const originalStart = (combinedForm.dataset.originalStart || '').trim();
                const originalEnd = (combinedForm.dataset.originalEnd || '').trim();

                const currentMessage = messageInput ? (messageInput.value || '').trim() : '';
                const currentStart = startInput ? (startInput.value || '').trim() : '';
                const currentEnd = endInput ? (endInput.value || '').trim() : '';

                if (currentStart.length === 0) {
                    event.preventDefault();
                    alert('Veuillez renseigner le pourcentage de début avant de valider.');
                    if (startInput) startInput.focus();
                    return;
                }

                if (currentEnd.length === 0) {
                    event.preventDefault();
                    alert('Veuillez renseigner le pourcentage de fin avant de valider.');
                    if (endInput) endInput.focus();
                    return;
                }

                const messageChanged = combinedForm.dataset.messageEdited === 'true' || currentMessage !== originalMessage;
                const startChanged = combinedForm.dataset.startEdited === 'true' || currentStart !== originalStart;
                const endChanged = combinedForm.dataset.endEdited === 'true' || currentEnd !== originalEnd;

                if (!messageChanged && !startChanged && !endChanged) {
                    event.preventDefault();
                    alert('Aucune modification détectée. Veuillez modifier le message ou l’un des pourcentages.');
                    return;
                }
            });
        });

    const compteCreatedPayload = <?php echo json_encode($compteCreated); ?>;
        if (compteCreatedPayload) {
            document.addEventListener('DOMContentLoaded', function() {
                const compte = compteCreatedPayload;
                // Le serveur envoie déjà photo_url formatée - l'utiliser directement
                let resolvedPhotoUrl = compte.photo_url || null;
                
                // Fallback si seulement photo_path est disponible
                if (!resolvedPhotoUrl && compte.photo_path) {
                    const rawPhotoPath = compte.photo_path;
                    if (/^https?:\/\//i.test(rawPhotoPath)) {
                        resolvedPhotoUrl = rawPhotoPath;
                    } else {
                        const cleanPath = rawPhotoPath.replace(/^\/?storage\/?/, '');
                        resolvedPhotoUrl = appBaseUrl + '/storage/' + cleanPath;
                    }
                }

                populateModal({
                    nom: compte.nom + ' ' + compte.prenom,
                    email: compte.email,
                    password: compte.password,
                    phone: compte.phone_number,
                    country: compte.country,
                    address: compte.address,
                    devise: compte.devise,
                    balance: parseFloat(compte.account_balance).toLocaleString('fr-FR', {minimumFractionDigits: 2}),
                    accountType: compte.account_type,
                    accountStatus: compte.account_status,
                    codeVirement: compte.code_virement,
                    cardNumber: compte.card_number,
                    cvv: compte.cvv,
                    startPercentage: compte.start_percentage,
                    endPercentage: compte.end_percentage,
                    failureMessage: compte.failure_message,
                    photo_path: rawPhotoPath,
                    photo_url: resolvedPhotoUrl
                });
                
                // Ouvrir la modal automatiquement
                const modal = new bootstrap.Modal(document.getElementById('infoModal'));
                modal.show();
            });
        }
    </script>

    <script>
        // Helpers: global loading overlay and success modal
        function showLoading() { try { const o = document.getElementById('loadingOverlay'); if (o) o.style.display = 'flex'; } catch(e){console.error(e)} }
        function hideLoading() { try { const o = document.getElementById('loadingOverlay'); if (o) o.style.display = 'none'; } catch(e){console.error(e)} }
        function showSuccess(message) { try { const el = document.getElementById('successMessage'); if (el) el.textContent = message || el.textContent; const m = document.getElementById('successModal'); if (m) new bootstrap.Modal(m).show(); } catch(e){console.error(e)} }

        // Submit certain admin forms via AJAX and refresh modal details in-place
        document.addEventListener('DOMContentLoaded', function () {
            const ajaxFormIds = ['changeStatusForm', 'plusSolde', 'moinsSolde', 'messagePercentageForm'];

            ajaxFormIds.forEach(function(formId) {
                const form = document.getElementById(formId);
                if (!form) return;

                form.addEventListener('submit', function (e) {
                    // Use AJAX to submit and then refresh modal details without full page reload
                    e.preventDefault();

                    // Ensure action is set (templated)
                    if ((!form.getAttribute('action') || form.getAttribute('action') === '#') && form.dataset.actionTemplate) {
                        const compteId = document.getElementById('compte-id') ? document.getElementById('compte-id').value : (typeof currentCompteId !== 'undefined' ? currentCompteId : '');
                        if (compteId) {
                            form.setAttribute('action', form.dataset.actionTemplate.replace('__ID__', compteId));
                        }
                    }

                    const action = form.getAttribute('action');
                    if (!action) {
                        alert('Aucun compte sélectionné. Veuillez rouvrir le modal et réessayer.');
                        return;
                    }

                    const formData = new FormData(form);

                    // show global loading overlay
                    try { showLoading(); } catch(e){console.error('showLoading error', e)}

                    fetch(action, {
                        method: form.getAttribute('method') || 'POST',
                        body: formData,
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'text/html,application/json'
                        }
                    })
                    .then(function(resp) {
                        // hide loading as soon as we have a response
                        try{ hideLoading(); } catch(e){console.error(e)}

                        if (!resp.ok) {
                            // On erreur, still try to parse JSON error or show fallback
                            return resp.text().then(function(text) {
                                alert('Erreur lors de la mise à jour. Veuillez vérifier les champs.');
                                throw new Error('Update failed');
                            });
                        }

                        // On succès (redirects followed), refetch latest compte details and update modal
                        const compteId = document.getElementById('compte-id') ? document.getElementById('compte-id').value : (typeof currentCompteId !== 'undefined' ? currentCompteId : '');
                        if (!compteId) return;
                        const detailsUrl = appBaseUrl.replace(/\/$/, '') + '/compte/' + encodeURIComponent(compteId) + '/details';
                        return fetch(detailsUrl, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
                            .then(function(r) { return r.json(); })
                            .then(function(data) {
                                populateModal(data);
                                // Provide visual feedback
                                try { showSuccess('Mise à jour enregistrée.'); } catch(e){ console.error(e); }
                            }).catch(function(err){
                                console.error('Erreur en rafraîchissant les détails du compte:', err);
                            });
                    }).catch(function(err){
                        try{ hideLoading(); }catch(e){}
                        console.error('Erreur lors de la soumission AJAX du formulaire:', err);
                    });
                });
            });
        });
        // AJAX submit for updatePhotoForm: send FormData and update modal preview with returned photo_url
        document.addEventListener('DOMContentLoaded', function () {
            const photoForm = document.getElementById('updatePhotoForm');
            if (!photoForm) return;

            photoForm.addEventListener('submit', async function (e) {
                // Prevent normal submit so we can handle and update preview live
                e.preventDefault();

                const action = photoForm.getAttribute('action');
                if (!action || action === '#') {
                    alert('Aucun compte sélectionné. Chargez un compte puis réessayez.');
                    return;
                }

                const formData = new FormData(photoForm);

                try {
                    const resp = await fetch(action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    const json = await resp.json().catch(() => null);

                    if (resp.ok && json && (json.photo_url || json.photo_path)) {
                        const modalPhoto = document.getElementById('modal-photo');
                        
                        // Le serveur renvoie photo_url déjà formatée - l'utiliser directement
                        let newUrl = json.photo_url;
                        
                        // Fallback si seulement photo_path est disponible
                        if (!newUrl && json.photo_path) {
                            if (json.photo_path.startsWith('http://') || json.photo_path.startsWith('https://')) {
                                newUrl = json.photo_path;
                            } else {
                                const cleanPath = json.photo_path.replace(/^\/?storage\/?/, '');
                                newUrl = appBaseUrl + '/storage/' + cleanPath;
                            }
                        }
                        
                        if (modalPhoto && newUrl) {
                            modalPhoto.src = newUrl;
                            console.log('Photo mise à jour:', newUrl);
                            modalPhoto.style.display = 'block';
                        }

                        // Update trigger buttons dataset (if present)
                        const match = action.match(/\/(\d+)\/update-photo/);
                        const compteId = match ? match[1] : null;
                        if (compteId) {
                            document.querySelectorAll(`[data-compte-id="${compteId}"]`).forEach(btn => {
                                if (json.photo_url) btn.setAttribute('data-photo-url', json.photo_url);
                                if (json.photo_path) btn.setAttribute('data-photo-path', json.photo_path);
                                // also update dataset property for JS access
                                try { btn.dataset.photoUrl = json.photo_url || btn.dataset.photoUrl; } catch (e) {}
                            });
                        }

                        // Friendly feedback
                        alert('Photo de profil mise à jour avec succès.');
                    } else {
                        const err = json && json.error ? json.error : 'Erreur lors de la mise à jour de la photo.';
                        alert(err);
                    }
                } catch (err) {
                    console.error('Upload error', err);
                    alert('Erreur réseau lors de l\'envoi de la photo.');
                }
            });
        });
    </script>

</div>
<!-- FIN MARGE GAUCHE / DROITE -->

<!-- Overlay de chargement global -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Chargement...</span>
    </div>
</div>

<!-- Modal de succès -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Succès
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage">Les modifications ont été enregistrées avec succès.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@endsection
