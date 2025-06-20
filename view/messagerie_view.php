<div class="messagerie_container">
    <h1>Messagerie</h1>
    <p>Bienvenue dans votre messagerie. Vous pouvez envoyer et recevoir des messages ici.</p>

    <div class="messagerie-box">
        <div class=" left-content">
            <h2>Messages</h2>
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


        <div class="form-box">
            <form>
               <select id="destinataire" name="destinataire" required>
                        <?php foreach ($adminUsers as $admin): ?>
                            <option value="<?= $admin['id'] ?>"><?= htmlspecialchars($admin['username']) ?></option>
                        <?php endforeach; ?>
                    </select>
                <textarea placeholder="Écrivez votre message"></textarea>
            </form>
        </div>
        <div class="form-container">
            <h2>Envoyer un message</h2>
            <form method="post" action="/messagerie/send">

                <input type="text" id="user_id" name="user_id" value="<?= htmlspecialchars($_SESSION['user']['id']) ?>" hidden>

                <div class="form-group">
                    <label for="destinataire">Destinataire:</label>
                    <select id="destinataire" name="destinataire" required>
                        <?php foreach ($adminUsers as $admin): ?>
                            <option value="<?= $admin['id'] ?>"><?= htmlspecialchars($admin['username']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message_content">Message:</label>
                    <textarea id="message_content" name="contenu" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="send-button">Envoyer</button>
                </div>
        </div>
    </div>

</div>