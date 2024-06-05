<?php

namespace App\Http\Controllers\Staff\DataSponsor;

use App\Models\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsorList = Sponsor::orderBy('created_at', 'desc')->paginate(7);
        return view('staff.DataSponsor.index', compact('sponsorList'));
    }

    public function create()
    {
        $sponsorship = Sponsorship::all();
        $loggedInUserId = Auth::id();
        $users = User::where('role', 'staff')->where('id', $loggedInUserId)->get();
        return view('staff.DataSponsor.create', compact('sponsorship'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sponsorship_id' => 'required|array',
            'sponsorship_id.*' => 'exists:sponsorship,id',
            'nama_sponsor' => 'required|string',
            'email_sponsor' => 'required|string',
            'tanggal_sponsor' => 'required|date',
            'no_telepon_sponsor' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
            'jumlah_sponsor' => 'nullable|string',
            'foto_sponsor' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Assign logged in user ID
        $validatedData['user_id'] = Auth::id();

        // Proses upload foto_sponsor
        if ($request->hasFile('foto_sponsor')) {
            $gambar = $request->file('foto_sponsor');
            $slug = Str::slug(pathinfo($gambar->getClientOriginalName(), PATHINFO_FILENAME));
            $new_gambar = time() . '_' . $slug . '.' . $gambar->getClientOriginalExtension();

            $gambar->move('uploads/sponsor/', $new_gambar);

            $validatedData['foto_sponsor'] = 'uploads/sponsor/' . $new_gambar;
        }

        $sponsor = Sponsor::create($validatedData);

        // Menyimpan relasi dengan sponsor
        if (isset($validatedData['sponsorship_id'])) {
            $sponsor->sponsorship()->attach($validatedData['sponsorship_id']);
        }

        return redirect()->route('dataSponsor.index')->with('success', 'Data Sponsor berhasil ditambahkan.');
    }

    public function show($id)
    {
        $sponsor = Sponsor::with('sponsorship')->find($id);
        return view('staff.DataSponsor.show', compact('sponsor'));
    }

    public function edit($id)
    {
        $sponsorship = Sponsorship::all();
        $sponsor = Sponsor::find($id);
        return view('staff.DataSponsor.edit', compact('sponsorship', 'sponsor'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sponsorship_id' => 'nullable|array',
            'sponsorship_id.*' => 'exists:sponsorship,id',
            'nama_sponsor' => 'nullable|string',
            'email_sponsor' => 'nullable|string',
            'tanggal_sponsor' => 'nullable|date',
            'no_telepon_sponsor' => 'nullable|numeric',
            'deskripsi' => 'nullable|string',
            'jumlah_sponsor' => 'nullable|string',
            'foto_sponsor' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Assign logged in user ID
        $validatedData['user_id'] = Auth::id();

        $sponsor = Sponsor::findOrFail($id);

        // Proses upload foto_sponsor
        if ($request->hasFile('foto_sponsor')) {
            $gambar = $request->file('foto_sponsor');
            $slug = Str::slug(pathinfo($gambar->getClientOriginalName(), PATHINFO_FILENAME));
            $new_gambar = time() . '_' . $slug . '.' . $gambar->getClientOriginalExtension();

            $gambar->move('uploads/sponsor/', $new_gambar);

            // Hapus foto lama jika ada
            if ($sponsor->foto_sponsor) {
                unlink(public_path($sponsor->foto_sponsor));
            }

            $validatedData['foto_sponsor'] = 'uploads/sponsor/' . $new_gambar;
        }

        $sponsor->update($validatedData);

        // Menyimpan relasi dengan sponsor
        if (isset($validatedData['sponsorship_id'])) {
            $sponsor->sponsorship()->sync($validatedData['sponsorship_id']);
        } else {
            $sponsor->sponsorship()->detach();
        }

        return redirect()->route('dataSponsor.index')->with('success', 'Data Sponsor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $sponsor = Sponsor::findOrFail($id);

        // Menghapus foto sponsor jika ada
        if ($sponsor->foto_sponsor) {
            Storage::delete($sponsor->foto_sponsor);
        }

        // Menghapus relasi sponsor
        $sponsor->sponsorship()->detach();

        // Menghapus data sponsor
        $sponsor->delete();

        return redirect()->route('dataSponsor.index')->with('success', 'Data Sponsor berhasil dihapus.');
    }
}
