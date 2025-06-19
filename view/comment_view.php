<div class="comment_view_container">
    <p><?= nl2br($comment['content']) ?></p>
    <p><em>Publié le <?= htmlspecialchars($comment['date']) ?></em></p>
    <div class="comment_actions">
        <a href="/comments/edit?id=<?= $comment['id'] ?>" class="action-button">Modifier</a>
        <a href="/comments/delete?id=<?= $comment['id'] ?>" class="action-button">Supprimer</a>
    </div>
</div>