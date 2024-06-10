<?php

namespace App\Http\Controllers;

use App\Traits\Functions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GmailCredential;

class CredentialController extends Controller
{
    protected $model;
    protected $resource;
    protected $trans_file;
    use Functions;

    public function __construct(GmailCredential $model)
    {
        $this->model = $model;
        $this->resource = 'pages.credentials';
        $this->trans_file = 'site';
    }

    public function index(Request $request)
    {
        $compact                          = [
            'row' => GmailCredential::query()->where('id', '=', 1)->first(),
        ];

        return view($this->resource . '.index', $compact);
    }

    public function update(Request $request)
    {
        $credential  = GmailCredential::query()->where('id', '=', 1)->first();
        if ($credential) {
            $credential->update(['email' => $request->email, 'password' => base64_encode($request->password)]);
            return back()->with('success', trans('site.updateMessageSuccess'));
        }
    }
}
