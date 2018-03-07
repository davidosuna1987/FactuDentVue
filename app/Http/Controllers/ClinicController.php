<?php

namespace App\Http\Controllers;

use Alert;
use Session;
use App\Clinic;
use App\Invoice;
use App\InvoiceLine;
use Illuminate\Http\Request;
use App\Http\Requests\CreateClinicRequest;
use App\Http\Requests\UpdateClinicRequest;

class ClinicController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $clinics = $user->clinics();
        return view('app.clinics.index', compact('clinics'));
    }

    public function create()
    {
        return view('app.clinics.create');
    }

    public function store(CreateClinicRequest $request)
    {
        $clinic = new Clinic;
        $clinic->user_id = auth()->user()->id;
        $clinic->name = $request->get('name');
        $clinic->contact = $request->get('contact');
        $clinic->email = $request->get('email');
        $clinic->nif = $request->get('nif');
        $clinic->address = $request->get('address');
        $clinic->locality = $request->get('locality');
        $clinic->province = $request->get('province');
        $clinic->country = $request->get('country');
        $clinic->post_code = $request->get('post_code');
        $clinic->phone = $request->get('phone');
        $clinic->fax = $request->get('fax');
        $clinic->percentage = $request->get('percentage');
        $clinic->active = true;
        $clinic->save();

        Session::flash('message', '¡La clinica se ha agregado correctamente a tu lista!');
        // Alert::success('¡La clinica se ha agregado correctamente a tu lista!', '¡Hecho!!')->persistent('OK');
        return redirect()->route('clinics.index');
    }

    public function show(Clinic $clinic)
    {
        return view('app.clinics.show', compact('clinic'));
    }

    public function edit(Clinic $clinic)
    {
        return view('app.clinics.edit', compact('clinic'));
    }

    public function update(UpdateClinicRequest $request, Clinic $clinic)
    {
        $clinic->name = $request->get('name');
        $clinic->contact = $request->get('contact');
        $clinic->email = $request->get('email');
        $clinic->nif = $request->get('nif');
        $clinic->address = $request->get('address');
        $clinic->locality = $request->get('locality');
        $clinic->province = $request->get('province');
        $clinic->country = $request->get('country');
        $clinic->post_code = $request->get('post_code');
        $clinic->phone = $request->get('phone');
        $clinic->fax = $request->get('fax');
        $clinic->percentage = $request->get('percentage');
        $clinic->save();

        Session::flash('message', '¡La clinica se ha actualizado correctamente!');
        // Alert::success('¡La clinica se ha actualizado correctamente!', '¡Hecho!!')->persistent('OK');
        return redirect()->route('clinics.index');
    }

    public function delete(Clinic $clinic)
    {
        $clinic->delete();
        Session::flash('message', '¡La clinica se ha eliminado correctamente!');
        // Alert::success('¡La clinica se ha eliminado correctamente!', '¡Hecho!!')->persistent('OK');
        return redirect()->route('clinics.index');
    }

    public function deactivate(Clinic $clinic)
    {
        $clinic->active = false;
        $clinic->save();
        Session::flash('message', '¡La clinica se ha desactivado correctamente!');
        // Alert::success('¡La clinica se ha desactivado correctamente!', '¡Hecho!!')->persistent('OK');
        return redirect()->route('clinics.index');
    }

    public function invoices(Clinic $clinic)
    {
        $invoices = $clinic->invoices();
        return view('app.clinics.invoices.index', compact('clinic', 'invoices'));
    }

    public function createInvoice(Clinic $clinic)
    {
        if(!auth()->user()->canCreateInvoices()):
            Session::flash('message', 'Para poder emitir facturas primero debes rellenar todos los campos obligatorios en tu perfil.');
            return redirect()->route('profile');
        endif;
        return view('app.clinics.invoices.create', compact('clinic'));
    }

    public function storeInvoice(Request $request, Clinic $clinic)
    {
        $invoice_lines = collect();
        $post_invoice_lines = $request->get('invoiceline');

        foreach($post_invoice_lines as $index => $invoice_line):
            $invoice_lines->push(new InvoiceLine([
                'description' => $invoice_line['description'],
                'quantity' => $invoice_line['quantity'],
                'unit_price' => $invoice_line['unit_price'],
                'total' => ($invoice_line['quantity'] * $invoice_line['unit_price']),
            ]));
        endforeach;

        $dentist_percentage = (int) $request->get('dentist_percentage');
        $sub_total = $invoice_lines->sum('total');
        $dentist_sub_total = $sub_total * $dentist_percentage / 100;
        $retention_percent = 15;
        $retention = $dentist_sub_total * $retention_percent / 100;
        $total = $dentist_sub_total  - $retention;

        $invoice = Invoice::create([
            'clinic_id' => $clinic->id,
            'invoice_no' => $request->get('invoice_no'),
            'invoice_date' => strtotime($request->get('invoice_date')),
            'payment_date' => null,
            'dentist_percentage' => $dentist_percentage,
            'sub_total' => $sub_total,
            'total' => $total
        ]);

        $invoice->invoiceLines()->saveMany($invoice_lines);

        Session::flash('message', '¡La factura se ha generado correctamente!');
        // Alert::success('¡La factura se ha generado correctamente!', '¡Hecho!')->persistent('OK');
        return redirect()->route('clinics.invoices', $clinic);

        if($request->ajax()):
            $invoice_lines = collect();
            $ajax_invoice_lines = $request->get('invoice_lines');

            foreach($ajax_invoice_lines as $index => $invoice_line):
                $invoice_lines->push(new InvoiceLine([
                    'description' => $invoice_line['description'],
                    'quantity' => $invoice_line['quantity'],
                    'unit_price' => $invoice_line['unit_price'],
                    'total' => ($invoice_line['quantity'] * $invoice_line['unit_price']),
                ]));
            endforeach;

            $sub_total = $invoice_lines->sum('total');
            $retention_percent = 15;
            $retention = $sub_total * $retention_percent / 100;
            $total = $sub_total - $retention;

            $invoice = Invoice::create([
                'clinic_id' => $clinic->id,
                'invoice_no' => $request->get('invoice_no'),
                'invoice_date' => strtotime($request->get('invoice_date')),
                'payment_date' => null,
                'sub_total' => $sub_total,
                'total' => $total
            ]);

            $invoice->invoiceLines()->saveMany($invoice_lines);

            return response()->json([
                'message' => 'Se ha creado la factura correctamente',
            ]);
        endif;
    }

    public function showInvoice(Clinic $clinic, $invoice_no)
    {
        $invoice = Invoice::where('invoice_no', $invoice_no)->first();
        return view('app.clinics.invoices.show', compact(['clinic','invoice']));
    }

    public function editInvoice(Clinic $clinic, $invoice_no)
    {
        $invoice = Invoice::where('invoice_no', $invoice_no)->first();
        return view('app.clinics.invoices.edit', compact(['clinic','invoice']));
    }

    public function updateInvoice(Request $request, Clinic $clinic, $invoice_no)
    {
        $invoice = Invoice::where('invoice_no', $invoice_no)->first();

        //Delete old invoice_lines and attach the new ones
        InvoiceLine::where('invoice_id', $invoice->id)->delete();

        $invoice_lines = collect();
        $post_invoice_lines = $request->get('invoiceline');

        foreach($post_invoice_lines as $index => $invoice_line):
            $invoice_lines->push(new InvoiceLine([
                'description' => $invoice_line['description'],
                'quantity' => $invoice_line['quantity'],
                'unit_price' => $invoice_line['unit_price'],
                'total' => ($invoice_line['quantity'] * $invoice_line['unit_price']),
            ]));
        endforeach;

        $sub_total = $invoice_lines->sum('total');
        $retention_percent = 15;
        $retention = $sub_total * $retention_percent / 100;
        $total = $sub_total - $retention;

        $invoice->update([
            'invoice_date' => strtotime($request->get('invoice_date')),
            // 'payment_date' => null,
            'sub_total' => $sub_total,
            'total' => $total
        ]);

        $invoice->invoiceLines()->saveMany($invoice_lines);

        Session::flash('message', '¡La factura se ha actualizado correctamente!');
        // Alert::success('¡La factura se ha actualizado correctamente!', '¡Hecho!')->persistent('OK');
        return redirect()->route('invoices.show', $invoice_no);

        if($request->ajax()):
            $invoice_lines = collect();
            $ajax_invoice_lines = $request->get('invoice_lines');

            foreach($ajax_invoice_lines as $index => $invoice_line):
                $invoice_lines->push(new InvoiceLine([
                    'description' => $invoice_line['description'],
                    'quantity' => $invoice_line['quantity'],
                    'unit_price' => $invoice_line['unit_price'],
                    'total' => ($invoice_line['quantity'] * $invoice_line['unit_price']),
                ]));
            endforeach;

            $sub_total = $invoice_lines->sum('total');
            $retention_percent = 15;
            $retention = $sub_total * $retention_percent / 100;
            $total = $sub_total - $retention;

            $invoice = Invoice::create([
                'clinic_id' => $clinic->id,
                'invoice_no' => $request->get('invoice_no'),
                'invoice_date' => strtotime($request->get('invoice_date')),
                'payment_date' => null,
                'sub_total' => $sub_total,
                'total' => $total
            ]);

            $invoice->invoiceLines()->saveMany($invoice_lines);

            return response()->json([
                'message' => 'Se ha creado la factura correctamente',
            ]);
        endif;
    }

    public function deleteInvoice(Clinic $clinic, $invoice_no)
    {
        Invoice::where('invoice_no', $invoice_no)->delete();
        Session::flash('message', '¡La factura se ha eliminado correctamente!');
        // Alert::success('¡La factura se ha eliminado correctamente!', '¡Hecho!')->persistent('OK');
        return redirect()->route('clinics.invoices', $clinic);
    }
}
