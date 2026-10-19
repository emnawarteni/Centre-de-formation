<?php
include("connexion.php"); 
$message = "";

// --- SUPPRESSION ---
if (isset($_GET['supprimer'])) {
    $id = intval($_GET['supprimer']);
    $query_del = "DELETE FROM formateur WHERE idformateur = $1";
    pg_prepare($dbconn, "del_f", $query_del);
    $res_del = pg_execute($dbconn, "del_f", array($id));
    if ($res_del) $message = " Formateur supprimé avec succès.";
}

// --- MODIFICATION ---
if (isset($_POST['modifier_confirm'])) {
    $id = intval($_POST['idformateur']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $spec = htmlspecialchars($_POST['Specialite']);
    $email = $_POST['email'];
    $dispo = ($_POST['disponibilite'] == "1") ? 'true' : 'false';

    $date_debut = !empty($_POST['date_debut']) ? $_POST['date_debut'] : null;
    $date_fin = !empty($_POST['date_fin']) ? $_POST['date_fin'] : null;

    $query_upd = "UPDATE formateur 
        SET nom=$1, prenom=$2, specialite=$3, email=$4, disponibilite=$5, date_debut=$6, date_fin=$7 
        WHERE idformateur=$8";

    pg_prepare($dbconn, "upd_f", $query_upd);
    pg_execute($dbconn, "upd_f", array(
        $nom, $prenom, $spec, $email, $dispo, $date_debut, $date_fin, $id
    ));

    $message = " Modification enregistrée.";
}

// --- AFFICHAGE ---
$resultat = pg_query($dbconn, "SELECT * FROM formateur ORDER BY idformateur DESC");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Formateurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Gestion des Formateurs</h1>

<?php if ($message != "") echo "<div class='message success'>$message</div>"; ?>

<a href="add_formateur.php" class="btn btn-ajouter">+ Ajouter un formateur</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Spécialité</th>
            <th>Email</th>
            <th>Formation associée</th>
            <th>Dispo</th>
            <th>Période dispo</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    <?php while ($f = pg_fetch_assoc($resultat)): ?>
        <tr>
            <td><?= $f['idformateur']; ?></td>
            <td><?= htmlspecialchars($f['nom']); ?></td>
            <td><?= htmlspecialchars($f['prenom']); ?></td>
            <td><?= htmlspecialchars($f['specialite']); ?></td>
            <td><?= htmlspecialchars($f['email']); ?></td>

            <!--  formations -->
            <td>
            <?php
            $resF = pg_query_params($dbconn, 
                "SELECT nomformation FROM formation WHERE idformateur = $1", 
                array($f['idformateur'])
            );

            if(pg_num_rows($resF) > 0){
                $formations = [];
                while($fo = pg_fetch_assoc($resF)){
                    $formations[] = $fo['nomformation'];
                }
                echo implode(", ", $formations);
            } else {
                echo "<span style='color:#7f8c8d;'>aucune</span>";
            }
            ?>
            </td>

            <!-- disponibilité -->
            <td><?= ($f['disponibilite'] == 't') ? "OUI" : "NON"; ?></td>

            <!--  période -->
            <td>
            <?php
            if($f['disponibilite'] == 't' && $f['date_debut'] && $f['date_fin']){
                echo $f['date_debut']." → ".$f['date_fin'];
            } else {
                echo "<span style='color:#aaa;'>-</span>";
            }
            ?>
            </td>

            <td>
                <a href="?edit=<?= $f['idformateur']; ?>" class="btn btn-modifier">Modifier</a>
                <a href="?supprimer=<?= $f['idformateur']; ?>" class="btn btn-supprimer" onclick="return confirm('Supprimer ?')">Supprimer</a>
                <a href="associer_formation_formateur.php?idformateur=<?= $f['idformateur']; ?>" class="btn btn-associer">Associer</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<!--  MODAL MODIFIER -->
<?php if (isset($_GET['edit'])): 
    $id_edit = intval($_GET['edit']);
    $res_edit = pg_query($dbconn, "SELECT * FROM formateur WHERE idformateur = $id_edit");
    $data = pg_fetch_assoc($res_edit);
    if ($data):
?>
<div class="modal-overlay">
    <div class="modal-content">
        <h3> Modifier Formateur</h3>

        <form method="POST">

            <input type="hidden" name="idformateur" value="<?= $data['idformateur']; ?>">

            <label>Nom :</label>
            <input type="text" name="nom" value="<?= $data['nom']; ?>" required>

            <label>Prénom :</label>
            <input type="text" name="prenom" value="<?= $data['prenom']; ?>" required>

            <label>Spécialité :</label>
            <input type="text" name="Specialite" value="<?= $data['specialite']; ?>">

            <label>Email :</label>
            <input type="email" name="email" value="<?= $data['email']; ?>">

            <label>Disponibilité :</label>
            <select name="disponibilite" id="dispo_edit" onchange="toggleCalendarEdit()">
                <option value="1" <?= ($data['disponibilite']=='t')?'selected':''; ?>>Disponible</option>
                <option value="0" <?= ($data['disponibilite']=='f')?'selected':''; ?>>Indisponible</option>
            </select>

            <!--  calendrier -->
            <div id="calendar_edit" style="margin-top:10px;">
                <input type="date" name="date_debut" value="<?= $data['date_debut']; ?>">
                <input type="date" name="date_fin" value="<?= $data['date_fin']; ?>">
            </div>

            <button type="submit" name="modifier_confirm" class="btn btn-save">Enregistrer</button>
            <a href="listeFormateurs.php" class="btn btn-annuler">Annuler</a>
        </form>
    </div>
</div>
<?php endif; endif; ?>

<script>
function toggleCalendarEdit(){
    var dispo = document.getElementById("dispo_edit").value;
    var cal = document.getElementById("calendar_edit");

    if(dispo == "1"){
        cal.style.display = "block";
    } else {
        cal.style.display = "none";
    }
}
</script>

</body>
</html>