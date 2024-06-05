@extends('layouts.management.master')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="card-title">Data Tingkat Pendidikan</h1>

                <!-- Tampilkan notifikasi jika ada -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('admin.pendidikan.create') }}" class="btn btn-success mb-3">Tambah Tingkat Pendidikan</a>
            </div>

            <div class="table-responsive">
                <table class="table mt-3 table-hover">
                    <thead>
                        <tr>
                            <th>Tingkat Pendidikan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendidikanList as $pendidikan)
                            <tr>
                                <td>{{ $pendidikan->tingkat_pendidikan }}</td>
                                <td>
                                    <a href="{{ route('admin.pendidikan.edit', $pendidikan->id) }}" class="btn btn-warning">Edit</a>
                                    <form method="POST" id="deleteForm{{ $pendidikan->id }}" class="d-inline"
                                        action="{{ route('admin.pendidikan.destroy', $pendidikan->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger"
                                            onclick="handleDeleteConfirmation('deleteForm{{ $pendidikan->id }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada data tingkat pendidikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $pendidikanList->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
