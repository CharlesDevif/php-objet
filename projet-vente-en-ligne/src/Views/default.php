<?php
$isVendeurOuAdmin = $utilisateur && (
    in_array('ROLE_ADMIN', $utilisateur->getRoles()) || in_array('ROLE_VENDEUR', $utilisateur->getRoles())
);
$isClient = $utilisateur && in_array('ROLE_CLIENT', $utilisateur->getRoles());
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application - <?= isset($title) ? $title : "Accueil" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <a class="navbar-brand" href="/projet-vente-en-ligne/">Mon Application</a>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/projet-vente-en-ligne/"><i class="fas fa-home"></i> Accueil</a>
                </li>
                <?php if ($isVendeurOuAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/projet-vente-en-ligne/produit"><i class="fas fa-box"></i> Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projet-vente-en-ligne/commande/historique"><i class="fas fa-history"></i> Historique des commandes</a>
                    </li>
                <?php endif; ?>
                <?php if ($isClient || $isVendeurOuAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/projet-vente-en-ligne/categorie"><i class="fas fa-tags"></i> Catégories</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if ($utilisateur): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/projet-vente-en-ligne/utilisateur/dashboard">
                            <i class="fas fa-user"></i> Dashboard
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link position-relative" href="/projet-vente-en-ligne/panier">
                        <i class="fas fa-shopping-cart"></i> Panier
                        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                            <?= $compteurArticles ?>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main>
    <?= $contenu ?>
</main>

<footer>
    <div class="container py-3">
        <ul class="nav justify-content-center">
            <li class="nav-item"><a href="/projet-vente-en-ligne/" class="nav-link">Accueil</a></li>
            <?php if ($isVendeurOuAdmin): ?>
                <li class="nav-item"><a href="/projet-vente-en-ligne/produit" class="nav-link">Produits</a></li>
                <li class="nav-item"><a href="/projet-vente-en-ligne/commande/historique" class="nav-link">Historique des commandes</a></li>
            <?php endif; ?>
            <?php if ($isClient || $isVendeurOuAdmin): ?>
                <li class="nav-item"><a href="/projet-vente-en-ligne/categorie" class="nav-link">Catégories</a></li>
            <?php endif; ?>
        </ul>
        <p class="text-center">&copy; <?= date('Y'); ?> Mon Application</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
