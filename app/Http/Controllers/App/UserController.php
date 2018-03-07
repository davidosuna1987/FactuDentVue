<?php

namespace App\Http\Controllers\App;

use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateSettingsRequest;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('app.index', compact('user'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('app.user.profile', compact('user'));
    }


    public function updateProfile(UpdateUserRequest $request)
    {
        $user = auth()->user();

        if($request->get('password') != ''):
            $user->password = bcrypt($request->get('password'));
        endif;
        $user->name = $request->get('name');
        $user->surnames = $request->get('surnames');
        $user->nif = $request->get('nif');
        $user->phone = $request->get('phone');
        $user->nickname = $request->get('nickname');
        $user->address = $request->get('address');
        $user->locality = $request->get('locality');
        $user->province = $request->get('province');
        $user->country = $request->get('country');
        $user->post_code = $request->get('post_code');
        $user->save();

        Session::flash('message', 'Tu perfil se ha actualizado correctamente!');
        if(auth()->user()->isAdmin()):
            return redirect()->route('admin.index');
        else:
            return redirect()->route('app.index');
        endif;
    }

    public function settings(){
        $user = auth()->user();
        return view('app.user.settings', compact('user'));
    }

    public function updateSettings(UpdateSettingsRequest $request)
    {
        $user = auth()->user();
        $user->pdf_color = $request->get('pdf_color');
        $user->show_logo = ($request->get('show_logo')) ? true : false;
        $user->show_advertising = ($request->get('show_advertising')) ? true : false;
        $user->default_percentage = $request->get('default_percentage');
        $user->default_retention = $request->get('default_retention');
        if($request->get('remove_custom_logo') == '1'):
            $path = public_path().'/images/custom-logos/'.$user->id.'/*';
            $files = glob($path);
            foreach($files as $file):
              if(is_file($file)) unlink($file);
            endforeach;
            $user->custom_logo_filename = null;
            $user->custom_logo = null;
        else:
            if($request->file('custom_logo')):
                // $path = Storage::disk('public')->put('images/custom-logos/'.$user->id, $request->file('custom_logo'));
                // $user->custom_logo = asset($path);
                $file = $request->file('custom_logo');
                $filename = $file->getClientOriginalName();
                $path = public_path().'/images/custom-logos/'.$user->id.'/';
                if($user->custom_logo_filename and \File::exists($path.$user->custom_logo_filename)):
                    unlink($path.$user->custom_logo_filename);
                endif;
                \File::makeDirectory($path, $mode = 0777, true, true);
                $file->move($path, $file->getClientOriginalName());
                $user->custom_logo_filename = $filename;
                $user->custom_logo = asset('images/custom-logos/'.$user->id.$filename);
            endif;
        endif;
        $user->save();
        Session::flash('message', 'Los ajustes se han actualizado correctamente!');
        if(auth()->user()->isAdmin()):
            return redirect()->route('admin.index');
        else:
            return redirect()->route('app.index');
        endif;
    }
}
