@if($contractHistory->isNotEmpty())
<div class="contract-history-section" style="margin-top: 2.5rem;">
    <h5 style="font-weight:700; color:#1a3a5c; margin-bottom:1rem; display:flex; align-items:center; gap:.5rem;">
        <i data-lucide="clock" style="width:18px;height:18px;"></i>
        Historique des {{ $historyLabel }} <span style="font-size:.8rem; font-weight:400; color:#6b7280;">(conservés 30 jours)</span>
    </h5>
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle" style="font-size:.9rem;">
            <thead class="table-light">
                <tr>
                    <th>Document</th>
                    <th>Détails</th>
                    <th>Date</th>
                    <th>Expire dans</th>
                    <th style="width:120px;"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($contractHistory as $entry)
                <tr @if($entry->is_test) style="background:#fff8e1;" @endif>
                    <td>
                        @if($entry->is_test)
                            <span class="badge" style="background:#f59e0b; color:#fff; font-size:.75rem; margin-bottom:3px; display:inline-block;">⚠ FILIGRANE — ne pas envoyer au client</span><br>
                        @endif
                        <span style="font-weight:600; color:#1a3a5c;">{{ $entry->display_name }}</span>
                    </td>
                    <td style="color:#4b5563;">
                        @if($entry->type === 'pret')
                            @if(!empty($entry->metadata['emprunteur']))
                                <span>Emprunteur : <strong>{{ $entry->metadata['emprunteur'] }}</strong></span><br>
                            @endif
                            @if(!empty($entry->metadata['montant']))
                                <span>{{ number_format($entry->metadata['montant'], 0, ',', ' ') }} {{ $entry->metadata['devise'] ?? '' }}</span>
                            @endif
                        @else
                            @if(!empty($entry->metadata['donateur']))
                                <span>Donateur : <strong>{{ $entry->metadata['donateur'] }}</strong></span><br>
                            @endif
                            @if(!empty($entry->metadata['montant']))
                                <span>{{ number_format($entry->metadata['montant'], 0, ',', ' ') }} {{ $entry->metadata['devise'] ?? '' }}</span>
                            @endif
                        @endif
                    </td>
                    <td style="white-space:nowrap; color:#6b7280;">{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                    <td style="white-space:nowrap;">
                        @php $diff = now()->diff($entry->expires_at); @endphp
                        @if($diff->days > 0)
                            <span style="color:#059669;">{{ $diff->days }}j {{ $diff->h }}h</span>
                        @else
                            <span style="color:#dc2626;">{{ $diff->h }}h {{ $diff->i }}min</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:.4rem;">
                            <a href="{{ route('contracts.history.download', $entry->id) }}"
                               class="btn btn-sm"
                               style="background:#1a3a5c; color:#fff; padding:4px 10px; border-radius:6px; font-size:.8rem; text-decoration:none;">
                                <i data-lucide="download" style="width:13px;height:13px;vertical-align:middle;"></i> PDF
                            </a>
                            <form method="POST" action="{{ route('contracts.history.destroy', $entry->id) }}"
                                  onsubmit="return confirm('Supprimer ce document ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm"
                                        style="background:#fee2e2; color:#dc2626; padding:4px 8px; border-radius:6px; font-size:.8rem; border:none;">
                                    <i data-lucide="trash-2" style="width:13px;height:13px;vertical-align:middle;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
