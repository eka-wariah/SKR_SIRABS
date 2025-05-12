@extends('rw_leader.master_rw-leader')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Pembayaran
@endsection

@section('content')
<div class="datatables" style="padding: 25px">
    <div class="card">
        <div class="card-body">
            <div class="mb-5 position-relative">
                <h4 class="card-title mb-0">Daftar Kategori</h4>
                <a href="treasurer/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Kategori</a>
            </div> 
            <p class="card-subtitle mb-3">
                
            </p>
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
        <thead>
          <tr>
            <th width="10%">No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>actions</th>
          </tr>
        </thead>
        <tbody>
            <!-- start row -->
            @foreach ( $treasurers as $no=> $treasurer)
            <tr>
                <td>{{$no+1}}</td>
                <td>{{ $treasurer->name }}</td>
                <td>{{ $treasurer->email }}</td>
                {{-- <td>{{ $trs_area_id->areaScope->nama_wilayah ?? '-' }}</td> --}}
                
                <td>
                    <a href="/rw_leader/treasurer/{{ $treasurer->usr_id }}/edit" class="btn btn-primary">Edit</a>
                    <a href="/rw_leader/treasurer/{{ $treasurer->usr_id }}/destroy" class="btn btn-danger">Jadikan Warga</a>
                </td>


                
            </tr>
            @endforeach
            <!-- end row -->
            
        </tbody>
      </table>
    </div>
  </div>
    </div>
