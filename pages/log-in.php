<?php
session_start();
require_once '../headerInclude.php';

// SE l'utente è loggato ALLORA viene reindirizzato alla 'pagina-personale.php'
if (isUserLoggedin()) {
    header('Location: pagina-personale.php');
    exit;
}

// Creazione del CSRF ('$token') da inviare a 'verify-login.php' tramite form
// e da inserire nella sessione
$randomBytes = random_bytes(32); 
$token = bin2hex($randomBytes);
$_SESSION['csrf'] = $token;

$email = getParam('email', '');
?>

    <!-- MAIN - Log-In.php -->
    <main>
        <div class="container">
            <h1>Hai già un account?</h1>
            <?php
                // Messaggio esito operazione su db SE è presente 'message' in $_SESSION
                if (!empty($_SESSION['message'])) { 
                    $message = $_SESSION['message'];

                    // Include la view 'message.php'
                    require_once '../view/message.php';

                    // Smonta la variabile di sessione dopo averla utilizzata nella view 'message.php'
                    // Questo per avere il suo contenuto sempre aggiornato ad ogni caricamento della pagina
                    unset($_SESSION['message']);
                } 
            ?>
            <!-- FORM -->
            <form action="../verify-login.php" method="post">
                <!-- CSRF - Input Hidden -->
                <input type="hidden" name="_csrf" value="<?=$token?>">

                <!-- Email -->
                <div class="form-item">
                    <label for="email">Inserisci l'email</label>
                    <input type="email" name="email" id="email" placeholder="name@example.com" value="<?=$email?>" required>
                </div>
                <!-- Error -->
                <?php if (isset($_SESSION['validationError']['email'])) { ?>
                    <div class="alert alert-danger" role="alert"><?=$_SESSION['validationError']["message"]?></div>
                <?php } ?>

                <!-- Password -->
                <div class="form-item">
                    <label for="id_password">Inserisci la password</label>
                    <input type="password" name="password" id="id_password" placeholder="Scrivila qui" required>
                    <i class="far fa-eye-slash" id="togglePassword"></i>
                </div>
                <!-- Error -->
                <?php if (isset($_SESSION['validationError']['password'])) { ?>
                    <div class="alert alert-danger" role="alert"><?=$_SESSION['validationError']["message"]?></div>
                <?php } ?>

                <!-- Bottone Registrati -->
                <button type="submit">ACCEDI</button>

                <!-- Link a Registrati -->
                <a href="registrazione.php">Non hai ancora un profilo? <strong>Registrati</strong></a>

            </form>
        </div>
    </main>
    
<?php
// Smonta le variabili di sessione dopo averle utilizzate in modo
// da avere $_SESSION sempre aggiornata al caricamento della pagina
$requiredColumn = getConfig('requiredColumns');
foreach ($requiredColumn as $column) {
  unset($_SESSION['validationError'][$column]);
}
unset($_SESSION['alertType']);

// Include il Footer
require_once '../view/footer.php';
?>