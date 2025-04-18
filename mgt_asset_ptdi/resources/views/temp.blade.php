@extends('employee.master')

@section('content')
@include('employee.component.modal-add-organisasi')
    <!-- TITLE -->
   <div class="container" data-aos="fade-up">
        <div class="section-title" data-aos="fade-up">
            <h2>Daftar Role</h2>
        </div>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="m-0 font-weight-bold">
                                <a href="/organisasi/create" class="btn btn-primary">+ Tambah Organisasi</a>
                            </h6>
                        </div>
                        
                        <form id="searchForm" method="GET" action="{{ route('organisasi.index') }}">
                            <div class="mb-3 d-flex justify-content-between">
                                <div class="input-group me-2">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search Organisasi" value="{{ request('search') }}">
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- TABEL -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                            <thead>
                                <tr>
                                  <th>NIK</th>
                                  <th>Role</th>
                                  <th>Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                          @forelse ($actor as $item)
                              <tr>
                                  <td>{{ $item['nik'] }}</td>
                                  <td>{{ $item['roles'] }}</td>
                                  <td>
                                      @if (str_contains($item['roles'], 'admin') && $admin > 1)
                                          <form action="{{ route('delete-role', $item['nik']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this employee?');" style="padding: 0; margin: 0;">
                                              @csrf
                                              @method('DELETE')
                                              <button class="btn btn-danger" type="submit">Hapus Dari Admin</button>
                                          </form>
                                      @elseif (str_contains($item['roles'], 'karyawan') && !str_contains($item['roles'], 'admin'))
                                          <form action="{{ route('update-role', $item['nik']) }}" method="POST">
                                              @csrf
                                              @method('PUT')
                                              <button type="submit" class="btn btn-success">Jadikan Admin</button>
                                          </form>
                                      @else
                                          -
                                      @endif
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="3" class="text-center">Tidak ada data.</td>
                              </tr>
                          @endforelse
                      </tbody>
                    </table>

                    </div>
                </div>
            </div>
        </div>
   </div>

@endsection
