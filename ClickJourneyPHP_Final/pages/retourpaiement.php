require_once('getapikey.php'); 

$transaction = uniqid();
$montant = number_format(180.99, 2, '.', ''); // exemple de montant
$vendeur = 'MIM-1_F'; 
$retour = 'http://localhost/ClickJourneyPHP/pages/retourpaiement.php?session=s123';

$api_key = getAPIKey($vendeur);
$control = md5($api_key . "#" . $transaction . "#" . $montant . "#" . $vendeur . "#" . $retour . "#");
?>

<form action="https://www.plateforme-smc.fr/cybank/index.php" method="POST">
  <input type="hidden" name="transaction" value="<?php echo $transaction; ?>">
  <input type="hidden" name="montant" value="<?php echo $montant; ?>">
  <input type="hidden" name="vendeur" value="<?php echo $vendeur; ?>">
  <input type="hidden" name="retour" value="<?php echo $retour; ?>">
  <input type="hidden" name="control" value="<?php echo $control; ?>">
  <input type="submit" value="Valider et payer">
</form>
