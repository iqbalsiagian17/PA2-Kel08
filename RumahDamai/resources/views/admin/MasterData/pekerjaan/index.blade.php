@extends('layouts.management.master')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="card-title">Jenis Pekerjaan</h1>

                <!-- Tampilkan notifikasi jika ada -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('admin.pekerjaan.create') }}" class="btn btn-success mb-3">Tambah Jenis Pekerjaan</a>
            </div>

            <div class="table-responsive">
                <table class="table mt-3 table-hover">
                    <thead>
                        <tr>
                            <th>Jenis Pekerjaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pekerjaanList as $pekerjaan)
                            <tr>
                                <td>{{ $pekerjaan->jenis_pekerjaan }}</td>
                                <td>
                                    <a href="{{ route('admin.pekerjaan.edit', $pekerjaan->id) }}" class="btn btn-warning">Edit</a>
                                    <form method="POST" id="deleteForm{{ $pekerjaan->id }}" class="d-inline"
                                        action="{{ route('admin.pekerjaan.destroy', $pekerjaan->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="handleDeleteConfirmation('deleteForm{{ $pekerjaan->id }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada Jenis Pekerjaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $pekerjaanList->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
