<div class="comment_edit_container">
    <h1>Modifier le Commentaire</h1>
    <form method="post" action="/comments/edit?id=<?= $comment['id'] ?>" class="form-container">
        <div class="form_group">
            <label for="content">Contenu:</label>
            <textarea id="content" name="content" required><?= $comment['content'] ?></textarea>
        </div>
        <button type="submit" class="submit_button">Mettre à jour</button>
    </form>
</div>
