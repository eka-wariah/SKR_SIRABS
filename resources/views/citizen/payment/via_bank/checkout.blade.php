 @extends('citizen.master_citizen')

 @php
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
@endphp

@push('link')
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key')}}"></script>    
@endpush

@section('title')
    SiTAW | Tambah Kategori
@endsection

@section('content')

<div class="container min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
          <h4 class="fw-bold mb-4 text-center">💳 Detail Pembayaran</h4>
  
          <div class="bg-secondary bg-opacity-10 p-3 rounded-3 mb-4">
          
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Nama</strong></span>
                <span>{{ $payment->user->name }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Bendahara</strong></span>
                <span>{{ $payment->treasurer->name }}</span>
              </div>
              <div class="d-flex justify-content-between">
                <span><strong>Kategori</strong></span>
                <span>{{ $payment->paymentCategory->pym_name }}</span>
              </div>
            </div>
      
  
          <div class="border-top pt-3">
            <div class="d-flex justify-content-between mb-2">
              <span>Total</span>
              <span class="fw-semibold">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Tax</span>
              <span class="text-muted">$4.99</span>
            </div>
            <hr />
            <div class="d-flex justify-content-between mb-3">
              <span class="fw-bold">Total Pembayaran</span>
              <span class="fw-bold">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
          </div>
  
          <div class="d-grid mt-4">
            <button id="pay-button">Pay!</button>
            </button>
          </div>
          <div id="snap-container"></div>
  
          <p class="text-muted small text-center mt-3">
            Dengan melanjutkan, kamu menyetujui <br />
            <a href="#" class="text-decoration-underline">Syarat Layanan</a> dan <a href="#" class="text-decoration-underline">Kebijakan Privasi</a>.
          </p>
        </div>
      </div>
    </div>
  </div>
  
  @endsection



@push('script')

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
      window.snap.pay('{{$snapToken}}', {
        onSuccess: function(result){
          /* You may add your own implementation here */
          // alert("payment success!"); 
          window.location.href = '/citizen/payment/invoice/{{ $payment->pyn_id }}'
          console.log(result);
        },
        onPending: function(result){
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
        },
        onError: function(result){
          /* You may add your own implementation here */
          alert("payment failed!"); console.log(result);
        },
        onClose: function(){
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      })
    });
  </script>

 {{--
<div class="row" style="padding: 25px">
    <div class="col-lg-12">
        <div class="card">
          <div class="px-4 py-3 border-bottom">
            <h4 class="card-title mb-0">Detail Pembayaran</h4>
          </div>
          <table>
            <tr>
                <td>Nama</td>
                <td> : {{$PaymentGateway->user->name}}</td>
            </tr>
            <tr>
                <td>Nama Bendahara</td>
                <td> : {{$PaymentGateway->treasurer->name}}</td>
            </tr>
            <tr>
                <td>kategori</td>
                <td> : {{$PaymentGateway->paymentCategory->pym_name}}</td>
            </tr>
            <tr>
                <td>Jumlah Pembayaran</td>
                <td> : Rp {{ number_format($PaymentGateway->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
          </table>
   
</div>
    </div>
</div>
    
@endsection



@push('script')
<script>
    function formatRupiah(angka) {
        return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
    }

    document.getElementById('kategori').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const total = selectedOption.getAttribute('data-total');

        // Set nilai asli (untuk form)
        document.getElementById('jumlah_bayar').value = total;

        // Tampilkan dalam format rupiah
        document.getElementById('jumlah_bayar_display').value = formatRupiah(total);
    });
</script>  --}}
@endpush
