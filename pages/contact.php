<?php
$metaTitle = 'Contact';
$metaDescription = 'Page de contact';
include('header.php');
?>

<main>
    <h1>Contact</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Initialisez un tableau pour stocker les erreurs
        $errors = [];

        // Récupérez les valeurs de vos champs avec filter_input sans filtre
        $civility = filter_input(INPUT_POST, 'civility', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        // Vérifiez si les champs existent et s'ils ne sont pas vides
        if (!$civility || $civility === '') $errors['civility'] = 'Le champ civilité est requis.';
        if (!$name || $name === '') $errors['name'] = 'Le champ nom est requis.';
        if (!$firstName || $firstName === '') $errors['firstName'] = 'Le champ prénom est requis.';
        if (!$email || $email === '') $errors['email'] = 'Le champ email est requis.';
        if (!$reason || $reason === '') $errors['reason'] = 'Le champ raison est requis.';
        if (!$message || $message === '') $errors['message'] = 'Le champ message est requis.';

        // Validez les données
        if ($civility !== 'M.' && $civility !== 'Mme') $errors['civility'] = 'Le choix de la civilité est invalide.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = 'L\'email saisi n\'est pas valide.';
        if (strlen($message) < 5) $errors['message'] = 'Le champ message doit contenir au moins 5 caractères.';

        // S'il n'y a pas d'erreurs, enregistrez les données dans un fichier
        if (empty($errors)) {
            $contactInfo = [
                'civility' => $civility,
                'name' => $name,
                'firstName' => $firstName,
                'email' => $email,
                'reason' => $reason,
                'message' => $message,
            ];
            file_put_contents('contact/' . date('Y-m-d-H-i-s') . '.txt', print_r($contactInfo, true));
            echo '<p>Votre message a été envoyé avec succès.</p>';
        } else {
            foreach ($errors as $error) {
                echo '<p class="error">' . $error . '</p>';
            }
        }
    }
    ?>

    <form action="index.php?page=contact" method="post">
        <select name="civility">
            <option>M.</option>
            <option>Mme</option>
        </select>
        <input type="text" name="name" placeholder="Nom">
        <input type="text" name="firstName" placeholder="Prénom">
        <input type="email" name="email" placeholder="Email">
        <div>
            <label><input type="radio" name="reason" value="proposition"> Proposition d'emploi</label>
            <label><input type="radio" name="reason" value="information"> Demande d'information</label>
            <label><input type="radio" name="reason" value="prestations"> Prestations</label>
        </div>
        <textarea name="message"></textarea>
        <button type="submit">Envoyer</button>
    </form>
</main>

<?php include('footer.php'); ?>
