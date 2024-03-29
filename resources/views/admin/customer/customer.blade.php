@extends('layouts.adminlayout')
@section('title', 'Customer')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><b>Daftar Customer</b></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="">

            @if (Session::has('status'))
              <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
              </div>
            @endif
        </div>

        <table class="table table-striped text-center">
            <thead class="thead bg-primary">
                <tr>
                  <th>Image</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Nomor Hp</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($user as $data)
                <tr>
                  <td><img src="{{ asset('images/profil/'.$data->image) }}" style="width: 50px; border-radius:100%;"></td>
                  <td>{{$data->name}}</td>
                  <td>{{$data->email}}</td>
                  <td>{{$data->nomor_hp}}</td>
                  <td>
                    {{-- <a href="customer-edit/{{$data->id}}" class="btn btn-warning"><i class="nav-icon fas fa-edit"></i></a> --}}
                    <a href="/customer-destroy/{{$data->id}}" class="btn btn-danger" id="delete"><i class="nav-icon fas fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
        </table>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    {{-- <!-- Modal Delete Start-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Pesanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Anda Yakin Ingin Menghapus Pesanan Ini?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <a class="btn btn-danger" href="/pesanan/delete/{{$data->id}}">Hapus</a>  
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Delete End --> --}}
@endsection

@section('script')
<script type="text/javascript">
       
    $(document).ready(function () {
        
        $('body').on('click', '#show-pesanan', function () {
          var pesananURL = $(this).data('url');
          $.get(pesananURL, function (data) {
              $('#pesananShowModal').modal('show');
              $('#pesanan-tgl_pesan').text(data.tgl_pesan);
              $('#pesanan-no_pesanan').text(data.no_pesanan);
              $('#pesanan-nama').text(data.nama);
              $('#pesanan-plat_nomor').text(data.plat_nomor);
              $('#pesanan-jeniscuci').text(data.jeniscuci.name);
              $('#pesanan-kategori').text(data.kategori.name);
              $('#pesanan-hargacuci').text(data.harga_cuci);
              $('#pesanan-hargakategori').text(data.harga_kategori);
              $('#pesanan-subtotal').text(data.subtotal);
              $('#pesanan-status').text(data.status.name);

          })
       });
        
    });
   
</script>

<script type="text/javascript">
  $(function() {
    $(document).on('click', '#delete', function(e) {
      e.preventDefault();
      var link = $(this).attr("href");
  
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = link;
          Swal.fire(
            "Deleted!",
            "Your file has been deleted.",
            "success"
          );
        }
      });
    });
  });
  </script>
@endsection