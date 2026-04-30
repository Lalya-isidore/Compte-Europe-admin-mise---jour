<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Flash Compte Pro — Outils bancaires professionnels | FlashBilan</title>
    <meta name="description" content="Flash Compte Pro : créez des relevés de compte européens professionnels en quelques secondes. SMS Pro, Contrat de Prêt PDF, Vérification IBAN, QR Code et bien plus. Essayez gratuitement sur FlashBilan.">
    <meta name="keywords" content="flash compte, flash compte pro, compte européen, relevé bancaire, SMS Pro, contrat de prêt, vérification IBAN, FlashBilan, outils bancaires, générateur compte">
    <meta name="author" content="FlashBilan">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Flash Compte Pro — Outils bancaires professionnels | FlashBilan">
    <meta property="og:description" content="Créez des relevés de compte européens, envoyez des SMS Pro, générez des contrats de prêt PDF. Outils professionnels pour particuliers et entreprises.">
    <meta property="og:image" content="{{ asset('images/og-preview1.png') }}">
    <meta property="og:site_name" content="FlashBilan">
    <meta property="og:locale" content="fr_FR">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Flash Compte Pro — Outils bancaires | FlashBilan">
    <meta name="twitter:description" content="Flash Compte Pro, SMS Pro, Contrat de Prêt PDF et plus. Outils professionnels sur FlashBilan.">
    <meta name="twitter:image" content="{{ asset('images/og-preview1.png') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon-192.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cabin:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color: #1e293b; }

        /* NAV */
        .lp-nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0 1.5rem;
            height: 68px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .lp-nav__logo {
            font-size: 1.4rem; font-weight: 800; text-decoration: none; color: #1e293b;
            display: flex; align-items: center; gap: 10px;
        }
        .lp-nav__logo span { color: #f59e0b; }
        .lp-nav__logo-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, #f59e0b, #10b981);
            display: flex; align-items: center; justify-content: center;
        }
        .lp-nav__logo-icon svg { width: 22px; height: 22px; }
        .lp-nav__logo img { height: 36px !important; width: auto !important; max-width: none !important; }
        .lp-nav__actions { display: flex; align-items: center; gap: 10px; }
        .lp-nav__toggle {
            display: none; background: none; border: none; cursor: pointer;
            padding: 6px; border-radius: 8px; color: #334155;
        }
        .lp-nav__toggle svg { width: 26px; height: 26px; display: block; }
        .btn-login {
            padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
            border: 1.5px solid #e2e8f0; background: #fff; color: #334155; text-decoration: none;
            transition: all 0.2s;
        }
        .btn-login:hover { border-color: #94a3b8; color: #1e293b; }
        .btn-signup {
            padding: 0.5rem 1.25rem; border-radius: 8px; font-weight: 600; font-size: 0.9rem;
            background: linear-gradient(135deg, #f59e0b, #10b981); color: #fff; text-decoration: none;
            border: none; transition: all 0.2s;
        }
        .btn-signup:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

        /* HERO */
        .lp-hero {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0f4c75 100%);
            color: #fff; padding: 5rem 1.5rem 4rem; text-align: center; position: relative; overflow: hidden;
        }
        .lp-hero::before {
            content: ''; position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse at 50% 0%, rgba(245,158,11,0.18) 0%, transparent 70%);
        }
        .lp-hero__badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.35);
            color: #fbbf24; border-radius: 999px; padding: 0.35rem 1rem;
            font-size: 0.8rem; font-weight: 600; letter-spacing: 0.04em;
            text-transform: uppercase; margin-bottom: 1.5rem;
        }
        .lp-hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; line-height: 1.15;
            margin-bottom: 1.25rem; position: relative;
        }
        .lp-hero h1 .accent { color: #fbbf24; }
        .lp-hero__sub {
            font-size: clamp(1rem, 2vw, 1.2rem); color: rgba(255,255,255,0.72);
            max-width: 620px; margin: 0 auto 2.5rem; line-height: 1.7;
        }
        .lp-hero__cta { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .btn-hero-primary {
            padding: 0.9rem 2rem; border-radius: 12px; font-weight: 700; font-size: 1rem;
            background: linear-gradient(135deg, #f59e0b, #10b981); color: #fff;
            text-decoration: none; transition: all 0.25s; border: none;
            box-shadow: 0 8px 24px rgba(245,158,11,0.35);
        }
        .btn-hero-primary:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 12px 30px rgba(245,158,11,0.45); }
        .btn-hero-secondary {
            padding: 0.9rem 2rem; border-radius: 12px; font-weight: 600; font-size: 1rem;
            background: rgba(255,255,255,0.08); border: 1.5px solid rgba(255,255,255,0.2);
            color: #fff; text-decoration: none; transition: all 0.25s;
        }
        .btn-hero-secondary:hover { background: rgba(255,255,255,0.15); color: #fff; }

        /* STATS */
        .lp-stats {
            background: #fff; border-bottom: 1px solid #e2e8f0;
            padding: 2rem 1.5rem;
        }
        .lp-stats__grid {
            max-width: 900px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; text-align: center;
        }
        .lp-stat__num { font-size: 1.9rem; font-weight: 800; color: #0f172a; }
        .lp-stat__label { font-size: 0.8rem; color: #64748b; margin-top: 2px; }

        /* SECTIONS */
        .lp-section { padding: 4rem 1.5rem; }
        .lp-section__inner { max-width: 1100px; margin: 0 auto; }
        .lp-section__tag {
            display: inline-block; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em;
            text-transform: uppercase; color: #f59e0b; background: rgba(245,158,11,0.1);
            border-radius: 999px; padding: 0.3rem 0.9rem; margin-bottom: 0.75rem;
        }
        .lp-section__tag.green { color: #10b981; background: rgba(16,185,129,0.1); }
        .lp-section h2 {
            font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 800; margin-bottom: 0.5rem; color: #0f172a;
        }
        .lp-section__desc { color: #64748b; font-size: 1rem; margin-bottom: 2.5rem; max-width: 580px; }

        /* TOOLS GRID */
        .tools-lp-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem;
        }
        .tool-lp-card {
            background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
            padding: 1.5rem 1rem; text-align: center; text-decoration: none; color: #1e293b;
            transition: all 0.22s; position: relative; display: flex; flex-direction: column;
            align-items: center; gap: 0.75rem;
        }
        .tool-lp-card:hover {
            border-color: #f59e0b; box-shadow: 0 8px 24px rgba(245,158,11,0.12);
            transform: translateY(-4px); color: #1e293b;
        }
        .tool-lp-card img { width: 56px; height: 56px; object-fit: contain; }
        .tool-lp-card__name { font-size: 0.85rem; font-weight: 600; line-height: 1.3; }
        .tool-lp-card__badge {
            position: absolute; top: 10px; left: 10px; z-index: 2;
            font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 4px;
            text-transform: uppercase; letter-spacing: 0.03em;
        }
        .badge-new { background: #2196F3; color: #fff; }
        .badge-soon { background: #fbbf24; color: #7c2d12; }
        .badge-free { background: #10b981; color: #fff; }

        /* WHY */
        .lp-why { background: #fff; }
        .why-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        .why-card {
            background: #f8fafc; border-radius: 16px; padding: 2rem; border: 1px solid #e2e8f0;
        }
        .why-card__icon {
            width: 52px; height: 52px; border-radius: 14px; font-size: 1.4rem;
            display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;
        }
        .why-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 0.5rem; }
        .why-card p { font-size: 0.88rem; color: #64748b; line-height: 1.6; }

        /* CTA BOTTOM */
        .lp-cta {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            color: #fff; text-align: center; padding: 5rem 1.5rem;
        }
        .lp-cta h2 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; margin-bottom: 1rem; }
        .lp-cta p { color: rgba(255,255,255,0.7); font-size: 1.05rem; margin-bottom: 2rem; }

        /* FOOTER */
        .lp-footer {
            background: #0f172a; color: rgba(255,255,255,0.45);
            text-align: center; padding: 1.5rem; font-size: 0.82rem;
        }
        .lp-footer a { color: rgba(255,255,255,0.6); text-decoration: none; }
        .lp-footer a:hover { color: #fbbf24; }

        /* TABLET (≤ 1024px) */
        @media (max-width: 1024px) {
            .tools-lp-grid { grid-template-columns: repeat(3, 1fr); }
            .why-grid { gap: 1.25rem; }
        }

        /* MOBILE (≤ 768px) */
        @media (max-width: 768px) {
            .lp-nav { padding: 0.75rem 1rem; position: relative; }
            .lp-nav__logo-text { font-size: 1.2rem; }
            .lp-nav__toggle { display: block; }
            .lp-nav__actions {
                display: none; flex-direction: column; align-items: stretch;
                position: absolute; top: calc(100% + 8px); right: 1rem;
                width: 200px;
                background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
                box-shadow: 0 8px 28px rgba(0,0,0,0.13);
                padding: 0.65rem; gap: 6px; z-index: 99;
            }
            .lp-nav__actions.open { display: flex; }
            .btn-login { border-radius: 10px; text-align: center; font-size: 0.9rem; padding: 0.6rem 1rem; }
            .btn-signup { border-radius: 10px; text-align: center; font-size: 0.9rem; padding: 0.6rem 1rem; }

            .lp-hero { padding: 3rem 1.25rem 2.5rem; }
            .lp-hero__badge { font-size: 0.72rem; padding: 0.3rem 0.85rem; }
            .lp-hero__cta { flex-direction: column; align-items: stretch; gap: 10px; padding: 0 1rem; }
            .btn-hero-primary, .btn-hero-secondary { text-align: center; justify-content: center; font-size: 0.88rem; padding: 0.65rem 1.25rem; }

            .lp-stats { padding: 1.5rem 1rem; }
            .lp-stats__grid { grid-template-columns: repeat(2, 1fr); gap: 1.25rem; }
            .lp-stat__num { font-size: 1.6rem; }

            .lp-section { padding: 2.5rem 1rem; }
            .tools-lp-grid { grid-template-columns: repeat(2, 1fr); gap: 0.75rem; }
            .tool-lp-card { padding: 1.1rem 0.6rem; gap: 0.5rem; border-radius: 12px; }
            .tool-lp-card img { width: 46px; height: 46px; }
            .tool-lp-card__name { font-size: 0.78rem; }

            .why-grid { grid-template-columns: 1fr; gap: 0.85rem; }
            .why-card { padding: 1.25rem; }

            .lp-cta { padding: 3rem 1.25rem; }
            .lp-cta p { font-size: 0.95rem; }
        }

        /* PETIT MOBILE (≤ 400px) */
        @media (max-width: 400px) {
            .lp-nav__logo-text { font-size: 1rem; }
            .lp-hero h1 { font-size: 1.75rem; }
            .lp-hero__sub { font-size: 0.92rem; }
            .tools-lp-grid { gap: 0.55rem; }
            .tool-lp-card { padding: 0.9rem 0.4rem; border-radius: 10px; }
            .tool-lp-card img { width: 38px; height: 38px; }
            .tool-lp-card__name { font-size: 0.72rem; }
            .tool-lp-card__badge { font-size: 0.58rem; padding: 1px 5px; }
            .lp-stat__num { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

{{-- NAV --}}
<nav class="lp-nav">
    <a href="{{ url('/') }}" class="lp-nav__logo">
        <img src="{{ asset('images/logo-final-premium.png') }}" alt="FlashBilan Logo" style="display: block;">
    </a>
    <button class="lp-nav__toggle" id="navToggle" aria-label="Menu">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
            <line x1="3" y1="6" x2="21" y2="6"/>
            <line x1="3" y1="12" x2="21" y2="12"/>
            <line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
    <div class="lp-nav__actions" id="navActions">
        <a href="{{ route('connexion') }}" class="btn-login">↪ Se connecter</a>
        <a href="{{ route('inscription') }}" class="btn-signup"><i class="fas fa-user-plus me-1"></i> S'inscrire</a>
    </div>
</nav>
<script>
    document.getElementById('navToggle').addEventListener('click', function () {
        document.getElementById('navActions').classList.toggle('open');
    });
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#navToggle') && !e.target.closest('#navActions')) {
            document.getElementById('navActions').classList.remove('open');
        }
    });
</script>

{{-- HERO --}}
<section class="lp-hero">
    <div class="lp-hero__badge">
        <i class="fas fa-bolt"></i> La plateforme professionnelle tout-en-un
    </div>
    <h1>
        <span class="accent">Flash Compte Pro</span>
        et tous vos outils professionnels en un seul endroit
    </h1>
    <p class="lp-hero__sub">
        Créez des relevés de compte européens professionnels, envoyez des SMS en masse, générez des contrats de prêt PDF et vérifiez des IBAN en quelques secondes.
    </p>
    <div class="lp-hero__cta">
        <a href="{{ route('inscription') }}" class="btn-hero-primary">
            <i class="fas fa-rocket me-2"></i>Commencer gratuitement
        </a>
        <a href="{{ route('connexion') }}" class="btn-hero-secondary">
            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
        </a>
    </div>
</section>

{{-- STATS --}}
<div class="lp-stats">
    <div class="lp-stats__grid">
        <div>
            <div class="lp-stat__num">200+</div>
            <div class="lp-stat__label">Utilisateurs actifs</div>
        </div>
        <div>
            <div class="lp-stat__num">16</div>
            <div class="lp-stat__label">Outils disponibles</div>
        </div>
        <div>
            <div class="lp-stat__num">10</div>
            <div class="lp-stat__label">Langues supportées</div>
        </div>
        <div>
            <div class="lp-stat__num">100%</div>
            <div class="lp-stat__label">Sécurisé</div>
        </div>
    </div>
</div>

{{-- OUTILS PAYANTS --}}
<section class="lp-section">
    <div class="lp-section__inner">
        <span class="lp-section__tag">Outils Premium</span>
        <h2>Outils à accès payant</h2>
        <p class="lp-section__desc">Des outils professionnels puissants pour développer votre activité.</p>

        <div class="tools-lp-grid">
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/sms-pro.png') }}" alt="SMS Pro">
                <span class="tool-lp-card__name">SMS Pro</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/flash-compte-v1.png') }}" alt="Flash Compte Pro">
                <span class="tool-lp-card__name">Flash Compte Pro</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/mail-flash-pro.png') }}" alt="Mail Flash Pro">
                <span class="tool-lp-card__name">Mail Flash Pro</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <span class="tool-lp-card__badge badge-new">New</span>
                <img src="{{ asset('images/tools/contrat-pret.jpeg') }}" alt="Contrat de Prêt" style="border-radius:12%;">
                <span class="tool-lp-card__name">Contrat de Prêt</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/iban-check.png') }}" alt="Vérification IBAN">
                <span class="tool-lp-card__name">Vérification IBAN / CB</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/phone-verify.png') }}" alt="Vérification Téléphone">
                <span class="tool-lp-card__name">Vérification Téléphone</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <span class="tool-lp-card__badge badge-soon">Bientôt</span>
                <img src="{{ asset('images/tools/code-coupon.png') }}" alt="Collecte Code Coupon">
                <span class="tool-lp-card__name">Collecte de Code Coupon</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <span class="tool-lp-card__badge badge-soon">Bientôt</span>
                <img src="{{ asset('images/tools/mail-pro-prive.png') }}" alt="Mail Pro Privé">
                <span class="tool-lp-card__name">Mail Pro Privé</span>
            </a>
        </div>
    </div>
</section>

{{-- OUTILS GRATUITS --}}
<section class="lp-section" style="background:#fff; border-top:1px solid #e2e8f0;">
    <div class="lp-section__inner">
        <span class="lp-section__tag green">Accès Libre</span>
        <h2>Outils gratuits</h2>
        <p class="lp-section__desc">Des outils puissants accessibles sans crédit pour booster votre productivité.</p>

        <div class="tools-lp-grid">
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <span class="tool-lp-card__badge badge-new">New</span>
                <img src="{{ asset('images/tools/qr-generator.svg') }}" alt="Générateur QR Code">
                <span class="tool-lp-card__name">Générateur QR Code</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <span class="tool-lp-card__badge badge-new">New</span>
                <img src="{{ asset('images/tools/badge-agent.png') }}" alt="Badge Agent">
                <span class="tool-lp-card__name">Badge Agent</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/mail-extractor.png') }}" alt="Mail Extractor">
                <span class="tool-lp-card__name">Mail Extractor</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/url-check.png') }}" alt="Vérification site web">
                <span class="tool-lp-card__name">Vérification site web</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <img src="{{ asset('images/tools/url-shortener.png') }}" alt="Raccourcissement URL">
                <span class="tool-lp-card__name">Raccourcissement d'URL</span>
            </a>
            <a href="{{ route('inscription') }}" class="tool-lp-card">
                <span class="tool-lp-card__badge badge-soon">Bientôt</span>
                <img src="{{ asset('images/tools/crypto-usdt.png') }}" alt="Vente Crypto USDT">
                <span class="tool-lp-card__name">Vente de Crypto USDT</span>
            </a>
            <a href="https://console.whatsago.com/partners/45575" target="_blank" rel="noopener" class="tool-lp-card">
                <img src="{{ asset('images/tools/telephone.png') }}" alt="Numéros Virtuels">
                <span class="tool-lp-card__name">Numéros Virtuels</span>
            </a>
            <a href="https://neutrocard.com/new-login/" target="_blank" rel="noopener" class="tool-lp-card">
                <img src="{{ asset('images/tools/virtual-cards.png') }}" alt="Cartes Virtuelles">
                <span class="tool-lp-card__name">Cartes Virtuelles</span>
            </a>
        </div>
    </div>
</section>

{{-- POURQUOI --}}
<section class="lp-section lp-why">
    <div class="lp-section__inner">
        <span class="lp-section__tag">Pourquoi FlashBilan</span>
        <h2>Rapide, fiable et professionnel</h2>
        <p class="lp-section__desc">Tout ce dont vous avez besoin pour gérer votre activité au quotidien.</p>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-card__icon" style="background:rgba(245,158,11,0.1);">⚡</div>
                <h3>Résultats immédiats</h3>
                <p>Générez vos documents et relevés en quelques secondes. Aucune attente, aucune complexité.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon" style="background:rgba(16,185,129,0.1);">🔒</div>
                <h3>Sécurisé et privé</h3>
                <p>Vos données sont protégées. Chaque compte est isolé et sécurisé avec un accès par code.</p>
            </div>
            <div class="why-card">
                <div class="why-card__icon" style="background:rgba(99,102,241,0.1);">🌍</div>
                <h3>Multi-langues</h3>
                <p>Nos outils supportent jusqu'à 10 langues : Français, Anglais, Espagnol, Portugais et plus.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="lp-cta">
    <h2>Prêt à utiliser <span style="color:#fbbf24;">Flash Compte Pro</span> ?</h2>
    <p>Créez votre compte gratuitement et accédez à tous nos outils dès maintenant.</p>
    <a href="{{ route('inscription') }}" class="btn-hero-primary" style="font-size:1.05rem; padding: 1rem 2.5rem;">
        <i class="fas fa-user-plus me-2"></i>Créer un compte gratuit
    </a>
</section>

{{-- FOOTER --}}
<footer class="lp-footer">
    <p>
        &copy; {{ date('Y') }} FlashBilan — Tous droits réservés &nbsp;·&nbsp;
        <a href="{{ route('connexion') }}">Connexion</a> &nbsp;·&nbsp;
        <a href="{{ route('inscription') }}">Inscription</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
