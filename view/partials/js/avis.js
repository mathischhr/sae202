document.addEventListener('DOMContentLoaded', () => {
    const starsContainer = document.querySelector('.stars');
    const stars = document.querySelectorAll('.star');
    const currentRatingSpan = document.getElementById('currentRating');
    const submitButton = document.getElementById('submitRating');

    let currentRating = parseInt(starsContainer.dataset.rating); // Récupère le rating par défaut (3)
    let hoveredRating = 0; // Pour stocker le nombre d'étoiles survolées

    // Fonction pour mettre à jour l'affichage des étoiles
    function updateStarsDisplay(ratingToDisplay) {
        stars.forEach((star, index) => {
            if (index < ratingToDisplay) {
                star.classList.add('filled');
            } else {
                star.classList.remove('filled');
            }
            star.classList.remove('hovered'); // Supprime le style de survol
            star.classList.remove('hovered-prev'); // Supprime le style de survol précédent
        });
    }

    // Initialise l'affichage avec le nombre d'étoiles par défaut
    updateStarsDisplay(currentRating);
    currentRatingSpan.textContent = currentRating;

    // Gère le survol des étoiles
    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            hoveredRating = parseInt(star.dataset.value);
            stars.forEach((s, index) => {
                if (index < hoveredRating) {
                    s.classList.add('hovered'); // Applique le style de survol
                    s.classList.add('hovered-prev'); // Applique le style pour les étoiles précédentes
                } else {
                    s.classList.remove('hovered');
                    s.classList.remove('hovered-prev');
                }
            });
            // Met à jour le texte pour montrer le nombre d'étoiles survolées
            currentRatingSpan.textContent = hoveredRating;
        });

        star.addEventListener('mouseout', () => {
            // Réinitialise l'affichage au rating actuel lorsque la souris quitte les étoiles
            updateStarsDisplay(currentRating);
            currentRatingSpan.textContent = currentRating;
        });

        star.addEventListener('click', () => {
            currentRating = parseInt(star.dataset.value); // Met à jour le rating au clic
            starsContainer.dataset.rating = currentRating; // Met à jour l'attribut data-rating
            updateStarsDisplay(currentRating); // Met à jour l'affichage
            currentRatingSpan.textContent = currentRating; // Met à jour le texte

            document.getElementById('rate').value = currentRating; // Met à jour le champ caché avec la nouvelle valeur

        });
    });

});