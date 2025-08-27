@extends('rw_leader.master_rw-leader')

@section('title', 'Tambah Ketua RT')

@section('content')
<div class="row" style="padding: 25px">
    <div class="col-lg-12">
        <div class="card">
            <div class="px-4 py-3 border-bottom">
                <h4 class="card-title mb-0">Tambah Ketua RT</h4>
            </div>

            @if($areaScopes->isEmpty())
                <div class="alert alert-warning m-4">
                    Semua wilayah RT sudah memiliki Ketua RT.
                </div>
                <div class="text-end m-4">
                    <a href="/rw_leader/data_rt" class="btn btn-primary">Kembali</a>
                </div>
            @else
                <form action="{{ route('rt.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="area_scope_id" class="form-label">Pilih RT:</label>
                            <select name="area_scope_id" id="area_scope_id" class="form-control" required>
                                <option value="">-- Pilih RT --</option>
                                @foreach ($areaScopes as $area)
                                    <option value="{{ $area->asc_id }}">
                                        {{ $area->asc_level }} {{ $area->asc_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="usr_id" class="form-label">Pilih Warga:</label>
                            <select name="usr_id" id="usr_id" class="form-control" required style="width: 100%;">
                                <option value="">-- Pilih Warga --</option>
                            </select>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Jadikan Ketua RT</button>
                            <a href="/rw_leader/data_rt" class="btn btn-primary">Kembali</a>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection


@push('link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#usr_id').select2({
            placeholder: '-- Pilih Warga --',
            width: 'resolve'
        });

        $('#area_scope_id').on('change', function () {
            const areaScopeId = $(this).val();
            const $citizenSelect = $('#usr_id');
            $citizenSelect.html('<option value="">Loading...</option>');

            if (areaScopeId) {
                fetch(`{{ url('/get-citizenss') }}/${areaScopeId}`)
                    .then(response => response.json())
                    .then(data => {
                        let options = '<option value="">-- Pilih Warga --</option>';
                        data.forEach(function (citizen) {
                            options += `<option value="${citizen.usr_id}">${citizen.name}</option>`;
                        });
                        $citizenSelect.html(options).trigger('change');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        $citizenSelect.html('<option value="">Gagal memuat warga</option>');
                    });
            } else {
                $citizenSelect.html('<option value="">-- Pilih Warga --</option>');
            }
        });
    });
</script>
@endpush
