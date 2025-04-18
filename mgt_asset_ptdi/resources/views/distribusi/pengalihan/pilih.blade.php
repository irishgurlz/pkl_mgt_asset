@extends('employee.master')

@section('content')
<!-- TITLE -->
<div class="container section-title" data-aos="fade-up">
    <h2>Pengalihan Asset</h2>
</div><!-- End Section Title -->
  <div class="container">
    <div class="row d-flex justify-content-center">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-end">
                    <form id="searchForm" method="GET">
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="input-group me-2">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Search Asset" value="{{ request('search') }}">
                            </div>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>
                    
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive" style="overflow:hidden">
                    <!-- Table Device -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nomor Penyerahan</th>
                                        <th>Pemilik</th>
                                        <th>Jenis</th>
                                        <th>Nomor Asset</th>
                                        <th>Alihkan</th>
                                    </tr>
                                </thead>
                                @include('distribusi.pengalihan.table-pilih')
                            </table>
                            @include('paginate', ['paginator' => $distribution])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    function fetchUserData() {
        let nik = $('#nik').val(); 

        if (nik.length > 0) { 
            $.ajax({
                url: "/fetch-user-data",
                type: 'GET',
                data: { nik: nik }, 
                success: function(response) {
                    if (response.success) {
                        $('#nama').val(response.nama);
                        $('#kode_org').val(response.kode_org);
                        $('#nik-status').text('');
                    } else {
                        $('#nama').val('');
                        $('#kode_org').val('');
                        $('#nik-status').text('nik tidak ada');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        } else {
            $('#nama').val('');
            $('#kode_org').val('');
        }
    }

</script>

<script>
        document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const tableBody = document.querySelector('tbody');
    const distId = "{{ $dist->id }}"; 

    searchInput.addEventListener('keyup', function(event) {
        let searchQuery = searchInput.value;

        fetch(`/distribusi/${distId}/pilihPengalihan?search=${searchQuery}`, {
            method: 'GET',
            headers: {
                'Accept': 'text/html',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            tableBody.innerHTML = data;
        });
    });
});

</script>


@endsection