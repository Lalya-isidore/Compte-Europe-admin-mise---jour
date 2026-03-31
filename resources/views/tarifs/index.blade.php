@extends('layouts.admin')

@section('title', 'Liste des tarifs')

@section('breadcrumb')
        <li class="breadcrumb-item active">Liste des tarifs</li>
@endsection

@section('content')
<style>
    .tarifs-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }
    .tariffs-surface {
        background: linear-gradient(180deg, #f6f7ff 0%, #ffffff 60%);
        padding: 1.5rem;
        border-radius: 24px;
        border: 1px solid #e1e6f3;
    }
    .tarif-table {
        border: 1px solid #d8dee6;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 6px 25px rgba(15, 23, 42, 0.08);
        overflow: hidden;
        height: 100%;
    }
    .tarif-table__header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #ebeff6;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 1.1rem;
        background: #fff;
    }
    .tarif-table__body {
        padding: 1.25rem 1.5rem 1.6rem;
        background: #fbfbff;
    }
    .tarif-row {
        border: 1px solid #5f7bff;
        border-radius: 14px;
        padding: 0.95rem 1.15rem;
        background: #fdfdff;
        margin-bottom: 1.1rem;
    }
    .tarif-row__title {
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #0f172a;
    }
    .tarif-row__list {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .tarif-row__list li {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.96rem;
        color: #1e293b;
        padding: 0.18rem 0;
    }
    .tarif-row__list li i {
        color: #4a7dff;
        font-size: 0.85rem;
    }
    .free-note {
        background: #fdecc8;
        border-radius: 12px;
        border: 1px solid rgba(233, 178, 73, 0.6);
        padding: 1rem 1.2rem;
        color: #5f370e;
        font-size: 0.94rem;
        margin-bottom: 1.15rem;
    }
    .free-pill {
        border: 1px solid #5f7bff;
        border-radius: 14px;
        padding: 0.75rem 1.05rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
        margin-bottom: 0.85rem;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    .free-pill__badge {
        border: 1px solid #5f7bff;
        border-radius: 999px;
        padding: 0.12rem 0.85rem;
        font-weight: 700;
        font-size: 0.82rem;
        color: #1c3faa;
    }
    @media (max-width: 1024px) {
        .tarifs-wrapper {
            padding-left: 0;
            padding-right: 0;
        }
        .tariffs-surface {
            padding: 1rem;
            border-radius: 18px;
        }
        .tarif-table {
            border-radius: 14px;
        }
        .tarif-table + .tarif-table {
            margin-top: 1.5rem;
        }
        .tarif-table__header {
            flex-wrap: wrap;
            font-size: 1rem;
            gap: 0.35rem;
        }
        .tarif-table__body {
            padding: 1rem 1rem 1.25rem;
        }
        .tarif-row {
            padding: 0.85rem 0.9rem;
            margin-bottom: 0.9rem;
        }
        .tarif-row__title {
            font-size: 0.98rem;
            margin-bottom: 0.35rem;
        }
        .tarif-row__list li {
            align-items: flex-start;
            font-size: 0.9rem;
            line-height: 1.35;
        }
        .free-note {
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .free-pill {
            flex-direction: column;
            align-items: flex-start;
            padding: 0.85rem;
            gap: 0.35rem;
        }
        .free-pill__badge {
            align-self: flex-start;
            margin-top: 0.1rem;
            font-size: 0.78rem;
            padding: 0.12rem 0.65rem;
        }
    }
    @media (max-width: 560px) {
        .tarifs-wrapper {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        .tarif-row__list li span {
            display: block;
        }
        .free-pill {
            border-radius: 12px;
        }
        .free-pill__badge {
            font-size: 0.74rem;
            letter-spacing: 0.02em;
        }
    }
</style>

<div class="tarifs-wrapper container-fluid px-lg-4 px-3 py-4">
    <div class="tariffs-surface">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="tarif-table">
                    <div class="tarif-table__header">
                        <i class="fas fa-lock"></i>
                        Outils à accès payant
                    </div>
                    <div class="tarif-table__body">
                        @foreach($paidTools as $category)
                            <div class="tarif-row">
                                <div class="tarif-row__title">{{ $category['title'] }} :</div>
                                <ul class="tarif-row__list">
                                    @foreach($category['items'] as $item)
                                        <li>
                                            <i class="fas fa-check"></i>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="tarif-table">
                    <div class="tarif-table__header">
                        <i class="fas fa-feather"></i>
                        Outils à accès libre
                    </div>
                    <div class="tarif-table__body">
                        <div class="free-note">
                            Ces outils listés ci-dessous ont un accès gratuit mais certains parmi eux ont des tarifs variants selon vos besoins, votre budget et seront utilisés indépendamment de votre crédit pour les outils à accès payant.
                        </div>
                        @foreach($freeTools as $tool)
                            <div class="free-pill">
                                <span>{{ $tool['label'] }}</span>
                                <span class="free-pill__badge">{{ $tool['badge'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
