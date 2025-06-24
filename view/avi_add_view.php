
<div class="comment_add_container">
    <h1 class="title">écrire un avis</h1>
    <form method="post" action="/avis/add" class="form-container">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
        <input type="hidden" name="date" value="<?= date('Y-m-d H:i:s') ?>">
        <div class="form_group">
            <label for="rate">Nombre d'étoiles :</label>
             <div class="rating-container">
        <div class="stars" data-rating="3">
            <span class="star" data-value="1"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg></span>
            <span class="star" data-value="2"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg></span>
            <span class="star" data-value="3"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg></span>
            <span class="star" data-value="4"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg></span>
            <span class="star" data-value="5"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="m354-287 126-76 126 77-33-144 111-96-146-13-58-136-58 135-146 13 111 97-33 143ZM233-120l65-281L80-590l288-25 112-265 112 265 288 25-218 189 65 281-247-149-247 149Zm247-350Z"/></svg></span>
        </div>
        <p>Votre avis : <span id="currentRating">3</span> étoile(s)</p>
      
    </div>
            <input type="hidden" id="rate" name="rate" value="3">
        </div>
        <div class="form_group">
            <label for="content">Contenu de votre avis:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <button type="submit" class="submit_button">Ajouter mon avis </button>
    </form>
    <a href="/avis" class="button_action go_to_link">Retour à mes avis</a>
</div>