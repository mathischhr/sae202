<div class="form-container">

    <h2>Connexion</h2>
    <form action="/connexion/formHandle" method="post">

        <div class="form-control_username">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required placeholder="Entrez votre nom d'utilisateur">
        </div>

        <div class="form-control_password">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required placeholder="*********">
        </div>
        <div class="form-control_submit">
            <button type="submit">Se connecter</button>
        </div>
    </form>
    <div class="link_to_inscription">
        <p>Pas encore inscrit ? </p><a href="/inscription" class="go_to_link">Inscrivez-vous ici</a>
    </div>
    <?php if (isset($errorMessage)): ?>
      <div class="form-errors">
          <p class="error"><?= $errorMessage; ?></p>
      </div>
    <?php endif; ?>

</div>