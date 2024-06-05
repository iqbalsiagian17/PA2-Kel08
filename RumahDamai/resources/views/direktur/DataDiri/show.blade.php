
@extends('layouts.management.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Diri</h4>
                <p class="card-description">{{ $user->nama_lengkap}} {{ $user->nip}}</p>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
                <div class="row">
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>{{ $user->nama_lengkap ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email ?? 'Data tidak tersedia' }}</td>
                                        </tr>
                                        <tr>
                                        <th>NIP</th>
                                        <td>{{ $user->nip ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jenis Kelamin</th>
                                        <td>@if ($user->jenis_kelamin_id)
                                            {{ $jeniskelamin->where('id', $user->jenis_kelamin_id)->first()->jenis_kelamin }}
                                        @else
                                            Jenis kelamin tidak tersedia.
                                        @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Golongan Darah</th>
                                        <td>@if ($user->golongan_darah_id)
                                            {{ $golongandarah->where('id', $user->golongan_darah_id)->first()->golongan_darah }}
                                        @else
                                            Golongan darah tidak tersedia.
                                        @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Agama</th>
                                        <td>@if ($user->agama_id)
                                            {{ $agama->where('id', $user->agama_id)->first()->agama }}
                                        @else
                                            Agama tidak tersedia.
                                        @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Pendidikan</th>
                                        <td>@if ($user->pendidikan_id)
                                            {{ $pendidikan->where('id', $user->pendidikan_id)->first()->tingkat_pendidikan }}
                                        @else
                                            Pendidikan tidak tersedia.
                                        @endif</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>{{ $user->alamat ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mulai Kerja</th>
                                        <td>{{ $user->tanggal_masuk ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tempat Lahir</th>
                                        <td>{{ $user->tempat_lahir ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Lahir</th>
                                        <td>{{ $user->tanggal_lahir ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi Penugasan</th>
                                        <td>@if ($user->lokasi_penugasan_id)
                                            {{ $lokasi->where('id', $user->lokasi_penugasan_id)->first()->lokasi }}
                                        @else
                                            Lokasi penugasan tidak tersedia.
                                        @endif
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       
                    </div>
                    <div class="col-md-4">
                        <div class="image-frame">
                            @if ($user->foto)
                            <img src="{{asset('uploads/pegawai/' . $user->foto)  }}" alt="Foto Profil user"
                                    class="img-fluid rounded">
                            @else
                                <p>Tidak ada foto profil.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('direktur.DataDiri.edit', ['user' => $user->id]) }}" class="btn btn-primary">Edit Profil</a>

            </div>
        </div>
    </div>
@endsection
