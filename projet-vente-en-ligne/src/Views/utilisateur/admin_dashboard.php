<section class="container mt-3">
    <h1>Bienvenue, <?= htmlspecialchars($utilisateur->getNom()); ?> !</h1>
    <p>Vous êtes connecté en tant qu'administrateur.</p>
    <a href="/projet-vente-en-ligne/utilisateur/deconnexion" class="btn btn-danger">Se déconnecter</a>
</section>