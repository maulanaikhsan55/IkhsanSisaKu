$content = Get-Content resources\views\karang-taruna\dashboard.blade.php -Raw

$old = @'
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                    <span class="text-xs font-semibold text-green-600">{{ $transaksi->tanggal_transaksi->format('H:i') }}</span>
                                </div>
                            </td>
'@

$new = @'
                            <td class="px-6 py-4">
                                @if($transaksi->status_penjualan === 'sudah_terjual')
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i>Terjual
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-hourglass-half mr-1"></i>Belum Terjual
                                    </span>
                                @endif
                            </td>
'@

$content = $content -replace [regex]::Escape($old), $new
Set-Content resources\views\karang-taruna\dashboard.blade.php -Value $content
Write-Host "✓ Status cell FIXED"
