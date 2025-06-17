<div class="messagerie_container">
    <h1>Messagerie</h1>
    <p>Bienvenue dans votre messagerie. Vous pouvez envoyer et recevoir des messages ici.</p>

    <div class="messagerie-info">
        <h2>Boîte de réception</h2>
        <ul>
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $message): ?>
                    <li>
                        <strong>De:</strong> <?= htmlspecialchars($message['sender']) ?> |
                        <strong>Date:</strong> <?= htmlspecialchars($message['date']) ?> |
                        <a href="/messagerie/view/<?= $message['id'] ?>">Voir le message</a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucun message dans votre boîte de réception.</li>
            <?php endif; ?>
        </ul>
    </div>

</div>