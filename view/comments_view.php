
<div>
    <h1>Mes Commentaires</h1>
    <?php if (!empty($myComments)): ?>
        <ul class="comments_list">
            <?php foreach ($myComments as $comment): ?>
                <li class="comment_item">
                    <div class="comment_details">
                        <p><strong>Date:</strong> <?= htmlspecialchars($comment['date']) ?></p>
                    
                        <p><strong>Contenu:</strong> <?= nl2br($comment['content']) ?></p>
                    </div>
                    <div class="comment_actions">
                        <a href="/comments/view?id=<?= $comment['id'] ?>" class="view_link">Voir</a>
                        <a href="/comments/edit?id=<?= $comment['id'] ?>" class="edit_link">Modifier</a>
                        <a href="/comments/delete?id=<?= $comment['id'] ?>" class="delete_link">Supprimer</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <a href="/comments/add" class="go_to_link">Ajouter un nouveau commentaire</a>

    <?php else: ?>
        <p>Aucun commentaire trouvé.</p>
        <a href="/comments/add" class="go_to_link">Ajouter un nouveau commentaire</a>
    <?php endif; ?>
</div>