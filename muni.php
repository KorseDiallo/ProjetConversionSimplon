<?php 
    function conversion($montantEnCfa) {
        
        if ($montantEnCfa <= 0) {
            return "Le montant doit être supérieur à zéro.";
        }
    
        $tauxDeChange = 0.00152;
        $montantEnEuro = $montantEnCfa * $tauxDeChange;
        return $montantEnEuro;
    }

    $montantEnCfa = ''; 
    $montantEnEuro = '';

    $historiqueMontants = array();
    if (isset($_COOKIE['historiqueMontants'])) {
        $historiqueMontants = json_decode($_COOKIE['historiqueMontants'], true);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["montant"])) {
            $montantEnCfa = $_POST["montant"];
            
            $validationResult = conversion($montantEnCfa);
            if (is_numeric($validationResult)) {
                $montantEnEuro = $validationResult;
                $historiqueMontants[] = $montantEnCfa;
                setcookie('historiqueMontants', json_encode($historiqueMontants), time() + 3600);
            } else {
                echo $validationResult;
            }
        }
    }

    


    

?>



<!DOCTYPE html>
<html>
<head>
    <title>Convertisseur de francs CFA en euros</title>
    <style>
        input{
            display: block;
        }
    </style>
</head>
<body>
    <h1>Convertisseur de francs CFA en euros</h1>
    <form method="POST" action="">
        <input type="number" name="montant" placeholder="FRANC CFA" value="<?php echo $montantEnCfa; ?>"><br/>
        <input type="submit" value="Convertir"><br/>
        <input type="text" name="resultat" placeholder="Euro" value="<?php echo $montantEnEuro; ?>" readonly><br/>
    </form>

    <h2>Historique des montants saisis :</h2>
<ul>
    <?php foreach ($historiqueMontants as $montant) { ?>
        <li><?php echo $montant; ?> FRANC CFA</li>
    <?php } ?>
</ul>

</body>
</html>
