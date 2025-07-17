<?php
namespace App\Services;

use PDF;
use App\Mail\CertificateMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CertificateService
{
    public function generateAndSendCertificate(array $data, string $email)
    {
        // Generate PDF
        $pdf = PDF::loadView('pdf.certificate', $data);
        $pdfPath = storage_path('app/certificates/') . 'certificate_' . $data['id'] . '.pdf';
        $pdf->save($pdfPath);
        Storage::put('certificates/certificate_' . $data['id'] . '.pdf', $pdf->output());

        // Send Email with PDF Attachment
        Mail::to($email)->send(new CertificateMail($pdfPath));

        // Optionally: Clean up the stored PDF file after sending the email
        // Storage::delete('certificates/certificate_' . $data['id'] . '.pdf');
    }
}
