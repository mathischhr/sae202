<div>
    <h2>Bienvenue, le site est en cours de cuisson </h2>
</div>

<?php if (isset($_SESSION['user'])): 

//var_dump($_SESSION['user']);
    
    ?>
    <div class="welcome-message">
        <p>Bienvenue, <?= htmlspecialchars($_SESSION['user']['username']) . "   "  . $_SESSION['user']['email']; ?> !</p>
        <a href="/connexion/logout" class="logout-link">Se déconnecter</a>
    </div>
<?php endif; ?>