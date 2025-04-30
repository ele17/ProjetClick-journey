<?php
function getAPIKey($code_vendeur) {
    $clefs_valides = [
        'MIM-1_F' => 'f5be97e64ef5aea', // clé API 
    ];
    
    if (array_key_exists($code_vendeur, $clefs_valides)) {
        return $clefs_valides[$code_vendeur];
    } else {
        return 'vendeur non reconnu';
    }
}
?>
