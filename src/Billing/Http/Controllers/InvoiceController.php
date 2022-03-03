<?php

namespace Octo\Billing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Octo\Billing\Billing;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoices = Billing::getBillable($request)->invoicesIncludingPending()->map(function ($invoice) {
            return (object) [
                'description' => $invoice->lines->data[0]->description,
                'created' => $invoice->created,
                'paid' => $invoice->paid,
                'status' => $invoice->status,
                'url' => $invoice->hosted_invoice_url ?: null,
            ];
        });

        return view('octo::billing.invoice.index', [
            'invoices' => $invoices,
        ]);
    }
}
