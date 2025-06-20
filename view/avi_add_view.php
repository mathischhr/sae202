
<div class="comment_add_container">
    <h1>Ajouter un nouvel avis </h1>
    <form method="post" action="/avis/add" class="form-container">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
        <input type="hidden" name="date" value="<?= date('Y-m-d H:i:s') ?>">
        <div class="form_group">
            <label for="rate">Nombre d'étoiles :</label>
            <input type="range" id="rate" name="rate" max="5" min="1" step="1" required>
        </div>
        <div class="form_group">
            <label for="content">Contenu de votre avis:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <button type="submit" class="submit_button">Ajouter mon avis </button>
    </form>
    <a href="/avis" class="button_action go_to_link">Retour à mes avis</a>
</div>