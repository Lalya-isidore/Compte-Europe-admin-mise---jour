<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .navbar-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-admin .navbar-brand {
            color: #fff;
            font-weight: 600;
            font-size: 1.3rem;
        }
        .navbar-admin .nav-link {
            color: rgba(255, 255, 255, 0.85);
        }
        .navbar-admin .nav-link.active,
        .navbar-admin .nav-link:hover {
            color: #fff;
        }
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.4);
        }
        .navbar-toggler-icon {
            filter: invert(1);
        }
        .admin-wrapper {
            padding: 2rem 0 3rem;
        }
        .alert-custom {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
        }
        .card-admin {
            background: #fff;
            border-radius: 15px;
            border: none;
            padding: 25px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-admin:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(102, 126, 234, 0.25);
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #fff;
        }
        .btn-gradient:hover {
            color: #fff;
            box-shadow: 0 8px 22px rgba(102, 126, 234, 0.35);
        }
        .table thead {
            background: #eef1ff;
        }
        .table thead th {
            color: #4c51bf;
            border-bottom: none;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('admin.partials.nav')

    <main class="admin-wrapper">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-custom">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-custom">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-custom">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const badge = document.getElementById('adminSupportBadge');
            if (!badge) {
                return;
            }

            const ADMIN_SUPPORT_COUNT_ENDPOINT = '{{ route('admin.support.unread-count') }}';
            let timerId = null;

            const updateBadge = (count) => {
                const value = Number(count) || 0;
                if (value > 0) {
                    badge.textContent = value > 99 ? '99+' : String(value);
                    badge.hidden = false;
                } else {
                    badge.hidden = true;
                }
            };

            const fetchCount = async () => {
                if (document.visibilityState === 'hidden') {
                    return;
                }

                try {
                    const response = await fetch(ADMIN_SUPPORT_COUNT_ENDPOINT, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                    });

                    if (!response.ok) {
                        throw new Error('HTTP ' + response.status);
                    }

                    const data = await response.json();
                    updateBadge(data.count ?? 0);
                } catch (error) {
                    console.error('Admin support counter error', error);
                }
            };

            const startPolling = () => {
                if (timerId) {
                    return;
                }
                timerId = setInterval(fetchCount, 1000);
            };

            const stopPolling = () => {
                if (!timerId) {
                    return;
                }
                clearInterval(timerId);
                timerId = null;
            };

            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'visible') {
                    fetchCount();
                }
            });

            window.addEventListener('beforeunload', () => {
                stopPolling();
            });

            fetchCount();
            startPolling();
        })();
    </script>
    @stack('scripts')
</body>
</html>