</div>
    {{-- <div class="datatables">
        <div class="card">
            <div class="card-body">
                <div class="mb-5 position-relative">
                    <h4 class="card-title mb-0">Daftar Kategori</h4>
                    <a href="area_scope/create" class="btn btn-primary position-absolute top-0 end-0">Tambah Kategori</a>
                </div> 
                <p class="card-subtitle mb-3">
                    
                </p>
                <div class="table-responsive">
                    <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                        <thead>
                            <!-- start row -->
                            <tr>
                                <th></th>
                                <th width="10%">No</th>
                                <th>Nama</th>
                                <th>Lingkup Wilayah</th>
                                <th>Aksi</th>
                                
                            </tr>
                            <!-- end row -->
                        </thead>
                        <tbody>
                            <!-- start row -->
                            @foreach ( $treasurers as $no=> $treasurer)
                            <tr>
                                <td></td>
                                <td>{{$no+1}}</td>
                                <td>{{ $treasurer->name }}</td>
                                <td>{{ $treasurer->email }}</td>
                                {{-- <td>{{ $trs_area_id->areaScope->nama_wilayah ?? '-' }}</td> --}}
                                
                                {{-- <td>
                                     <a href="/rw_leader/treasurer/{{ $treasurer->trs_id}}/edit" class="btn btn-primary">Edit</a>
                                     <a href="/rw_leader/treasurer/{{ $treasurer->trs_id}}/destroy" class="btn btn-danger" data-confirm-delete="true">Delete</a>

                                </td> --}}


                                
                            {{-- </tr>
                            @endforeach --}}
                            <!-- end row -->
                            
                        {{-- </tbody>
                        <tfoot> --}}
                            <!-- start row -->
                            
{{-- 
                            <tr>
                                <th width="10%">No</th>
                                <th>Lingkup Wilayah</th>
                                <th>Nomor</th>
                                <th>Aksi</th>
                            </tr> --}}
                            <!-- end row -->
                        {{-- </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>  --}}
    
@endsection



@push('script')
<script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
<script src="{{ asset('modernize/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="{{ asset('modernize/assets/js/datatable/datatable-advanced.init.js')}}"></script>

@endpush



public function store(Request $request)
{

    $request->validate([
        'usr_id' => 'required|exists:users,usr_id',
        'usr_scope_id' => 'required|exists:users,usr_scope_id',
    ]);

    // Ambil user berdasarkan usr_id
    $user = User::where('usr_id', $request->usr_id)->firstOrFail();

    // Jika user punya role citizen, hapus
    if ($user->hasRole('citizen')) {
        $user->removeRole('citizen');
    }

    // Assign role treasurer
    $user->assignRole('treasurer');

    // Insert ke tabel treasurers
    $CreateTreasurer =Treasurer::create([
        'trs_name_id' => $user->usr_id,      // usr_id warga
        'trs_area_id' => $user->usr_scope_id,   // area yang dipilih
    ]);

   return redirect('rw_leader/treasurer')->with('success', 'Berhasil menambahkan bendahara!');

   public function create()
    {
        $citizen = User::role('citizen')->get();
        $area_scope = area_scope::all();
        return view('rw_leader.treasurer.create',  compact([ 'citizen', 'area_scope']));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
        $request->validate([
            'usr_id' => 'required|exists:users,usr_id',
        ]);
    
        $user = User::where('usr_id', $request->user_id)->firstOrFail();
    
        if ($user->hasRole('citizen')) {
            $user->removeRole('citizen');
        }
    
        $user->assignRole('treasurer');
    
        return redirect()->back()->with('success', 'Role berhasil diubah menjadi bendahara');

        // Insert ke tabel treasurers
        // $CreateTreasurer =Treasurer::create([
        //     'trs_name_id' => $user->usr_id,      // usr_id warga
        //     'trs_area_id' => $user->usr_scope_id,   // area yang dipilih
        // ]);
    
       //return redirect('rw_leader/treasurer')->with('success', 'Berhasil menambahkan bendahara!');
}
        // return redirect('rw_leader/treasurer');
    
        public function getCitizens($asc_id)
        {
            // Ambil user berdasarkan area_scope_id
            $citizens = User::where('usr_scope_id', $asc_id)->get(['usr_id', 'name']);
            
            return response()->json($citizens); // Mengirim data citizen dalam format JSON
        }
        
    /**
     * Display the specified resource.
     */
    public function show(treasurer $treasurer)
    {
        //
    }


    {{-- <form action="{{ route('treasurer.store') }}" method="POST">
    @csrf
    <label for="user_id">Pilih Warga:</label>
    <select name="user_id" required>
        @foreach($citizen as $user)
            <option value="{{ $user->usr_id }}">{{ $user->name }}</option>
        @endforeach
    </select>
  
    {{-- <label for="kategori_wilayah_id">Kategori Wilayah:</label>
    <select name="kategori_wilayah_id" required>
        @foreach($area_scope as $area_scope)
            <option value="{{ $area_scope->asc_id }}">{{ $area_scope->asc_level }} {{ $area_scope->asc_number }}</option>
        @endforeach 
    </select>
  
    <button type="submit" class="btn btn-primary">Jadikan Bendahara</button>
  </form>
  {{-- <form action="{{ url('/users/' . $user->id . '/make-treasurer') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">Jadikan Bendahara</button>
  </form> --}}

  @extends('rw_leader.master_rw-leader')

  @push('link')
      
  @endpush
  
  @section('title')
      SiTAW | Tambah Kategori
  @endsection
  
  @section('content')
     <div class="row" style="padding: 25px">
      <div class="col-lg-12">
          <div class="card">
            <div class="px-4 py-3 border-bottom">
              <h4 class="card-title mb-0">Tambah Kategori</h4>
            </div>
            <form action="{{ route('treasurer.store') }}" method="post">
              @csrf
              <div class="card-body">
                  <div class="mb-4 row align-items-center">
                      <label for="asc_id">Pilih Area Scope:</label>
                      <select name="asc_id" id="area_scope_id" class="form-control" required>
                          <option value="">Pilih Area Scope</option>
                          @foreach ($area_scope as $area)
                              <option value="{{ $area->asc_id }}">{{ $area->asc_level }}{{ $area->asc_number }}</option>
                          @endforeach
                      </select>
                  
                      <!-- Dropdown untuk memilih Citizen berdasarkan Area Scope -->
                      <label for="usr_id">Pilih Warga:</label>
                      <select name="usr_id" id="usr_id" class="form-control" required>
                          <!-- Data citizen akan dimuat via AJAX -->
                      </select>
                  
                    
                  <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                      <button type="submit" class="btn btn-primary">Jadikan Bendahara</button>
                    </div>
                  </div>
                </div>
            </form>
            
          </div>
        </div>
     </div>
      
  @endsection
  
  
  
  @push('script')
  <script>
  $('#area_scope_id').on('change', function() {
      var area_scope_id = $(this).val();
      
      if (area_scope_id) {
          // Jika area scope dipilih, lakukan request ke server untuk mendapatkan citizens sesuai area
          $.ajax({
              url: '/get-citizens/' + area_scope_id, // URL endpoint untuk mendapatkan citizens berdasarkan area
              type: 'GET',
              success: function(data) {
                  // Kosongkan dropdown user sebelum diisi dengan data baru
                  $('#usr_id').empty();
                  $('#usr_id').append('<option value="">Pilih Warga</option>');
  
                  // Menambahkan pilihan citizen yang sesuai
                  $.each(data, function(key, value) {
                      $('#usr_id').append('<option value="' + value.usr_id + '">' + value.name + '</option>');
                  });
              }
          });
      } else {
          // Jika tidak ada area scope yang dipilih, kosongkan dropdown citizen
          $('#usr_id').empty();
      }
  });
  </script>
  @endpush
    
