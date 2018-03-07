<?php

namespace App\Http\Controllers\Api;

use App\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClinicController extends Controller
{
    public function index(Request $request)
    {
        $clinics = auth()->user()->clinics()
                    ->with('invoices')
                    ->where('name', 'like', '%'.$request->get('clinicName').'%');

        if($request->get('sortField') == 'facturas'):
            $clinics->withCount('invoices')->orderBy('invoices_count', $request->get('sortOrder'));
        else:
            $clinics->orderBy($request->get('sortField'), $request->get('sortOrder'));
        endif;

        return response()->json([
            'clinics' => $clinics->get()
        ]);
    }

    public function delete($id)
    {
    	$clinic = Clinic::find($id);
    	$clinic->delete();
    	return response()->json([
    		'message' => 'La clínica ' . $clinic->name . ' se ha eliminado correctamente.'
    	]);
    }

    public function deactivate($id)
    {
        $clinic = Clinic::find($id);
        $clinic->active = false;
        $clinic->save();
        return response()->json([
            'message' => 'La clínica ' . $clinic->name . ' se ha desactivado correctamente.'
        ]);
    }
}
