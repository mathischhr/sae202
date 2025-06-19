
<div class="comment_add_container">
    <h1>Ajouter un Commentaire</h1>
    <form method="post" action="/comments/add" class="form-container">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
        <div class="form_group">
            <label for="content">Contenu du Commentaire:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <button type="submit" class="submit_button">Ajouter le Commentaire</button>
    </form>
    <a href="/comments" class="button_action go_to_link">Retour aux Commentaires</a>
</div>