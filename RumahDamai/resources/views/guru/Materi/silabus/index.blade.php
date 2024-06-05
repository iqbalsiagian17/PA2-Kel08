@extends('layouts.management.master')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="card-title">Data Silabus</h1>
                    <!-- Tampilkan notifikasi jika ada -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <a href="{{ route('silabus.create') }}" class="btn btn-success mb-3">Tambah Silabus</a>
                </div>

                <div class="table-responsive">
                    <table class="table mt-3 table-hover">
                        <thead>
                            <tr>
                                <th>Nama Silabus</th>
                                <th>Tahun Kurikulum</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($silabusList as $silabus)
                                <tr>
                                    <td>{{ $silabus->kelas->nama_kelas }}</td>
                                    <td>{{ $silabus->tahunKurikulum->tahun_kurikulum }}</td>
                                    <td>
                                        <a href="{{ route('silabus.show', $silabus->id) }}"
                                            class="btn btn-info">Detail</a>
                                        <a href="{{ route('silabus.edit', $silabus->id) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" id="deleteForm{{ $silabus->id }}" class="d-inline"
                                            action="{{ route('silabus.destroy', $silabus->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger"
                                                onclick="handleDeleteConfirmation('deleteForm{{ $silabus->id }}')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">Tidak ada data Silabus.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $silabusList->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
