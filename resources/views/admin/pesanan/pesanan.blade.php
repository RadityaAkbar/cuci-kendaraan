@extends('layouts.adminlayout')
@section('title', 'Pesanan')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><b>Daftar Pesanan</b></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="d-flex justify-content-between">
              {{-- <a href="pesanan/add" class="btn btn-success mb-3"><i class="nav-icon fas fa-plus"></i>
                  <span>Tambah Pesanan</span>
              </a> --}}
            {{-- <a href="pesanan/export" class="btn btn-primary">Export</a> --}}

            <div class="col-3 mb-1">
              <form action="" method="GET">
                <div class="d-flex">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <button class="input-group-text"><i class="fas fa-search"></i></button>
                    </div>
                    <input type="text" class="form-control" name="keyword" placeholder="Nama/Plat Nomor">
                  </div>
                </div>
              </form>
            </div>
        </div>

        @if (Session::has('status'))
              <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
              </div>
            @endif

            <table class="table table-striped text-center table-sortable mt-2">
              <thead class="thead" style="color: white">
                  <tr>
                      <th scope="col">
                          <a style="" href="#" class="sort" data-sort="no">#</a>
                      </th>
                      <th scope="col">
                          <a href="#" class="sort" data-sort="tgl_pesan">Tgl.Pesan</a>
                      </th>
                      <th scope="col">
                          <a href="#" class="sort" data-sort="nama">Nama</a>
                      </th>
                      <th scope="col">
                          <a href="#" class="sort" data-sort="kategori">Kategori</a>
                      </th>
                      <th scope="col">
                          <a href="#" class="sort" data-sort="jeniscuci">Jenis Cuci</a>
                      </th>
                      <th scope="col">
                          <a href="#" class="sort" data-sort="plat_nomor">Plat Nomor</a>
                      </th>
                      <th scope="col">
                          <a href="#" class="sort" data-sort="status">Status</a>
                      </th>
                      <th scope="col" class="text-primary">Action</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($pesanan as $data)
                      <tr>
                          <th scope="row">{{$loop->iteration}}</th>
                          <td>{{$data->tgl_pesan}}</td>
                          <td>{{$data->nama}}</td>
                          @if ($data->kategori_id > 0)
                              <td>{{$data->kategori->name}}</td>
                          @else
                              <td>{{$data->kategori_id}}</td>
                          @endif
                          @if ($data->jeniscuci_id > 0)
                              <td>{{$data->jeniscuci->name}}</td>
                          @else
                              <td>{{$data->jeniscuci_id}}</td>
                          @endif
                          <td>{{$data->plat_nomor}}</td>
                          <td>{{$data->status->name}}</td>
                          <td>
                              <a
                                  href="javascript:void(0)"
                                  id="show-pesanan"
                                  data-url="{{ route('pesanan.show', $data->id) }}"
                                  class="btn btn-info"
                              ><i class="nav-icon fas fa-info-circle"></i></a>
          
                              @if ($data->status_id < 3)
                                  <a href="pesanan/{{$data->id}}" class="btn btn-warning"><i class="nav-icon fas fa-edit"></i></a>
                              @endif
          
                              <a href="/pesanan/delete/{{$data->id}}" class="btn btn-danger" id="delete"><i class="nav-icon fas fa-trash"></i></a>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
          
          

        <div class="my-2">
          {{$pesanan->withQueryString()->links()}}
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Modal View Detail Start -->
  <div class="modal fade" id="pesananShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Tanggal Pesan :</strong> <span id="pesanan-tgl_pesan"></span></p>
          <p><strong>Jam Cuci :</strong> <span id="pesanan-jam_cuci"></span></p>
          <p><strong>No.Pesanan :</strong> <span id="pesanan-no_pesanan"></span></p>
          <p><strong>Nama :</strong> <span id="pesanan-nama"></span></p>
          <p><strong>Plat Nomor :</strong> <span id="pesanan-plat_nomor"></span></p>
          <p><strong>Jenis Cuci :</strong> <span id="pesanan-jeniscuci"></span></p>
          <p><strong>Jenis Kendaraan :</strong> <span id="pesanan-kategori"></span></p>
          <p><strong>Harga Cuci :</strong> <span id="pesanan-hargacuci"></span></p>
          <p><strong>Harga Kategori :</strong> <span id="pesanan-hargakategori"></span></p>
          <p><strong>Subtotal :</strong> <span id="pesanan-subtotal"></span></p>
          <p><strong>Metode Bayar :</strong> <span style="text-transform: capitalize;" id="pesanan-metode"></span></p>
          <p><strong>Status :</strong> <span id="pesanan-status"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


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
              $('#pesanan-jam_cuci').text(data.jam_cuci);
              $('#pesanan-no_pesanan').text(data.no_pesanan);
              $('#pesanan-nama').text(data.nama);
              $('#pesanan-plat_nomor').text(data.plat_nomor);
              if(data.jeniscuci_id > 0) {
                $('#pesanan-jeniscuci').text(data.jeniscuci.name);
                }
                if(data.kategori_id > 0 ) {
                $('#pesanan-kategori').text(data.kategori.name);
                }
              $('#pesanan-hargacuci').text(data.harga_cuci);
              $('#pesanan-hargakategori').text(data.harga_kategori);
              $('#pesanan-subtotal').text(data.subtotal);
              $('#pesanan-status').text(data.status.name);
              $('#pesanan-metode  ').text(data.metode_bayar);
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
        title: "Hapus Pesanan?",
        text: "Pesanan Akan Dihapus!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus!"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = link;
          Swal.fire(
            "Sukses!",
            "Pesanan Berhasil Dihapus.",
            "success"
          );
        }
      });
    });
  });
  </script>
  <script>
    $(document).ready(function() {
    $('.table-sortable th').on('click', function() {
        // Get header index and current sort order
        var thIndex = $(this).index();
        var sortOrder = $(this).data('sort-order') || 'asc';

        // Toggle sort order
        sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';

        // Add `current` class to clicked header and remove from others
        $(this).addClass('current').siblings().removeClass('current');

        // Apply sort arrows (optional)
        $(this).find('.sort-icon').remove();
        $(this).append('<i class="sort-icon fas fa-' + sortOrder + '"></i>');

        // Sort table accordingly
        $('.table-sortable tbody tr').sort(function(a, b) {
            var sortA = $(a).children().eq(thIndex).text().toLowerCase();
            var sortB = $(b).children().eq(thIndex).text().toLowerCase();

            if (sortOrder === 'asc') {
                return sortA > sortB ? 1 : -1;
            } else {
                return sortA < sortB ? 1 : -1;
            }
        }).appendTo('.table-sortable tbody');

        // Update sort order attribute
        $(this).data('sort-order', sortOrder);
    });
});

  </script>
@endsection