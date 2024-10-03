// Fonction pour réinitialiser les notifications du panier
function resetCartNotifications() {
    // Sélectionner l'élément qui affiche les notifications du panier
    var cartNotification = document.getElementById('cart-notification');

    // Vérifier si l'élément existe
    if (cartNotification) {
        // Réinitialiser le texte des notifications du panier à zéro
        cartNotification.textContent = '0';
    }
}

// Fonction appelée lorsqu'un produit est ajouté au panier
function addToCart() {
    var cartNotification = document.getElementById('cart-notification');

    // Si l'élément existe, incrémenter le nombre de notifications
    if (cartNotification) {
        var currentCount = parseInt(cartNotification.textContent, 10) || 0;
        cartNotification.textContent = currentCount + 1;
    }
}

// Appel de la fonction resetCartNotifications quand la page est chargée
window.onload = function() {
    resetCartNotifications();
};
