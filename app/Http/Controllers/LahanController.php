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

class LahanController extends Controller
{
    public function lahanPekerjaan($id) {
        $lahan = Lahan::where('id', $id)->with('users')->first();
        $pekerjaan = ProgressPekerjaanLahan::where('lahan_id', $id)->get();
        $petani = PekerjaanLahan::where('lahan_id', $id)->with('users')->get();
        return Inertia::render('Lahan/Lahan', [
            'lahan' => $lahan,
            'pekerjaan' => $pekerjaan,
            'petani' => $petani
        ]);
    }
}
