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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Applique Flexbox au body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Assure que le contenu principal prend tout l'espace disponible */
        main {
            flex: 1;
            padding: 20px;
            background-color: #fff;
            margin: 0px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1800px;
            width: 100%;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #ddd;
            padding: 20px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        footer .nav {
            justify-content: center;
        }

        footer .nav-link {
            color: #ddd;
            transition: color 0.3s ease-in-out;
        }

        footer .nav-link:hover {
            color: #fff;
        }
    </style>





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
                            <a class="nav-link" href="/projet-vente-en-ligne/categorie"><i class="fas fa-tags"></i> Catégories</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($isClient || $isVendeurOuAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/projet-vente-en-ligne/commande/historique"><i class="fas fa-history"></i> Historique des commandes</a>
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
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/projet-vente-en-ligne/utilisateur/connexion">
                                Connexion
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