<?php

namespace App\Http\Controllers\Api;

use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // return response()->json(['request' => $request->all()]);
        $invoices = auth()->user()->invoices();
        if($request->get('clinicId')) $invoices->where('clinic_id', $request->get('clinicId'));
        if($request->get('showOnlyUnpaid') == 'true') $invoices->where('payment_date', null);
        if($request->get('dateType') and $request->get('datePicker1') and $request->get('datePicker2')):
            $date_type = $request->get('dateType');
            $datepicker1 = date('Y-m-d', strtotime($request->get('datePicker1')));
            $datepicker2 = date('Y-m-d', strtotime($request->get('datePicker2')));
            $invoices->whereDate($date_type,'>=',$datepicker1)->whereDate($date_type,'<=',$datepicker2);
        endif;
        $invoices->orderBy($request->get('sortField'), $request->get('sortOrder'));

        return response()->json([
            'items' => $invoices->get()
        ]);

    	// return response()->json([$request->all()]);
        // if($request->get('only_unpaid') == 'true'):
        //     if($request->get('date_type') and $request->get('datepicker1') and $request->get('datepicker2')):
        //         $date_type = $request->get('date_type');
        //         $datepicker1 = date('Y-m-d', strtotime($request->get('datepicker1')));
        //         $datepicker2 = date('Y-m-d', strtotime($request->get('datepicker2')));
        //         $invoices = auth()->user()->invoices()->where('payment_date', null)
        //                            ->whereDate($date_type,'>=',$datepicker1)
        //                            ->whereDate($date_type,'<=',$datepicker2)
        //                            ->orderBy($request->get('order_by'), $request->get('order'))->get();
        //     else:
        //         $invoices = auth()->user()->invoices()->where('payment_date', null)
        //                            ->orderBy($request->get('order_by'), $request->get('order'))->get();
        //     endif;
        // else:
        //     if($request->get('date_type') and $request->get('datepicker1') and $request->get('datepicker2')):
        //         $date_type = $request->get('date_type');
        //         $datepicker1 = date('Y-m-d', strtotime($request->get('datepicker1')));
        //         $datepicker2 = date('Y-m-d', strtotime($request->get('datepicker2')));
        //         $invoices = auth()->user()->invoices()->whereDate($date_type,'>=',$datepicker1)
        //                            ->whereDate($date_type,'<=',$datepicker2)
        //                            ->orderBy($request->get('order_by'), $request->get('order'))->get();
        //     else:
        //         $invoices = auth()->user()->invoices()->orderBy($request->get('order_by'), $request->get('order'))->get();
        //     endif;
        // endif;

    	// return response()->json([
    	// 	'items' => $invoices
    	// ]);
    }

    public function update(Request $request, $id)
    {
    	$invoice = Invoice::find($id);

    	if($request->get('paid')):
    		$payment_date = $request->get('paid') === 'paid' ? null : strtotime(date('Y-m-d'));
    		$invoice->update([
    			'payment_date' => $payment_date
    		]);
    		$invoice->save();
    	endif;

    	return response()->json([
    		'message' => 'La factura ' . $invoice->invoice_no . ' se ha actualizado correctamente.'
    	]);
    }

    public function delete($id)
    {
    	$invoice = Invoice::find($id);
    	$invoice->delete();
    	return response()->json([
    		'message' => 'La factura ' . $invoice->invoice_no . ' se ha eliminado correctamente.'
    	]);
    }
}
