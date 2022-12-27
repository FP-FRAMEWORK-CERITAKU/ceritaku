<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $data = auth()->user() ?? request()->user() ?? null;

        return view('pages.profile.account', compact([
            'data'
        ]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $withMessage = [
            'status' => 'success',
            'message' => 'Berhasil memperbarui profil'
        ];

        $user = auth()->user() ?? request()->user() ?? null;

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed'
        ]);

        if (array_key_exists('password', $validated) && !empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $updated = $user->update($validated);

        if (!$updated) {
            $withMessage['status'] = 'danger';
            $withMessage['message'] = 'Gagal memperbarui profil';

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        return redirect()->route('profile.index')->with($withMessage);
    }

    public function updatePhoto(Request $request)
    {
        $withMessage = [
            'status' => 'success',
            'message' => 'Berhasil memperbarui foto profil'
        ];

        $user = auth()->user() ?? request()->user() ?? null;

        $doDelete = $request->input('delete', false);

        if ($doDelete) {
            $user->deletePhoto();
            $updated = true;
        } else {
            $validated = $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);
            $updated = $user->savePhoto($validated['photo']);
        }

        if (!$updated) {
            $withMessage['status'] = 'danger';
            $withMessage['message'] = 'Gagal memperbarui foto profil';

            return redirect()->back()
                ->withInput()
                ->with($withMessage);
        }

        return redirect()->route('profile.index')->with($withMessage);
    }
}
