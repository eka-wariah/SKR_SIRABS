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
    


  @extends('citizen.master_citizen')

@push('link')
    <link rel="stylesheet" href="{{ asset('modernize/assets/css/styles.css')}}" />
    <link rel="stylesheet" href="{{ asset('modernize/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
@endpush

@section('title')
    SITAW | Daftar Kategori Sampah
@endsection

@section('content')
<div class="container">
    <h4>Detail Invoice</h4>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>No Invoice:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Periode:</strong> {{ $invoice->periode }}</p>
            <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}</p>
            <p><strong>Jumlah:</strong> Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
            <p><strong>Status:</strong>
                @if($invoice->status === 'paid')
                    <span class="badge bg-success">Lunas</span>
                @elseif($invoice->status === 'pending')
                    <span class="badge bg-warning">Pending</span>
                @else
                    <span class="badge bg-danger">Belum Bayar</span>
                @endif
            </p>
        </div>
    </div>

    <a href="{{ route('citizen.invoices.pdf', $invoice->inv_id) }}" target="_blank" class="btn btn-secondary">Download PDF</a> 

    @if($invoice->status !== 'paid')
    <form action="{{ route('citizen.invoices.pay', $invoice->inv_id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-success">Bayar Sekarang</button>
    </form>
    @endif

    <a href="{{ route('citizen.invoices.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>
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

@extends('staff.master_student')

@push('link')
    
@endpush

@section('title')
    Data Calon Siswa | SIAM Al-Mu'min
@endsection

