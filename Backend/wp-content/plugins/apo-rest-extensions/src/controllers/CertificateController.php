<?php

namespace apo\rxts\controllers;

use \WP_REST_Request as Request;
use awsm\wp\libraries\Controller;
use awsm\wp\libraries\utilities\Auth;

use Fpdf\Fpdf;

class CertificateController extends Controller
{
    use Auth;

    private $allowedOrigins = [
        '*'
    ];

	public function __construct()
	{
        parent::__construct();
	}

    public function index( Request $request )
    {
        switch(get_locale()) {
            case 'es_ES':
                // Handle espanol PDF
                return $this->generateEspanolPdf($request);
            case 'de_DE':
                // Handle german PDF
                return $this->generateGermanPdf($request);
            default:
                // ERROR
                return 'Unsupported language: ' . get_locale();
            }
    }

    private function generateGermanPdf(Request $request) {
        global $wpdb;

        $user = wp_get_current_user();

        $date_query = $wpdb->get_row("SELECT created_at
        FROM
          {$wpdb->prefix}training_user_results
        WHERE
          training_id IN 
            (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = {$request['training']} AND meta_key LIKE 'trainings_%_training_id') 
            AND user_id = {$user->ID}
            ORDER BY created_at DESC
            LIMIT 1");
        $date = date_format(date_create($date_query->created_at),"d.m.Y");

        $userName = utf8_decode($user->user_firstname.' '.$user->user_lastname);
        $training = utf8_decode(get_the_title($request['training']));

        $pdf = new Fpdf();

        $pdf->AddPage();

        $pdf->SetFillColor(0, 175, 255);
        $pdf->Rect(0, 0, 210, 297, 'F');

        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(10, 10, 190, 20, 'F');

        $pdf->SetY(45);
        $pdf->Image('certificate-logo.png', 86, null, 0, 10, 'PNG');

        $pdf->SetY(60);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 48);
        $pdf->Cell(0, 20, 'Teilnahmezertifikat', 0, 2, 'C', false);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(10, 100, 190, 188, 'F');

        $pdf->SetY(120);
        $pdf->SetTextColor(65, 65, 65);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 15, $userName, 0, 2, 'C', false);

        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 6, 'hat am', 0, 2, 'C', false);
        $pdf->Cell(0, 6, $date, 0, 2, 'C', false);
        $pdf->Cell(0, 6, 'an folgender Schulung', 0, 2, 'C', false);

        $pdf->SetY(160);
        $pdf->SetTextColor(65, 65, 65);
        $pdf->SetFont('Arial', 'B', 28);
        $pdf->MultiCell(0, 12, $training, 0, 'C', false);
        $pdf->Cell(0, 12, 'eTraining '.$request['year'], 0, 2, 'C', false);

        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 15, 'erfolgreich teilgenommen.', 0, 2, 'C', false);

        return $pdf->Output('I', 'Zertifikat_' .$request['training']. '.pdf', true);
    }

    private function generateEspanolPdf(Request $request) {
        global $wpdb;

        $user = wp_get_current_user();

        $date_query = $wpdb->get_row("SELECT created_at
        FROM
          {$wpdb->prefix}training_user_results
        WHERE
          training_id IN 
            (SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = {$request['training']} AND meta_key LIKE 'trainings_%_training_id') 
            AND user_id = {$user->ID}
            ORDER BY created_at DESC
            LIMIT 1");
        $date = date_format(date_create($date_query->created_at),"d.m.Y");

        $userName = utf8_decode($user->user_firstname.' '.$user->user_lastname);
        $training = utf8_decode(get_the_title($request['training']));

        $pdf = new Fpdf();

        $pdf->AddPage();

        $pdf->SetFillColor(0, 175, 255);
        $pdf->Rect(0, 0, 210, 297, 'F');

        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(10, 10, 190, 20, 'F');

        $pdf->SetY(45);
        $pdf->Image('certificate-logo.png', 86, null, 0, 10, 'PNG');

        $pdf->SetY(60);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', '', 48);
        $pdf->Cell(0, 20, 'Certificado', 0, 2, 'C', false);

        $pdf->SetFillColor(255, 255, 255);
        $pdf->Rect(10, 100, 190, 188, 'F');

        $pdf->SetY(120);
        $pdf->SetTextColor(65, 65, 65);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 15, $userName, 0, 2, 'C', false);

        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 6, utf8_decode('participó con éxito en el'), 0, 2, 'C', false);
        $pdf->Cell(0, 6, 'siguiente entrenamiento', 0, 2, 'C', false);

        $pdf->SetY(155);
        $pdf->SetTextColor(65, 65, 65);
        $pdf->SetFont('Arial', 'B', 28);
        $pdf->MultiCell(0, 12, $training, 0, 'C', false);
        $pdf->Cell(0, 12, 'eTraining '.$request['year'], 0, 2, 'C', false);

        $pdf->SetTextColor(100, 100, 100);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 18, 'el '. $date . '.', 0, 2, 'C', false);

        return $pdf->Output('I', 'Certificado_' .$request['training']. '.pdf', true);
    }

    protected function getOrigins()
    {
        return implode(' ', $this->allowedOrigins);
    }
}
