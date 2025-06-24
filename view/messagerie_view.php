<div class="messagerie_container">
<h1 id="concept">Messagerie</h1>
    <div class="messagerie-box">
        <div class=" left-content">
            <div class="messages_list <?php if (empty($messages)): ?> empty <?php endif; ?>">
                <?php if (empty($messages)): ?>
                    <p>Aucun message trouvé.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Destinataire</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr class="<?= 'non_lu' == $message['statut'] ? 'unread' : 'read'; ?>">
                                    <td><?= htmlspecialchars($message['destinataire']) ?></td>
                                    <td><?= htmlspecialchars($message['statut']) ?></td>
                                    <td class="action-buttons">
                                        <a href="/messagerie/view?id=<?= $message['id'] ?>" class="action-button_view">Voir</a>
                                        <a href="/messagerie/delete?id=<?= $message['id'] ?>" class="action-button_delete">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

</div>