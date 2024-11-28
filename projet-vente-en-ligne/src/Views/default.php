<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application - <?= isset($title) ? $title : "Accueil" ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <a class="navbar-brand" href="/projet-vente-en-ligne/">Mon Application</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/projet-vente-en-ligne/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projet-vente-en-ligne/produit">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/projet-vente-en-ligne/categorie">Catégories</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <?= $contenu ?>
    </main>

    <footer>
        <div class="container py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="/projet-vente-en-ligne/" class="nav-link px-2 text-body-secondary">Accueil</a></li>
                <li class="nav-item"><a href="/projet-vente-en-ligne/produit" class="nav-link px-2 text-body-secondary">Produits</a></li>
                <li class="nav-item"><a href="/projet-vente-en-ligne/categorie" class="nav-link px-2 text-body-secondary">Catégories</a></li>
            </ul>
            <p class="text-center text-body-secondary">&copy; <?= date('Y'); ?> Mon Application</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>