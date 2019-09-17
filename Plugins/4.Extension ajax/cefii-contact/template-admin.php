<?php
    $listeRappel = $this->selectData();
?>

    <h2>CEFii Contact</h2>
    <p>Liste des personnes à rappeler :</p>
    <table>
        <tr>
            <th>Nom</th>
            <th>Téléphone</th>
            <th>Supprimer</th>
        </tr>
        
        <?php
    if($listeRappel){
    foreach($listeRappel as $contact){ ?>
        <tr id="<?php echo $contact->id; ?>">
            <td><?php echo $contact->nom; ?></td>
            <td><?php echo $contact->tel; ?></td>
            <td><span class="supprimer dashicons dashicons-trash"></span></td>
        </tr>
        <?php }
    echo '</table>';
    } else {
    echo '</table><p>Aucun contact</p>'; }?>
        <div id="message"></div>