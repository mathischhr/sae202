<div class="form-container">

  
    <form action="/inscription/formHandle" method="post">

        <div class="form-control_email">
            <label for="email">Votre email :</label>
            <input type="email" id="email" name="email" required placeholder="Entrez votre email">
        </div>
        <div class="form-control_username">
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required placeholder="Entrez votre nom d'utilisateur">
        </div>

        <div class="form-control_password">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required placeholder="*********">
        </div>
        <div class="form-control_submit">
            <button type="submit">S'inscrire</button>
        </div>
    </form>
    <div class="link_to_connexion">
        <p>Déjà inscrit ?</p> <a href="/connexion" class="go_to_link">Connectez-vous ici</a>
    </div>
    <?php if (isset($errorMessage)): ?>
      <div class="form-errors">
          <p class="error"><?= $errorMessage; ?></p>
      </div>
    <?php endif; ?>

</div>