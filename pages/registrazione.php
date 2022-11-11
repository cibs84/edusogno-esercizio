<?php
session_start();
require_once '../headerInclude.php';

// SE l'utente è loggato ALLORA viene reindirizzato alla 'pagina-personale.php'
if (isUserLoggedin()) {
    header('Location: pagina-personale.php');
    exit;
}

// Variabili da stampare negli input. 
// Prendono i valori passati dalla querystring dello 'UserController.php'
// in modo che in caso di errori di validazione, i campi del form non si resettano
$nome = getParam('nome', '');
$cognome = getParam('cognome', '');
$email = getParam('email', '');
?>

    <!-- MAIN - Registrazione.php -->
    <main>
        <div class="container">
            <h1>Crea il tuo account</h1>
            <!-- FORM -->
            <form action="../controller/UserController.php" method="post">
                <!-- Nome -->
                <div class="form-item">
                    <label for="nome">Inserisci il nome</label>
                    <input type="text" name="nome" id="nome" placeholder="Mario" value="<?=$nome?>" required>
                </div>
                <!-- Error -->
                <?php if (isset($_SESSION['validationError']['nome'])) { ?>
                    <div class="alert alert-danger" role="alert"><?=$_SESSION['validationError']["message"]?></div>
                <?php } ?>
                
                <!-- Cognome -->
                <div class="form-item">
                    <label for="cognome">Inserisci il cognome</label>
                    <input type="text" name="cognome" id="cognome" placeholder="Rossi" value="<?=$cognome?>" required>
                </div>
                <!-- Error -->
                <?php if (isset($_SESSION['validationError']['cognome'])) { ?>
                    <div class="alert alert-danger" role="alert"><?=$_SESSION['validationError']["message"]?></div>
                <?php } ?>

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

                <!-- Bottone Resgistrati -->
                <button type="submit">REGISTRATI</button>

                <!-- Link a Log-In -->
                <a href="log-in.php">Hai già un account? <strong>Accedi</strong></a>

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

// Include il Footer
require_once '../view/footer.php';
?>