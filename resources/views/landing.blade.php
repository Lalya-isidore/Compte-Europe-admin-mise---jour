<!DOCTYPE html>
<html class="dark" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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

    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icon-192.png') }}">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <link rel="stylesheet" href="{{ asset('css/landing-premium.css') }}">

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-container": "#0a0d2e",
                        "secondary": "#4edea3",
                        "on-secondary": "#003824",
                        "tertiary": "#c3c0ff",
                        "background": "#0d1031",
                        "surface-container-low": "#151839",
                        "surface-container-highest": "#2f3254",
                        "on-background": "#e0e0ff",
                        "on-surface": "#e0e0ff",
                        "on-surface-variant": "#c7c5cf",
                    }
                }
            }
        }
    </script>
</head>
<body class="font-inter overflow-x-hidden">
    <!-- Section 1: Sticky Header -->
    <nav class="sticky top-0 w-full z-50 bg-[#0d1031]/80 backdrop-blur-xl border-b border-white/5 shadow-2xl">
        <div class="flex justify-between items-center px-8 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-emerald-500 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 10C14.48 10 10 14.48 10 20C10 25.52 14.48 30 20 30C25.52 30 30 25.52 30 20C30 14.48 25.52 10 20 10ZM20 27.5C15.86 27.5 12.5 24.14 12.5 20C12.5 15.86 15.86 12.5 20 12.5V20H27.5C27.5 24.14 24.14 27.5 20 27.5Z" fill="currentColor"/>
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter text-white uppercase">Flash<span class="text-amber-500">Bilan</span></span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-on-surface hover:text-secondary transition-colors font-medium text-sm uppercase tracking-widest" href="#outils">Outils</a>
                <a class="text-on-surface hover:text-secondary transition-colors font-medium text-sm uppercase tracking-widest" href="#pourquoi">Pourquoi nous</a>
                <a class="text-on-surface hover:text-secondary transition-colors font-medium text-sm uppercase tracking-widest" href="#">Tarifs</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('connexion') }}" class="text-on-surface-variant hover:text-white transition-colors font-semibold text-sm">Se connecter</a>
                <a href="{{ route('inscription') }}" class="bg-secondary text-on-secondary px-6 py-2.5 rounded-full font-bold emerald-glow hover:scale-105 transition-transform text-sm">Ouvrir un compte</a>
            </div>
        </div>
    </nav>

    <!-- Section 2: Hero Section -->
    <section class="relative pt-24 pb-48 px-8 overflow-hidden">
        <div class="max-w-7xl mx-auto text-center relative z-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 text-xs font-bold uppercase tracking-widest mb-8">
                <span class="material-symbols-outlined text-sm">bolt</span>
                La plateforme des outils bancaires pro
            </div>
            <h1 class="text-display-xl text-white mb-6 max-w-4xl mx-auto">
                Flash Compte Pro et tous vos outils bancaires <span class="text-amber-500">en un seul endroit</span>
            </h1>
            <p class="text-lg text-on-surface-variant max-w-2xl mx-auto mb-12">
                Accédez instantanément à vos relevés de compte européens, gérez vos SMS Pro et générez vos contrats de prêt PDF en toute sécurité.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-6">
                <a href="{{ route('inscription') }}" class="bg-secondary text-on-secondary px-10 py-4 rounded-full text-lg font-bold emerald-glow hover:scale-105 transition-transform flex items-center gap-2">
                    Commencer gratuitement
                    <span class="material-symbols-outlined">arrow_forward</span>
                </a>
                <a href="#outils" class="glass-panel text-white px-10 py-4 rounded-full text-lg font-bold vault-glow hover:bg-white/10 transition-colors">
                    Consulter les solutions
                </a>
            </div>
        </div>
        
        <!-- Ambient Background Lights -->
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-600/10 blur-[120px] rounded-full pointer-events-none -z-0"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-emerald-600/10 blur-[100px] rounded-full pointer-events-none -z-0"></div>

        <div class="mt-24 max-w-5xl mx-auto glass-panel rounded-card vault-glow p-2 relative z-10 overflow-hidden border border-white/5">
            <img alt="Dashboard Interface" class="rounded-[24px] w-full opacity-90" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAXDDkaWkOYx3joKeTYmTm4Rs-DBJVknrtqTXpaedD188yqwFq-FvaBwEOUcmpq5iFi63KKaiHsBinPYekz_2ayc8I8IucpOMxNHOy57i4yd4HVBDpLJsPpudc5MXn9RdPTYaJXEGRpVS7N0A1VWBprVhnN2EeMXhvwyil-XWDhM3FE75pBsTDKz0JdGDVv5si3HjnZ-s9tzQzHDnId2i8CH3LxaEkGW2mJS4HN0LMiIg4V0m3jZYYQtQ0dCyJLdYHrP6Ps3Z1HF3GB"/>
        </div>
    </section>

    <!-- Section 3: Stats Section -->
    <section class="py-16 bg-[#070a2b] border-y border-white/5">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
            <div class="space-y-1">
                <div class="text-4xl font-bold text-secondary">200+</div>
                <div class="text-label-caps text-on-surface-variant">Utilisateurs</div>
            </div>
            <div class="space-y-1">
                <div class="text-4xl font-bold text-amber-500">16</div>
                <div class="text-label-caps text-on-surface-variant">Outils</div>
            </div>
            <div class="space-y-1">
                <div class="text-4xl font-bold text-tertiary">10</div>
                <div class="text-label-caps text-on-surface-variant">Langues</div>
            </div>
            <div class="space-y-1">
                <div class="text-4xl font-bold text-white">100%</div>
                <div class="text-label-caps text-on-surface-variant">Sécurisé</div>
            </div>
        </div>
    </section>

    <!-- Section 4: Tools Grid -->
    <section id="outils" class="py-24 px-8 max-w-7xl mx-auto">
        <div class="mb-16 text-center md:text-left">
            <h2 class="text-headline-lg text-white mb-4">Nos Outils Professionnels</h2>
            <p class="text-on-surface-variant">Une suite complète pour la gestion financière et opérationnelle.</p>
        </div>

        <!-- Premium Tools -->
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-10">
                <span class="text-label-caps text-secondary bg-secondary/10 px-4 py-1 rounded-full border border-secondary/20">PREMIUM</span>
                <div class="h-px flex-grow bg-white/5"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- SMS Pro -->
                <a href="{{ route('inscription') }}" class="glass-panel p-8 rounded-card vault-glow hover-lift group border border-white/5 block">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined text-3xl">sms</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">SMS Pro</h3>
                    <p class="text-on-surface-variant leading-relaxed">Envoi massif de notifications sécurisées pour vos clients institutionnels.</p>
                </a>
                <!-- Flash Compte Pro -->
                <a href="{{ route('inscription') }}" class="glass-panel p-8 rounded-card vault-glow hover-lift group border border-white/5 block">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined text-3xl">account_balance</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Flash Compte Pro</h3>
                    <p class="text-on-surface-variant leading-relaxed">Relevés bancaires instantanés au format européen standardisé.</p>
                </a>
                <!-- Mail Flash Pro -->
                <a href="{{ route('inscription') }}" class="glass-panel p-8 rounded-card vault-glow hover-lift group border border-white/5 block">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined text-3xl">mail</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Mail Flash Pro</h3>
                    <p class="text-on-surface-variant leading-relaxed">Serveur SMTP haute délivrabilité pour vos communications critiques.</p>
                </a>
                <!-- Contrat de Prêt -->
                <a href="{{ route('inscription') }}" class="glass-panel p-8 rounded-card vault-glow hover-lift group border border-white/5 block">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined text-3xl">description</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Contrat de Prêt</h3>
                    <p class="text-on-surface-variant leading-relaxed">Génération dynamique de contrats PDF juridiquement conformes.</p>
                </a>
                <!-- Iban Check -->
                <a href="{{ route('inscription') }}" class="glass-panel p-8 rounded-card vault-glow hover-lift group border border-white/5 block">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined text-3xl">verified_user</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Iban Check</h3>
                    <p class="text-on-surface-variant leading-relaxed">Vérification algorithmique et KYC des coordonnées bancaires mondiales.</p>
                </a>
                <!-- Phone Verify -->
                <a href="{{ route('inscription') }}" class="glass-panel p-8 rounded-card vault-glow hover-lift group border border-white/5 block">
                    <div class="w-14 h-14 bg-secondary/10 rounded-2xl flex items-center justify-center text-secondary mb-6 group-hover:bg-secondary group-hover:text-on-secondary transition-all">
                        <span class="material-symbols-outlined text-3xl">phone_iphone</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Phone Verify</h3>
                    <p class="text-on-surface-variant leading-relaxed">Authentification multifacteur et validation de lignes internationales.</p>
                </a>
            </div>
        </div>

        <!-- Free Tools -->
        <div>
            <div class="flex items-center gap-4 mb-10">
                <span class="text-label-caps text-amber-500 bg-amber-500/10 px-4 py-1 rounded-full border border-amber-500/20">OUTILS GRATUITS</span>
                <div class="h-px flex-grow bg-white/5"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <a href="{{ route('inscription') }}" class="glass-panel p-6 rounded-2xl vault-glow flex flex-col items-center text-center hover:bg-white/5 transition-all border border-white/5">
                    <span class="material-symbols-outlined text-amber-500 mb-4 text-3xl">qr_code</span>
                    <span class="font-medium text-sm">QR Generator</span>
                </a>
                <a href="{{ route('inscription') }}" class="glass-panel p-6 rounded-2xl vault-glow flex flex-col items-center text-center hover:bg-white/5 transition-all border border-white/5">
                    <span class="material-symbols-outlined text-amber-500 mb-4 text-3xl">badge</span>
                    <span class="font-medium text-sm">Badge Agent</span>
                </a>
                <a href="{{ route('inscription') }}" class="glass-panel p-6 rounded-2xl vault-glow flex flex-col items-center text-center hover:bg-white/5 transition-all border border-white/5">
                    <span class="material-symbols-outlined text-amber-500 mb-4 text-3xl">content_paste_search</span>
                    <span class="font-medium text-sm">Mail Extractor</span>
                </a>
                <a href="{{ route('inscription') }}" class="glass-panel p-6 rounded-2xl vault-glow flex flex-col items-center text-center hover:bg-white/5 transition-all border border-white/5">
                    <span class="material-symbols-outlined text-amber-500 mb-4 text-3xl">language</span>
                    <span class="font-medium text-sm">Website Check</span>
                </a>
                <a href="{{ route('inscription') }}" class="glass-panel p-6 rounded-2xl vault-glow flex flex-col items-center text-center hover:bg-white/5 transition-all border border-white/5">
                    <span class="material-symbols-outlined text-amber-500 mb-4 text-3xl">link</span>
                    <span class="font-medium text-sm">URL Shortener</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Section 5: Why Us -->
    <section id="pourquoi" class="py-24 px-8 bg-primary-container/30">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-headline-lg text-white mb-4">L'Excellence Institutionnelle</h2>
                <p class="text-on-surface-variant max-w-2xl mx-auto">La confiance de nos partenaires repose sur trois piliers fondamentaux de notre architecture.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-10 rounded-card glass-panel flex flex-col items-center text-center border border-white/5">
                    <div class="text-5xl mb-6">⚡</div>
                    <h3 class="text-xl font-bold text-white mb-4">Résultats immédiats</h3>
                    <p class="text-on-surface-variant leading-relaxed">Tous nos processus sont automatisés pour une exécution en millisecondes, garantissant une fluidité opérationnelle totale.</p>
                </div>
                <div class="p-10 rounded-card glass-panel flex flex-col items-center text-center border border-white/5">
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-xl font-bold text-white mb-4">Sécurisé et privé</h3>
                    <p class="text-on-surface-variant leading-relaxed">Cryptage AES-256 de bout en bout. Vos données ne quittent jamais notre infrastructure sécurisée de grade souverain.</p>
                </div>
                <div class="p-10 rounded-card glass-panel flex flex-col items-center text-center border border-white/5">
                    <div class="text-5xl mb-6">🌍</div>
                    <h3 class="text-xl font-bold text-white mb-4">Multi-langues</h3>
                    <p class="text-on-surface-variant leading-relaxed">Une interface disponible dans plus de 10 langues pour accompagner votre expansion internationale sans friction.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 6: CTA Bottom -->
    <section class="py-32 text-center bg-gradient-to-b from-transparent to-[#0a0d2e]">
        <div class="max-w-4xl mx-auto px-8">
            <h2 class="text-4xl md:text-5xl font-black text-white mb-8">Prêt à utiliser <span class="text-amber-500">Flash Compte Pro</span> ?</h2>
            <p class="text-xl text-on-surface-variant mb-12">Créez votre compte gratuitement et accédez à tous nos outils dès maintenant.</p>
            <a href="{{ route('inscription') }}" class="bg-secondary text-on-secondary px-12 py-5 rounded-full text-xl font-bold emerald-glow hover:scale-105 transition-transform inline-flex items-center gap-3">
                <span class="material-symbols-outlined">person_add</span>
                Créer un compte gratuit
            </a>
        </div>
    </section>

    <!-- Section 7: Footer -->
    <footer class="bg-[#0a0d2e] w-full py-16 border-t border-white/5">
        <div class="flex flex-col md:flex-row justify-between items-center px-12 max-w-7xl mx-auto gap-12">
            <div class="flex flex-col gap-4 text-center md:text-left">
                <span class="text-xl font-black text-white uppercase tracking-tighter">Flash<span class="text-amber-500">Bilan</span></span>
                <p class="text-xs tracking-widest uppercase text-slate-500">© {{ date('Y') }} FlashBilan. Tous droits réservés.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <a class="text-xs tracking-widest uppercase text-slate-500 hover:text-white transition-colors" href="#">Protocoles</a>
                <a class="text-xs tracking-widest uppercase text-slate-500 hover:text-white transition-colors" href="#">Audit Sécurité</a>
                <a class="text-xs tracking-widest uppercase text-slate-500 hover:text-white transition-colors" href="#">Conditions</a>
            </div>
            <div class="flex gap-6">
                <a class="text-slate-500 hover:text-secondary transition-colors" href="#"><span class="material-symbols-outlined">account_balance</span></a>
                <a class="text-slate-500 hover:text-secondary transition-colors" href="#"><span class="material-symbols-outlined">shield</span></a>
                <a class="text-slate-500 hover:text-secondary transition-colors" href="#"><span class="material-symbols-outlined">public</span></a>
            </div>
        </div>
    </footer>
</body>
</html>
