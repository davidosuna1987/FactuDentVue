<?php

namespace App\Http\Controllers;

use PDF;
use Alert;
use Session;
use App\Invoice;
use App\InvoiceLine;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(!auth()->user()->canCreateInvoices()):
                Session::flash('message', 'Para poder emitir facturas primero debes rellenar todos los campos obligatorios en tu perfil.');
                return redirect()->route('profile');
            endif;

            return $next($request);
        });
    }

    public function index()
    {
        $invoices = auth()->user()->invoices()->orderBy('invoice_no', 'desc')->paginate(20);
        return view('app.invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('app.invoices.create');
    }

    public function store(Request $request)
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
        $retention_percent = $request->get('invoice_retention');
        $retention = $dentist_sub_total * $retention_percent / 100;
        $total = $dentist_sub_total  - $retention;

        $invoice = Invoice::create([
            'clinic_id' => $request->get('clinic_id'),
            'invoice_no' => $request->get('invoice_no'),
            'invoice_date' => strtotime($request->get('invoice_date')),
            'payment_date' => null,
            'ovserbations' => $request->get('ovserbations'),
            'retention' => $retention_percent,
            'dentist_percentage' => $dentist_percentage,
            'sub_total' => $sub_total,
            'total' => $total
        ]);

        $invoice->invoiceLines()->saveMany($invoice_lines);
        Session::flash('message', '¡La factura se ha generado correctamente!');
        // Alert::success('¡La factura se ha generado correctamente!', '¡Hecho!')->persistent('OK');
        return redirect()->route('invoices.index');

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

    public function show($invoice_no)
    {
        $invoice = auth()->user()->invoices()->where('invoice_no', $invoice_no)->first();
        return view('app.invoices.show', compact('invoice'));
    }

    public function edit($invoice_no)
    {
        $invoice = auth()->user()->invoices()->where('invoice_no', $invoice_no)->first();
        return view('app.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, $invoice_no)
    {
        $invoice = auth()->user()->invoices()->where('invoice_no', $invoice_no)->first();
        $payment_date = $request->get('invoice_paid') ? strtotime(\Carbon::now()) : null;

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

        $dentist_percentage = (int) $request->get('dentist_percentage');
        $sub_total = $invoice_lines->sum('total');
        $dentist_sub_total = $sub_total * $dentist_percentage / 100;
        $retention_percent = $request->get('invoice_retention');
        $retention = $dentist_sub_total * $retention_percent / 100;
        $total = $dentist_sub_total  - $retention;

        $invoice->update([
            'clinic_id' => $request->get('clinic_id'),
            'invoice_no' => $request->get('invoice_no'),
            'invoice_date' => strtotime($request->get('invoice_date')),
            'payment_date' => $payment_date,
            'ovserbations' => $request->get('ovserbations'),
            'dentist_percentage' => $dentist_percentage,
            'retention' => $retention_percent,
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

    // public function pay($invoice_id, Request $request)
    // {
    //     $invoice = auth()->user()->invoices()->where('id', (int) $invoice_id)->first();
    //     if($request->ajax()):
    //         $invoice->update([
    //             'payment_date' => \Carbon::now()
    //         ]);

    //         return response()->json([
    //             'message' => '¡La factura se '.$invoice->invoice_no.' ha marcado como pagada!',
    //             'payment_date' => \Carbon::now()->diffForHumans(),
    //         ]);
    //     endif;

    //     $invoice->update([
    //         'payment_date' => \Carbon::now()
    //     ]);
    //     Session::flash('message', '¡La factura se '.$invoice->invoice_no.' ha marcado como pagada!');
    //     return redirect()->route('invoices.show', $invoice->invoice_no);
    // }

    // public function unpay($invoice_id, Request $request)
    // {
    //     $invoice = auth()->user()->invoices()->where('id', (int) $invoice_id)->first();
    //     if($request->ajax()):
    //         $invoice->update([
    //             'payment_date' => null
    //         ]);

    //         return response()->json([
    //             'message' => '¡La factura se '.$invoice->invoice_no.' ha marcado como pendiente!',
    //             'payment_date' => null,
    //         ]);
    //     endif;

    //     $invoice->update([
    //         'payment_date' => null
    //     ]);
    //     Session::flash('message', '¡La factura se '.$invoice->invoice_no.' ha marcado como pendiente!');
    //     return redirect()->route('invoices.show', $invoice->invoice_no);
    // }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('message', '¡La factura se ha eliminado correctamente!');
        // Alert::success('¡La factura se ha eliminado correctamente!', '¡Hecho!')->persistent('OK');
        return redirect()->route('invoices.index');
    }

    public function showPDF($invoice_no){
        $invoice = auth()->user()->invoices()->where('invoice_no', $invoice_no)->first();
        $pdf = PDF::loadView('app.invoices.pdf.show', ['invoice' => $invoice]);
        return $pdf->stream('factudent_factura_'.$invoice_no.'.pdf');
    }

    public function pending()
    {
        $invoices = auth()->user()->pendingInvoices()->orderBy('invoice_no', 'desc')->paginate(20);
        return view('app.invoices.pending', compact('invoices'));
    }
}
