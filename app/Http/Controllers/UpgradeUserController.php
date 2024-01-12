<?php

namespace App\Http\Controllers;

use App\Models\UpgradeUser;
use App\Traits\CompanyTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UpgradeUserController extends Controller
{

    use CompanyTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = UpgradeUser::query();
        if ($request->filled('search')) {
            $query->orWhereRelation('user', 'name', 'like', "%$request->search%");
        }
        $data = $query->whereNotNull('reason')->paginate(10)->withQueryString();
        return view('upgrade.index', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'reason'    => 'required|min:500|max:1000',
            'cv'        => 'required|mimes:pdf|max:2048'
        ]);
        $user = $this->getUser();
        if ($user->role != 'user') {
            return redirect()->back()->with(['error' => 'You are not User!']);
        }
        $cv = null;
        $upgrade = UpgradeUser::where('user_id', $user->id)->first();
        if ($upgrade) {
            $cv = $upgrade->cv;
        }
        $files = $request->file('cv');
        $new_cv = 'cv_' . date('dmyHis') . '.' . $files->getClientOriginalExtension();
        $files->move(public_path('files/cv/'), $new_cv);
        if ($upgrade) {
            if (!empty($cv) && file_exists(public_path('files/cv' . $cv))) {
                File::delete(public_path('files/cv/' . $cv));
            }
            $upgrade->update([
                'user_id'   => $user->id,
                'date'      => date('Y-m-d H:i:s'),
                'reason'    => $request->reason,
                'status'    => 'pending',
                'cv'        => $new_cv,
            ]);
        } else {
            UpgradeUser::create([
                'user_id'   => $user->id,
                'date'      => date('Y-m-d H:i:s'),
                'reason'    => $request->reason,
                'status'    => 'pending',
                'cv'        => $new_cv,
            ]);
        }
        return redirect()->back()->with(['success' => 'Upload Data Success!']);
    }

    public function show(UpgradeUser $upgrade)
    {
        $data = $upgrade->load('user');
        return view('upgrade.detail', compact('data'));
    }

    public function edit(UpgradeUser $upgrade)
    {
        $file = $upgrade->cv;
        $path = public_path('files/cv/');
        if (empty($file) || !file_exists($path . $file)) {
            return redirect()->back()->with(['error' => 'CV Not Ready!']);
        }
        return response()->download($path . $file);
    }

    public function destroy(UpgradeUser $upgrade)
    {
        if ($upgrade->status == 'acc') {
            return redirect()->route('upgrade.index')->with(['error' => 'Data Already ACC!']);
        }
        $upgrade->update([
            'date'      => date('Y-m-d H:i:s'),
            'status'    => 'reject',
        ]);
        return redirect()->route('upgrade.index')->with(['success' => 'Reject Data Success!']);
    }

    public function acc(UpgradeUser $upgrade)
    {
        if ($upgrade->user->role == 'admin') {
            return redirect()->route('upgrade.index')->with(['error' => 'Admin Cannot Downgrade!']);
        }
        if ($upgrade->status == 'acc') {
            return redirect()->route('upgrade.index')->with(['error' => 'Data Already ACC!']);
        }
        $upgrade->user->update([
            'role' => 'mentor',
        ]);
        $upgrade->update([
            'date'      => date('Y-m-d H:i:s'),
            'status'    => 'acc',
        ]);
        return redirect()->route('upgrade.index')->with(['success' => 'ACC Data Success!']);
    }
}