@section('content')
   <div class="row">
    <div class="col-lg-12">
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Data Calon Siswa</h4>
          </div>
          {{-- <form action="" method="post"> --}}
          <form action="{{ route('student.Ppdb_Student.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="mb-4 row align-items-center">
                <label for="exampleInputText2" value="{{ $student->std_nik ?? '' }}" class="form-label col-sm-3 col-form-label">NIK</label>
                <div class="col-sm-9">
                  <input type="text" name="std_nik"  class="form-control"  inputmode="numeric" pattern="[0-9]*" maxlength="16" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('NIK Wajib Diisi')" 
                  onchange="this.setCustomValidity('')">
                </div>
                @error('std_nik')
                  <div>error</div>
                @enderror
              </div>

              <div class="mb-4 row align-items-center">
                <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                  <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Nama Wajib Diisi')" 
                  onchange="this.setCustomValidity('')">
                </div>
                @error('name')
                  <div>error</div>
                @enderror
              </div>

               <div class="mb-4 row align-items-center">
                <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Email Wajib Diisi')" 
                  onchange="this.setCustomValidity('')">
                </div>
                @error('email')
                  <div>error</div>
                @enderror
              </div>

              <div class="mb-4 row align-items-center">
                <label for="exampleInputText1" class="form-label col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-9">
                  <select class ="form-select mr-sm-2" id="inLineFormCustomSelect" name="std_gender" oninvalid="this.setCustomValidity ('Jenis Kelamin Wajib Diisi')"
                  onchange="this.setCustomValidity('')" required>
                      <option selected value="">Pilih...</option>
                      <option value="Perempuan">Perempuan</option>
                      <option value="Laki-laki">Laki-laki</option>
                  </select>
                </div>
                @error('std_gender')
                  <div>error</div>
                @enderror
              </div>

              <div class="mb-4 row align-items-center">
                <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Tempat Lahir</label>
                <div class="col-sm-9">
                  <input type="text" name="std_birth_place" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Tempat Lahir Kelas Wajib Diisi')" 
                  onchange="this.setCustomValidity('')">
                </div>
                @error('std_birth_place')
                  <div>error</div>
                @enderror
              </div>

              <div class="mb-4 row align-items-center">
                  <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Tanggal Lahir</label>
                  <div class="col-sm-9">
                    <input type="date" name="std_birth_date" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Tanggal Lahir Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('std_birth_date')
                    <div>error</div>s
                  @enderror
                </div>

                <div class="mb-4 row align-items-center">
                  <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Anak Ke</label>
                  <div class="col-sm-9">
                    <input type="number" name="std_child_to" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Anak Ke Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('std_child_to')
                    <div>error</div>
                  @enderror
                </div>

                <div class="mb-4 row align-items-center">
                  <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Jumlah Saudara</label>
                  <div class="col-sm-9">
                    <input type="number" name="std_number_of_siblings" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Jumlah Saudara Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('std_number_of_siblings')
                    <div>error</div>
                  @enderror
                </div>

                <div class="mb-4 row align-items-center">
                  <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Alamat</label>
                  <div class="col-sm-9">
                    <input type="text" name="std_address" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Alamat Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('std_address')
                    <div>error</div>
                  @enderror
                </div>

                  <div class="mb-4 row align-items-center">
                    <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Asal Sekolah</label>
                    <div class="col-sm-9">
                      <input type="text" name="std_school" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Nama Sekolah Umum Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div>
                    @error('std_school')
                      <div>error</div>
                    @enderror
                  </div>

                  <div class="mb-4 row align-items-center">
                    <label for="formalLevel" class="form-label col-sm-3 col-form-label">Tingkatan Sekolah</label>
                    <div class="col-sm-9">
                      <select name="std_formal_level" id="formalLevel" class="form-control" required 
                        oninvalid="this.setCustomValidity('Tingkatan Sekolah Wajib Diisi')" 
                        onchange="handleFormalLevelChange(); this.setCustomValidity('')">
                        <option hidden value="">Pilih Tingkatan</option>
                        <option value="Belum Sekolah">Belum Sekolah</option>
                        <option value="TK">TK</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="Lulus SMA">Lulus SMA</option>
                        <option value="Kuliah">Kuliah</option>
                      </select>
                    </div>
                    @error('std_formal_level')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="mb-4 row align-items-center" id="formalGradeWrapper">
                    <label for="formalGrade" class="form-label col-sm-3 col-form-label">Kelas Sekolah</label>
                    <div class="col-sm-9">
                      <select name="std_formal_grade" id="formalGrade" class="form-control">
                        <option hidden value="">Pilih Kelas</option>
                        @for ($i = 1; $i <= 12; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                    </div>
                    @error('std_formal_grade')
                      <div class="form-text text-danger">{{ $message }}</div>
                    @enderror
                  </div>


                  {{-- <div class="mb-4 row align-items-center">
                    <label for="Select" class="form-label col-sm-3 col-form-label">Kelas</label>
                    <div class="col-sm-9">
                    <select id="Select" name="cls_id" class="form-control" required>
                    <option hidden  value="">Pilih Kelas</option>
                    @foreach ($classes as  $Classes)
                      <option value="{{ $Classes->cls_id }}">
                        {{ $Classes->cls_level }} {{ $Classes->cls_number }} {{ $Classes->cls_general_level }}
                      </option>
                    @endforeach
                    </select>
                    @error('std_class_id')
                        <div id="std_id" class="form-text">{{ $message }}</div>
                    @enderror
                    </div>
                </div> --}}  

                <div class="mb-4 row align-items-center">
                  <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">NISN</label>
                  <div class="col-sm-9">
                    <input type="number" name="std_nisn" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('NISN Wajib Diisi')" 
                    onchange="this.setCustomValidity('')">
                  </div>
                  @error('std_nisn')
                    <div>error</div>
                  @enderror
                </div>

                  {{-- <div class="mb-4 row align-items-center">
                    <label for="exampleInputText2" class="form-label col-sm-3 col-form-label">Foto Diri</label>
                    <div class="col-sm-9">
                      <input type="file" name="std_pictures" class="form-control" id="exampleInputText2" placeholder="" required oninvalid="this.setCustomValidity('Foto Diri Wajib Diisi')" 
                      onchange="this.setCustomValidity('')">
                    </div> 
                    @error('std_picturess')
                      <div>error</div>
                    @enderror
                </div> --}}

                <div class="row">
                  <div class="col-sm-3"></div>
                  <div class="col-sm-9">
                    <input type="submit" class="btn btn-primary" value="Kirim" id="">
                  </div>
                </div>
              </div>
          </form>
          
        </div>
      </div>
   </div>

        @push('script')
        <script>
          function handleFormalLevelChange() {
            const level = document.getElementById('formalLevel').value;
            const gradeWrapper = document.getElementById('formalGradeWrapper');

            if (level === 'Belum Sekolah' || level === 'TK' || level === 'Lulus SMA' || level === 'Kuliah') {
              gradeWrapper.style.display = 'none';
              document.getElementById('formalGrade').value = '';
            } else {
              gradeWrapper.style.display = 'flex';
            }
          }

          document.addEventListener('DOMContentLoaded', function () {
            handleFormalLevelChange();
          });
        </script>
        @endpush
    
@endsection

@push('script')
    
@endpush
