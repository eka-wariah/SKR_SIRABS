@extends('rt_leader.master_rt-leader')

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

                    {{-- Ambil area scope dari RT yang login --}}
                    <div class="mb-4">
                        <label for="asc_id" class="form-label">Wilayah RT:</label>
                        <select name="asc_id" id="area_scope_id" class="form-control" disabled>
                            <option value="{{ $rtArea->asc_id }}">
                                {{ $rtArea->asc_level }} {{ $rtArea->asc_number }}
                            </option>
                        </select>
                        <input type="hidden" name="asc_id" value="{{ $rtArea->asc_id }}">
                    </div>

                    <div class="mb-4">
                        <label for="usr_id" class="form-label">Pilih Warga:</label>
                        <select name="usr_id" id="usr_id" class="form-control" required style="width: 100%;">
                            <option value="">-- Pilih Warga --</option>
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

@push('link')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        const wargaSelect = $('#usr_id');
        const areaScopeId = $('#area_scope_id').val();

        wargaSelect.select2({
            placeholder: '-- Pilih Warga --',
            width: '100%',
            ajax: {
                url: `/get-citizens/${areaScopeId}`,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    });
</script>
@endpush
