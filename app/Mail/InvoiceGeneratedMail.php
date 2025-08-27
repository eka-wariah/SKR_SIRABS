<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;

class InvoiceGeneratedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        $pdf = PDF::loadView('citizen.invoice.pdf', [
            'invoice' => $this->invoice,
            'user' => $this->invoice->household->users->first(),
            'household' => $this->invoice->household,
        ])->setPaper('a4', 'portrait');

        return $this->subject('Invoice Retribusi ' . $this->invoice->periode)
            ->markdown('emails.invoice.generated')
            ->attachData($pdf->output(), "invoice_{$this->invoice->invoice_number}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
