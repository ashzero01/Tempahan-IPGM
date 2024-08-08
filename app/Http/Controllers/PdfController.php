<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PdfController extends Controller
{
    public function fillForm(Request $request)
    {
        // Example ticket data; replace with actual data from your request
        $ticket = (object) [
            'transaction_date' => now(),
            'vehicle_id' => 'ABC123',
            'number' => 'TICKET456',
        ];

        // Path to the PDF template
        $template = 'Scan.pdf';

        // Coordinates for text fields
        $coordinates = [
            'ticket_transaction_date' => [20, 50],
            'ticket_vehicle_id' => [70, 60],
            'ticket_number' => [125, 60],
        ];

        // Create a new FPDI object
        $pdf = new Fpdi();
        $pdf->AddPage();
        $pdf->setSourceFile(public_path("/pdf/{$template}"));
        $templateId = $pdf->importPage(1);
        $pdf->useTemplate($templateId);

        // Set font and color
        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(0, 0, 0);

        // Add text to the PDF at specified coordinates
        $pdf->SetXY($coordinates['ticket_transaction_date'][0], $coordinates['ticket_transaction_date'][1]);
        $pdf->Write(0, $ticket->transaction_date->format('Y-m-d'));

        $pdf->SetXY($coordinates['ticket_vehicle_id'][0], $coordinates['ticket_vehicle_id'][1]);
        $pdf->Write(0, $ticket->vehicle_id);

        $pdf->SetXY($coordinates['ticket_number'][0], $coordinates['ticket_number'][1]);
        $pdf->Write(0, $ticket->number);

        // Output PDF and return it
        $pdfOutput = $pdf->Output('S'); // Save output to string

        return response($pdfOutput, 200)
                  ->header('Content-Type', 'application/pdf')
                  ->header('Content-Disposition', 'inline; filename="filled_form.pdf"');
    }
}
