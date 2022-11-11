<?php
session_start();
require_once '../headerInclude.php';

// Eventi collegati all'utente che vengono passati tramite sessione
$_SESSION['user']['events'] ?? getEventsByUserEmail($_SESSION['user']['email']);
$events = $_SESSION['user']['events'];
?>

    <!-- MAIN - Log-In.php -->
    <main>
        <h1>Ciao <?=$_SESSION['user']['nome']?>, ecco i tuoi eventi</h1>
        <div class="container">
            <div class="row">
                <?php foreach ($events as $event) { ?>
                        <div class="col">
                            <!-- Card -->
                            <div class="event-card">
                                <!-- Title -->
                                <h2 class="title"><?=$event['nome_evento']?></h2>
                                <div class="date-time"><?=$event['data_evento']?></div>
                                <!-- Button Registrati -->
                                <button type="submit">JOIN</button>
                            </div>
                        </div>
                <?php } ?>
            </div> 
                          
                
                
            
            
        </div>
    </main>
    
<?php
require_once '../view/footer.php';
?>