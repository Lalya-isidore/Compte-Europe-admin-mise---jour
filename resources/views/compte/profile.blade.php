@extends('layouts.admin')

@section('title', 'Mon compte')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item active">Mon compte</li>
    </ol>
@endsection

@section('content')
<x-tool-back-link label="Retour à la liste des outils" :fallback="route('dashboard')" />

@php
    $fullName = trim($profile['full_name'] ?? ($user->prenom . ' ' . $user->nom));
    $fullNameUpper = $fullName ? mb_strtoupper($fullName, 'UTF-8') : '—';
    $emailValue = $profile['email'] ?? $user->email ?? '—';
    $phoneValue = $profile['phone'] ?? '—';
    $countryValue = $profile['country'] ?? '—';
    $signupDate = $profile['signup_date'] ?? null;
    $lastLogin = $profile['last_login'] ?? null;
    $lastLoginTimezoneLabel = $profile['last_login_timezone_label'] ?? 'UTC';
    $statusLabel = $profile['status_label'] ?? 'Inactif';
    $statusVariant = $profile['status_variant'] ?? 'secondary';
@endphp

<style>
    .account-overview {
        max-width: 1200px;
        margin: 0 auto;
    }
    .account-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 18px 35px rgba(15, 23, 42, 0.12);
        border: 1px solid rgba(99, 102, 241, 0.08);
        height: 100%;
    }
    .account-card__title {
        font-size: 1.2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }
    .account-card__title i {
        font-size: 1.25rem;
        color: #6366f1;
    }
    .info-line {
        margin-bottom: 1.1rem;
    }
    .info-line__label {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.35rem;
        font-size: 0.95rem;
    }
    .info-line__value {
        display: inline-block;
        background: #f1f5f9;
        border-radius: 10px;
        padding: 0.55rem 0.9rem;
        font-weight: 600;
        color: #0f172a;
        letter-spacing: 0.3px;
    }
    .affiliate-pill {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
        background: #f8fafc;
        border-radius: 12px;
        padding: 0.65rem 0.9rem;
        font-weight: 600;
        color: #0f172a;
        word-break: break-all;
        border: 1px solid rgba(148, 163, 184, 0.4);
        position: relative;
    }
    .affiliate-pill__link a {
        text-decoration: none;
        color: #0f172a;
        word-break: break-all;
    }
    .affiliate-copy-input {
        position: absolute;
        left: -9999px;
        opacity: 0;
        pointer-events: none;
    }
    .account-actions {
        margin-top: 2rem;
    }
    .account-actions .btn-danger {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 999px;
    }
    .status-badge {
        border-radius: 999px;
        padding: 0.4rem 1.2rem;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>

<div class="account-overview container-fluid px-lg-4 px-3 py-4">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="account-card">
                <div class="account-card__title">
                    <i class="fas fa-user-circle"></i> Utilisateur
                </div>
                <div class="info-line">
                    <div class="info-line__label">Nom Prénom :</div>
                    <div class="info-line__value">{{ $fullNameUpper }}</div>
                </div>
                <div class="info-line">
                    <div class="info-line__label">Adresse e-mail :</div>
                    <div class="info-line__value text-uppercase">{{ mb_strtoupper($emailValue, 'UTF-8') }}</div>
                </div>
                <div class="info-line">
                    <div class="info-line__label">Numéro de téléphone :</div>
                    <div class="info-line__value">{{ $phoneValue }}</div>
                </div>
                <div class="info-line">
                    <div class="info-line__label">Pays de résidence :</div>
                    <div class="info-line__value">{{ $countryValue }}</div>
                </div>
                <div class="account-actions">
                    @php
                        // The delete action removes the user and all related data.
                        // Use the authenticated user's id as the target to ensure
                        // pressing the button deletes the user even if no compte exists.
                        $deleteTargetId = $user->id ?? Auth::id();
                    @endphp
                    <form action="{{ route('user.destroy', $deleteTargetId) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte et toutes les données associées ? Cette action est définitive.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Supprimer mon compte
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="account-card">
                <div class="account-card__title">
                    <i class="fas fa-user-friends"></i> Affiliation et Autres
                </div>
                <div class="info-line">
                    <div class="info-line__label">Date d'inscription (UTC+1) :</div>
                    <div class="info-line__value">
                        {{ $signupDate ? (\Carbon\Carbon::parse($signupDate)->setTimezone('Europe/Paris')->format('d/m/Y à H:i')) : '—' }}
                    </div>
                </div>
                <div class="info-line">
                    <div class="info-line__label">Dernière connexion ({{ $lastLoginTimezoneLabel }}) :</div>
                    <div class="info-line__value">
                        {{ $lastLogin ? $lastLogin->format('d/m/Y à H:i') : '—' }}
                    </div>
                </div>
                <div class="info-line">
                    <div class="info-line__label">Lien d'affiliation personnel :</div>
                    @if(!empty($profile['affiliation_link']))
                        <div class="affiliate-pill">
                            <i class="fas fa-link text-primary"></i>
                            <div class="affiliate-pill__link">
                                <a href="{{ $profile['affiliation_link'] }}" target="_blank" rel="noopener">
                                    {{ $profile['affiliation_link'] }}
                                </a>
                            </div>
                            <textarea id="affiliate-link-input" class="affiliate-copy-input" readonly>{{ $profile['affiliation_link'] }}</textarea>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="copyAffiliateLink(this)" data-link="{{ $profile['affiliation_link'] }}" data-target="#affiliate-link-input">
                                Copier
                            </button>
                            <small class="text-muted copy-feedback ms-1 d-none">Copié !</small>
                        </div>
                    @else
                        <span class="affiliate-pill">
                            <i class="fas fa-info-circle text-primary me-1"></i>
                            Rendez-vous dans la page Affiliation pour copier votre lien.
                            <a href="{{ route('affiliation.index') }}" class="ms-1 text-primary fw-semibold">Ouvrir Affiliation</a>
                        </span>
                    @endif
                </div>
                <div class="info-line">
                    <div class="info-line__label">Status du compte :</div>
                    <span class="badge bg-{{ $statusVariant }} status-badge">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyAffiliateLink(button) {
        if (!button) {
            return;
        }

        const targetSelector = button.getAttribute('data-target');
        const targetInput = targetSelector ? document.querySelector(targetSelector) : null;
        const fallbackLink = button.getAttribute('data-link');
        const textToCopy = targetInput
            ? (targetInput.value || targetInput.textContent || '')
            : (fallbackLink || '');

        if (!textToCopy) {
            console.error('Aucun texte à copier');
            return;
        }

        const showFeedback = function () {
            const feedback = button.parentElement ? button.parentElement.querySelector('.copy-feedback') : null;
            if (feedback) {
                feedback.classList.remove('d-none');
                setTimeout(function () {
                    feedback.classList.add('d-none');
                }, 2000);
            }
        };

        const copyWithClipboard = function () {
            if (!navigator.clipboard || !navigator.clipboard.writeText || !window.isSecureContext) {
                return Promise.reject();
            }
            return navigator.clipboard.writeText(textToCopy);
        };

        const copyWithFallback = function () {
            return new Promise(function (resolve, reject) {
                try {
                    const helper = document.createElement('textarea');
                    helper.value = textToCopy;
                    helper.setAttribute('readonly', '');
                    helper.style.position = 'absolute';
                    helper.style.left = '-9999px';
                    document.body.appendChild(helper);
                    helper.select();
                    helper.setSelectionRange(0, helper.value.length);
                    const copied = document.execCommand('copy');
                    document.body.removeChild(helper);
                    if (copied) {
                        resolve();
                    } else {
                        reject(new Error('execCommand failed'));
                    }
                } catch (error) {
                    reject(error);
                }
            });
        };

        copyWithClipboard()
            .catch(copyWithFallback)
            .then(showFeedback)
            .catch(function (error) {
                console.error('Impossible de copier le lien', error);
            });
    }
</script>
@endpush
@endsection
