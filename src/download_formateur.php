<?php
require('fpdf/fpdf.php');
include("connexion1.php");

if(isset($_GET['idformation'])) {

    $idformation = $_GET['idformation'];

    $query = "
    SELECT u.nom, u.prenom, f.nomformation
    FROM formation f
    JOIN formateur fo ON f.idformateur = fo.idformateur
    JOIN utilisateur u ON fo.idutilisateur = u.idutilisateur
    WHERE f.idformation = $1
    ";

    $result = pg_query_params($conn, $query, array($idformation));
    $data = pg_fetch_assoc($result);

    if(!$data) {
        die("Attestation introuvable");
    }

    $nom = $data['nom']." ".$data['prenom'];
    $formation = $data['nomformation'];

    //  PDF
    $pdf = new FPDF('L');
    $pdf->AddPage();

    //  Background
    $pdf->SetFillColor(240, 248, 255);
    $pdf->Rect(0, 0, 297, 210, 'F');

    //  cadre
    $pdf->SetDrawColor(0, 102, 204);
    $pdf->SetLineWidth(2);
    $pdf->Rect(10, 10, 277, 190);

    //  centre
    $pdf->SetXY(20, 18);
    $pdf->SetFont('Arial','I',10);
    $pdf->SetTextColor(120,120,120);
    $pdf->Cell(0,5,'Tech Academy',0,1,'L');

    //  titre
    $pdf->Ln(15);
    $pdf->SetFont('Arial','B',30);
    $pdf->SetTextColor(0, 102, 204);
    $pdf->Cell(0,10,'ATTESTATION',0,1,'C');

    $pdf->SetFont('Arial','',16);
    $pdf->SetTextColor(80,80,80);
    $pdf->Cell(0,10,'de formation (Formateur)',0,1,'C');

    //  ligne
    $pdf->SetDrawColor(0,102,204);
    $pdf->Line(100, 60, 200, 60);

    //  texte
    $pdf->Ln(10);
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(0,10,'Ce certificat est attribue a :',0,1,'C');

    //  nom
    $pdf->SetFont('Arial','B',24);
    $pdf->SetTextColor(0,153,76);
    $pdf->Cell(0,15,$nom,0,1,'C');

    //  formation
    $pdf->SetFont('Arial','',14);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(0,10,'pour avoir assure la formation :',0,1,'C');

    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(0,10,$formation,0,1,'C');

    //  date
    $pdf->Ln(5);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(0,10,'Date : '.date('Y-m-d'),0,1,'C');

    //  signature
    $pdf->SetXY(210, 150);
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(60,10,'____________________',0,1,'C');

    $pdf->SetXY(210, 160);
    $pdf->SetFont('Arial','I',12);
    $pdf->Cell(60,10,'Signature du centre',0,1,'C');

    //  footer
    $pdf->SetY(-20);
    $pdf->SetFont('Arial','I',9);
    $pdf->SetTextColor(120,120,120);
    $pdf->Cell(0,10,'Document genere automatiquement',0,0,'C');

    // download
    $pdf->Output('D', 'attestation_formateur.pdf');

} else {
    echo "Aucune formation";
}
?>