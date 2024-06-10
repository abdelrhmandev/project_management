<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\UploadAble;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    use UploadAble;

    public function __construct(User $model)
    {
        $this->model = $model;
        $this->resource = 'pages.profile.index';
        $this->trans_file = 'site';
    }

    public function index()
    {
        $compact      = [
            'row'     => User::where('id', Auth::user()->id)->first(),
            'regions' => Region::get()
        ];

        return view($this->resource, $compact);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $avatar = '';
        if (!empty($request->avatar)) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatar = $this->uploadOne($request->avatar, 'users-avatar');
        }

        $data = [
            'name'      => $request->name,
            'national_id' => $request->national_id,
            'region_id' => $request->region_id,
            'mobile'    => $request->mobile
        ];
        if (!empty($request->avatar)) {
            $data['avatar'] = !empty($request->avatar)? $avatar : 'uploads/users-avatar/blank.png';
        }
        
        if (!(empty($request->password))) {
            User::whereId(auth()->user()->id)->update([
                'password' => \Hash::make($request->password)
            ]);
        }

        User::where('id', Auth::user()->id)->update($data);
        return back()->with('success', trans('site.updateMessageSuccess'));
    }
}
