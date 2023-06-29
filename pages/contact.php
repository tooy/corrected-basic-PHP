<?php
include('header.php');

$formErrors = []; // Stocke les erreurs du formulaire
$formData = []; // Stocke les données du formulaire

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $filters = [
        'civility' => FILTER_SANITIZE_STRING,
        'firstName' => FILTER_SANITIZE_STRING,
        'lastName' => FILTER_SANITIZE_STRING,
        'email' => FILTER_SANITIZE_EMAIL,
        'reason' => FILTER_SANITIZE_STRING,
        'message' => FILTER_SANITIZE_STRING,
    ];

    $formData = filter_input_array(INPUT_POST, $filters);

    if (!in_array($formData['civility'], ['M.', 'Mme'])) {
        $formErrors['civility'] = 'Merci de choisir une civilité valide.';
    }
    if (empty($formData['firstname'])) {
        $formErrors['firstname'] = 'Le champ prénom ne peut pas être vide.';
    }
    if (empty($formData['lastname'])) {
        $formErrors['lastname'] = 'Le champ nom ne peut pas être vide.';
    }
    if (!filter_var($formData['email'], FILTER_VALIDATE_EMAIL)) {
        $formErrors['email'] = 'Merci de saisir un email valide.';
    }
    if (!in_array($formData['reason'], ['emploi', 'info', 'prestation'])) {
        $formErrors['reason'] = 'Merci de choisir une raison de contact valide.';
    }
    if (!$formData['message'] || strlen($formData['message']) < 5) {
        $formErrors['message'] = "Message invalide. Il doit contenir au moins 5 lettres.";
    }

    if (empty($formErrors)) {
        $filename = sprintf('contact/%s.txt', date('Y-m-d-H-i-s'));
        $content = json_encode($formData);
        file_put_contents($filename, $content);
    }
}

?>

<main>
    <form method="POST" action="index.php?page=contact">
        <select name="civility">
            <option value="M">M.</option>
            <option value="Mme">Mme</option>
        </select>
<!--a répéter pour chaque champs        -->
        <div class="form-error">
            <?= $formErrors['civility'] ?? ''; ?>
        </div>
<!--a répéter pour chaque champs        -->
        <input type="text" name="firstName" placeholder="Prénom">
        <input type="text" name="lastName" placeholder="Nom">
        <input type="email" name="email" placeholder="Email">
        <div>
            <label><input type="radio" name="reason" value="proposition"> Proposition d'emploi</label>
            <label><input type="radio" name="reason" value="information"> Demande d'information</label>
            <label><input type="radio" name="reason" value="prestations"> Prestations</label>
        </div>
        <textarea name="message"></textarea>
        <button type="submit">Envoyer</button>
    </form>
<!--    Noté la syntaxe alternative de php utilisé dans les tempaltes cf @https://www.php.net/manual/fr/control-structures.alternative-syntax.php-->
    <?php if (!empty($formErrors)): ?>
        <ul>
            <?php foreach ($formErrors as $field => $error): ?>
                <li><strong><?= ucfirst($field) ?>:</strong> <?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</main>

<?php include('footer.php'); ?>
