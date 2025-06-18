
<div class="reservations_container">
    <?php if (!empty($reservations)): ?>
        <ul class="reservations_list">
            <?php foreach ($reservations as $reservation): ?>
                <li class="reservation_item">
                    <div class="reservation_details">
                        <p><strong>Date:</strong> <?= htmlspecialchars($reservation['date_reservation']) ?></p>
                        <p><strong>En groupe:</strong> <?= $reservation['is_group'] ? 'Oui' : 'Non' ?></p>
                        <p><strong>Confirmée:</strong> <?= $reservation['is_confirmed'] ? 'Oui' : 'Non' ?></p>
                    </div>
                    <div class="reservation_actions">
                        <a href="/reservations/<?= $reservation['id'] ?>" class="view_link">Voir</a>
                        <form method="post" action="/reservations/<?= $reservation['id'] ?>/delete" class="delete_form">
                            <button type="submit" class="delete_button">Annuler</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucune réservation trouvée.</p>

        <a href="/reservations/create" class="go_to_link">Réserver une nouvelle place</a>

    <?php endif; ?>
</div>