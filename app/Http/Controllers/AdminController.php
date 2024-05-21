<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Lahan;
use App\Models\PekerjaanLahan;
use App\Models\ProgressPekerjaanLahan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //dashboard
    public function dashboardIndex(){
        if(auth()->user()->role == 'admin'){
            $datas = [];
            $pemiliklahan = User::where('role', 'pemilik_lahan')->get();
            foreach($pemiliklahan as $pemilik){
                $lahan = $pemilik->lahan;

                foreach($lahan as $l){
                    $totalPekerjaan = $l->progressPekerjaanLahan()->count();
                    $pekerjaanSelesai = $l->progressPekerjaanLahan()->where('status', 1)->count();

                    if ($totalPekerjaan > 0) {
                        $persentasePekerjaan = ($pekerjaanSelesai / $totalPekerjaan) * 100;
                    } else {
                        $persentasePekerjaan = 0;
                    }
                    
                    $datas[] = [
                        'pemilik' => $pemilik,
                        'lahan' => $l,
                        'persentasePekerjaan' => $persentasePekerjaan
                    ];
                }
                usort($datas, function($a, $b) {
                    return $a['persentasePekerjaan'] <= $b['persentasePekerjaan'];
                });
            }
            return Inertia::render('Dashboard', [
                'datas' => $datas
            ]);
        }

        if(auth()->user()->role == 'petani') {
            $user_id = auth()->user()->id;
            $pekerjaan = PekerjaanLahan::where('users_id', $user_id)->pluck('lahan_id'); 
            $datas = [];
            foreach ($pekerjaan as $lahan_id) {
                $totalPekerjaan = ProgressPekerjaanLahan::where('lahan_id', $lahan_id)->count();
                $pekerjaanSelesai = ProgressPekerjaanLahan::where('lahan_id', $lahan_id)->where('status', 1)->count();
        
                if ($totalPekerjaan > 0) {
                    $persentasePekerjaan = ($pekerjaanSelesai / $totalPekerjaan) * 100;
                } else {
                    $persentasePekerjaan = 0;
                }
        
                $lahan = Lahan::find($lahan_id);
                $user_id = $lahan->users_id;
                $pemilik = User::find($user_id);
                $datas[] = [
                    'pemilik' => $pemilik,
                    'lahan' => $lahan,
                    'persentasePekerjaan' => $persentasePekerjaan
                ];
                usort($datas, function($a, $b) {
                    return $a['persentasePekerjaan'] <=> $b['persentasePekerjaan'];
                });
            }
        
            return Inertia::render('Dashboard', [
                'datas' => $datas
            ]);
        }
        
        if(auth()->user()->role == 'pemilik_lahan') {
            $datas = [];
            $pemiliklahan = User::where('id', auth()->user()->id)->get();
            foreach($pemiliklahan as $pemilik){
                $lahan = $pemilik->lahan;

                foreach($lahan as $l){
                    $totalPekerjaan = $l->progressPekerjaanLahan()->count();
                    $pekerjaanSelesai = $l->progressPekerjaanLahan()->where('status', 1)->count();

                    if ($totalPekerjaan > 0) {
                        $persentasePekerjaan = ($pekerjaanSelesai / $totalPekerjaan) * 100;
                    } else {
                        $persentasePekerjaan = 0;
                    }
                    
                    $datas[] = [
                        'pemilik' => $pemilik,
                        'lahan' => $l,
                        'persentasePekerjaan' => $persentasePekerjaan
                    ];
                }
                usort($datas, function($a, $b) {
                    return $a['persentasePekerjaan'] <= $b['persentasePekerjaan'];
                });
            }
            return Inertia::render('Dashboard', [
                'datas' => $datas
            ]);
        }
    }

    //approve pekerjaan
    public function approvePekerjaan(Request $request, $id){
        Lahan::where('id', $id)->update([
            'status' => true,
            'pekerjaan_selesai' => Carbon::now()
        ]);
        return redirect()->back()->with('status', 'Pekerjaan selesai berhasil di approve');
    }

    //petani page
    public function petanipage(Request $request){
        $search = $request->query('search');
        $petani = User::where('role','petani')
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->
        withCount([
            'pekerjaanlahan as pekerjaan'
        ])->paginate(5);
        return Inertia::render('Admin/PetaniPage',[
            'header' => 'Halaman Data Petani',
            'petani' => $petani,
        ]);
    }

    //regis user
    public function regisUser(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_telfon' => 'required|numeric',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_telfon' => $request->no_telfon,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        if($request->role == 'petani'){
        return redirect('/dashboard/petani-page')->with('status', 'Register Berhasil!');
        } else if($request->role == 'pemilik_lahan') {
        return redirect('/dashboard/lahan-page')->with('status', 'Register Berhasil!'); 
        }
    }

    //delete petani
    public function deletePetani(Request $request, $id){
        $ids = User::where('id', $id)->delete();
        $pekerjaan_lahan = PekerjaanLahan::where('users_id', $id)->delete();
        return Inertia::location(route('petanipage.view'));
    }

    //edit petani
    public function editPetani($id){
        $petani = User::where('id', $id)->first();
        return Inertia::render('Admin/EditPetani', [
            'header' => 'Halaman Edit Petani',
            'petani' => $petani
        ]);
    }

     //edit pemilik lahan
     public function editPemilikLahan($id){
        $petani = User::where('id', $id)->first();
        return Inertia::render('Admin/EditPemilikLahan', [
            'header' => 'Halaman Edit Pemilik Lahan',
            'petani' => $petani
        ]);
    }

    //update petani
    public function updateUser(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_telfon' => 'numeric',
        ]);

        $user = User::where('id', $request->id)->update([
            'name' => $request->name,
            'no_telfon' => $request->no_telfon,
            'password' => Hash::make($request->password)
        ]);

        if($request->role == 'petani'){
            return redirect('/dashboard/petani-page')->with('status', 'Data petani berhasil diupdate!');
        } else if($request->role == 'pemilik_lahan') {
            return redirect('/dashboard/lahan-page')->with('status', 'Data pemilik lahan berhasil diupdate!');
        }
    }

    //view petani by Id
    public function viewPetani($id){
        $petaniId = User::where('id', $id)->exists();
        if($petaniId){
        $petani = User::where('id', $id)->first();
        $pekerjaan_lahan = PekerjaanLahan::where('users_id', $id)
        ->with('lahan')->get();
        return Inertia::render('Admin/ViewPetani',[
            'header' => 'Halaman Data Petani',
            'petani' => $petani,
            'pekerjaan_lahan' => $pekerjaan_lahan
        ]);
    } else {
        return redirect('/dashboard/petani-page')->with('statuserror', 'Data tidak ditemukan!');
    }
    }

    //page pemilik lahan
    public function lahanpage(Request $request){
        $search = $request->query('search');
        $lahan = User::where('role','pemilik_lahan')
        ->when($search, function ($query) use ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->
        withCount([
            'lahan as jumlah_lahan'])->paginate(5);

        return Inertia::render('Admin/PemilikLahanPage', [
            'header' => 'Halaman Pemilik Lahan',
            'lahan' => $lahan
        ]);
    }

    //detail pekerjaan petani
    public function petaniPekerjaanLahan($id){
        $petaniProgress = ProgressPekerjaanLahan::where('lahan_id', $id)->get();
        $lahan = Lahan::where('id', $id)->first();
        return response()->json([
            'pekerjaan' => $petaniProgress,
            'lahan' => $lahan
        ]);
    }

    //delete lahan
    public function deleteLahan(Request $request, $id){
        $ids = User::where('id', $id)->delete();
        $lahan = Lahan::where('users_id', $id)->get();
        foreach($lahan as $item){
        PekerjaanLahan::where('lahan_id', $item->id)->delete();
        ProgressPekerjaanLahan::where('lahan_id', $item->id)->delete();
        }
        Lahan::where('users_id', $id)->delete();
        return Inertia::location(route('lahanpage.view'));
    }

    //tambah lahan
    public function tambahLahan(Request $request, $id){
        $pemilik = User::where('role', 'pemilik_lahan')->get();
        $petani = User::where('role', 'petani')
        ->select('*', DB::raw('(SELECT COUNT(*) FROM pekerjaan_lahan WHERE pekerjaan_lahan.users_id = users.id) AS jumlah_pekerjaan'))
        ->get();

        return Inertia::render('Admin/TambahLahan', [
            'header' => 'Tambah data lahan',
            'pemilik' => $pemilik,
            'petani' => $petani,
            'id' => $id
        ]);
    }

    //insert lahan
    public function insertLahan(Request $request){
        $request->validate([
            'pemilik' => 'required',
            'namalahan' => 'required',
            'alamat_lahan' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'luas_lahan' => 'required'
        ]);

        $lahan = Lahan::create([
            'namalahan' => $request->namalahan,
            'alamat_lahan' => $request->alamat_lahan,
            'users_id' => $request->pemilik,
            'luas_lahan' => $request->luas_lahan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => false
        ]);

        $petani = $request->input('petani');
        if($petani !== null){
            foreach($petani as $petanis){
                PekerjaanLahan::create([
                    'lahan_id' => $lahan->id,
                    'users_id' => $petanis
                ]);
            }
        }

        $deskripsiPekerjaan = $request->input('deskripsi_pekerjaan');
        if($deskripsiPekerjaan !== null){
            foreach($deskripsiPekerjaan as $pekerjaan){
                ProgressPekerjaanLahan::create([
                    'lahan_id' => $lahan->id,
                    'deskripsi' => $pekerjaan,
                    'status' => false
                ]);
            }
        }

        return redirect('/dashboard')->with('status', 'Data lahan berhasil ditambah!');
    }

    //halaman manage lahan
    public function manageLahan(Request $request, $id){
        $pemilik = User::where('id', $id)->first();
        $datas = [];
            $lahan = User::where('id', $id)->get();
            foreach($lahan as $pemilik){
                $lahan = $pemilik->lahan;

                foreach($lahan as $l){
                    $totalPekerjaan = $l->progressPekerjaanLahan()->count();
                    $pekerjaanSelesai = $l->progressPekerjaanLahan()->where('status', 1)->count();

                    if ($totalPekerjaan > 0) {
                        $persentasePekerjaan = ($pekerjaanSelesai / $totalPekerjaan) * 100;
                    } else {
                        $persentasePekerjaan = 0;
                    }
                    
                    $datas[] = [
                        'pemilik' => $pemilik,
                        'lahan' => $l,
                        'persentasePekerjaan' => $persentasePekerjaan
                    ];
                }
                usort($datas, function($a, $b) {
                    return $a['persentasePekerjaan'] <= $b['persentasePekerjaan'];
                });
            }

            return Inertia::render('Admin/ManageLahan', [
                'lahan' => $datas,
                'pemilik' => $pemilik
            ]);
    }

    //manage pekerjaan
    public function lahanPekerjaan($id) {
        $lahan = Lahan::where('id', $id)->with('users')->first();
        $pekerjaan = ProgressPekerjaanLahan::where('lahan_id', $id)->get();
        $petani = PekerjaanLahan::where('lahan_id', $id)->with('users')->get();
        $listpetani = User::where('role', 'petani')
        ->select('*', DB::raw('(SELECT COUNT(*) FROM pekerjaan_lahan WHERE pekerjaan_lahan.users_id = users.id) AS jumlah_pekerjaan'))
        ->get();

        return Inertia::render('Admin/Lahan',[
            'lahan' => $lahan,
            'pekerjaan' => $pekerjaan,
            'petani' => $petani,
            'listpetani' => $listpetani
        ]);
    }

    //edit lahan info
    public function editInfoLahan(Request $request) {
        $id = $request->id;
        $request->validate([
            'namalahan' => 'required',
            'alamat_lahan' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'luas_lahan' => 'required'
        ]);
        Lahan::where('id', $id)->update([
            'namalahan' => $request->namalahan,
            'alamat_lahan' => $request->alamat_lahan,
            'luas_lahan' => $request->luas_lahan,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        return redirect()->back();
    }

    //maps lahan
    public function mapsLahan($id){
        $lahan = Lahan::where('id', $id)->first();
        return Inertia::render('MapsLahan', [
            'header' => 'Maps',
            'lahan' => $lahan
        ]);
    }

    //delete lahan partial 
    public function deleteLahanPartial(Request $request) {
        $id = $request->id;
        $usersid = $request->users_id;
        Lahan::where('id', $id)->delete();
        PekerjaanLahan::where('lahan_id', $id)->delete();
        ProgressPekerjaanLahan::where('lahan_id', $id)->delete();
        return redirect('/dashboard/lahan-page/manage/'.$usersid)->with('status', 'Lahan berhasil dihapus');
    }

    //add pekerjaan
    public function addPekerjaan(Request $request) {
        $id = $request->lahan_id;
        ProgressPekerjaanLahan::where('lahan_id', $id)->create([
            'deskripsi' => $request->deskripsi,
            'lahan_id' => $id,
            'status' => 0
        ]);
        return redirect()->back();
    }

    //delete pekerjaan
    public function deletePekerjaan(Request $request) {
        $id = $request->id;
        ProgressPekerjaanLahan::where('id', $id)->delete();
        return redirect()->back();
    }

    //update pekerjaan
    public function updatePekerjaan(Request $request) {
        $id = $request->id;
        $deskripsi = $request->deskripsi;
        ProgressPekerjaanLahan::where('id', $id)->update([
            'deskripsi' => $deskripsi
        ]);
        return redirect()->back();
    }

    //add petani
    public function addPetani(Request $request) {
        $lahan_id = $request->lahan_id;
        $users_id = $request->users_id;

        PekerjaanLahan::create([
            'lahan_id' => $lahan_id,
            'users_id' => $users_id
        ]);
        return redirect()->back();
    }

    //delete petani
    public function deletePetaniLahan(Request $request) {
        $id = $request->id;
        PekerjaanLahan::where('id', $id)->delete();
        return redirect()->back();
    }
}
