<!DOCTYPE html>
<html lang="en">

<head>
  <title>Daftar Pengajuan</title>
</head>

@extends('employee.master')

@section('content')

    <!-- TITLE -->
<div class="container" data-aos="fade-up">
    <div class="section-title" data-aos="fade-up">
        <h2>Daftar Pengajuan</h2>
    </div>

    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-end">
                <form id="searchForm" method="GET">
                    <div class="mb-3 d-flex justify-content-between"">
                        <div class="input-group me-2">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search History" value="{{ request('search') }}">
                        </div>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tableData" width="100%" cellspacing="0" style="table-layout: auto;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Pemilik</th>
                                <th>Nomor Penyerahan</th>
                                <th>Nomor Asset</th>
                                {{-- <th>Deskripsi</th> --}}
                                <th>Status</th>
                                <th>Detail</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        @include('distribusi.table-history-pengajuan', ['history' => $history])
                    </table>
                    @include('paginate', ['paginator' => $history])
                </div>
            </div>
        </div>
    </div>

<script>
    function handleSelectChange(selectElement, itemId) {
        const newStatus = selectElement.value;

        fetch(`/update-status/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({
                status_pengajuan: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const statusBadge = document.getElementById('status-' + itemId);
                if (newStatus == 1) {
                    statusBadge.className = 'badge rounded-pill bg-warning';
                    statusBadge.textContent = 'Menunggu';
                } else if (newStatus == 2) {
                    statusBadge.className = 'badge rounded-pill bg-success';
                    statusBadge.textContent = 'Disetujui';
                } else if (newStatus == 3) {
                    statusBadge.className = 'badge rounded-pill bg-danger';
                    statusBadge.textContent = 'Ditolak';
                }
            } else {
                alert('Terjadi kesalahan saat memperbarui status.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const tableBody = document.querySelector('tbody');

        searchInput.addEventListener('keyup', function(event) {
            let searchQuery = searchInput.value;

            fetch("{{ route('history-pengajuan') }}?search=" + searchQuery, {
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
