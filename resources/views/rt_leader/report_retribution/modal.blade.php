<table class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            @if ($type == 'air' || $type == 'sampah')
                <th>Nama Warga</th>
            @endif
            <th>Kategori</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
        </tr>
    </thead>    
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                @if ($type == 'air' || $type == 'sampah')
                    <td>{{ $item->user->name ?? '-' }}</td>
                @endif
                <td>
                    @if($type == 'air' || $type == 'sampah')
                        {{ $item->paymentCategory->pym_name ?? '-' }}
                    @else
                        {{ ucfirst($item->pyn_sys_kategori ?? 'Tidak Diketahui') }}
                    @endif
                </td>
                <td>Rp{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>{{ $item->pyn_sys_note ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
        
</table>
