<?php
require('fpdf/fpdf.php');
include("connexion1.php");

if(isset($_GET['code'])) {

    $code = $_GET['code'];

    $query = "SELECT u.nom, u.prenom, f.nomformation, a.idformation
              FROM attestation a
              JOIN participant p ON a.idparticipant = p.idparticipant
              JOIN utilisateur u ON p.idutilisateur = u.idutilisateur
              JOIN formation f ON a.idformation = f.idformation
              WHERE a.code_unique = $1";

    $result = pg_query_params($conn, $query, array($code));
    $data = pg_fetch_assoc($result);

    if(!$data) {
        die("Attestation introuvable");
    }

    $nom = $data['nom'] . " " . $data['prenom'];
    $formation = $data['nomformation'];

    // QR
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://172.20.10.14/xampp/detail.php?idformation=".$data['idformation'];
    $qr_file = "qr.png";
    file_put_contents($qr_file, file_get_contents($qr_url));

    // PDF preview
    $pdf = new FPDF('L');
    $pdf->AddPage();

    $pdf->SetFillColor(245, 250, 255);
    $pdf->Rect(0, 0, 297, 210, 'F');

    $pdf->SetDrawColor(0, 102, 204);
    $pdf->SetLineWidth(2);
    $pdf->Rect(10, 10, 277, 190);

    $pdf->SetXY(15, 15);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,5,'Tech Academy',0,1,'L');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',28);
    $pdf->Cell(0,10,'ATTESTATION',0,1,'C');

    $pdf->SetFont('Arial','',16);
    $pdf->Cell(0,10,'de participation',0,1,'C');

    $pdf->Ln(10);
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(0,10,'Ce certificat est attribue a :',0,1,'C');

    $pdf->SetFont('Arial','B',24);
    $pdf->SetTextColor(0,153,76);
    $pdf->Cell(0,15,$nom,0,1,'C');

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(0,10,'pour sa participation a la formation :',0,1,'C');

    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(0,12,$formation,0,1,'C');

    $pdf->SetXY(200, 150);
    $pdf->Cell(80,10,'______________________',0,1,'C');

    $pdf->SetXY(200, 160);
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(80,10,'Signature du formateur',0,1,'C');

    $pdf->Output('I', 'preview.pdf');

} else {
    echo "Aucun code";
}
?>