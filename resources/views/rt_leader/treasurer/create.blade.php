@extends('rw_leader.master_rw-leader')

@section('title', 'Tambah Bendahara')

@section('content')
<div class="row" style="padding: 25px">
    <div class="col-lg-12">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <h4 class="card-title mb-0">Tambah Bendahara</h4>
            </div>
            <form action="{{ route('treasurer.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-4">
                        <label for="asc_id" class="form-label">Pilih Area Scope:</label>
                        <select name="asc_id" id="area_scope_id" class="form-control" required>
                            <option value="">-- Pilih Area Scope --</option>
                            @foreach ($areaScopes as $area)
                                <option value="{{ $area->asc_id }}">{{ $area->asc_level }} {{ $area->asc_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="usr_id" class="form-label">Pilih Warga:</label>
                        <select name="usr_id" id="usr_id" class="form-control" required>
                            <option value="">-- Pilih Warga --</option>
                            <!-- Diisi dari AJAX -->
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Jadikan Bendahara</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    document.getElementById('area_scope_id').addEventListener('change', function() {
        let areaScopeId = this.value;
        let citizenSelect = document.getElementById('usr_id');
        citizenSelect.innerHTML = '<option value="">Loading...</option>';

        if (areaScopeId) {
            fetch(`/get-citizens/${areaScopeId}`)
                .then(response => response.json())
                .then(data => {
                    citizenSelect.innerHTML = '<option value="">-- Pilih Warga --</option>';
                    data.forEach(function(citizen) {
                        citizenSelect.innerHTML += `<option value="${citizen.usr_id}">${citizen.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    citizenSelect.innerHTML = '<option value="">Gagal memuat warga</option>';
                });
        } else {
            citizenSelect.innerHTML = '<option value="">-- Pilih Warga --</option>';
        }
    });
</script>
@endpush
