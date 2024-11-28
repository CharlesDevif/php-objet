<?php

use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPhysique;
use App\Entity\Produit\ProduitPerissable;

?>

<section class="container row mx-auto items-center gap-5 mt-4">

    <?php if ($produit instanceof ProduitNumerique) : ?>
        <!-- ProduitNumerique -->
        <div class="col card p-3">
            <h3>Modification Produit Numérique</h3>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                    <input type="text" class="form-control" id="inputNomProduit" name="nom" value="<?= $produit->getNom(); ?>" required>
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription" name="description" value="<?= $produit->getDescription(); ?>" required></textarea>
                    <label for="textAreaDescription">Description</label>
                </div>
                <div class="input-group mb-1">
                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)" name="prix" value="<?= $produit->getPrix(); ?>" required>
                    <span class="input-group-text">€</span>
                </div>
                <div class="mb-2">
                    <label for="numberStock" class="form-label">Stock</label>
                    <input type="number" id="numberStock" class="form-control" name="stock" value="<?= $produit->getStock(); ?>" required />
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Sélectionner le fichier à importer.</label>
                    <input class="form-control" type="file" id="formFile" name="file" required>
                </div>
                <button type="submit" name="numerique" class="btn btn-primary">Modifier</button>
                <a class="btn btn-warning" href="/projet-vente-en-ligne/produit">Annuler</a>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($produit instanceof ProduitPerissable) : ?>
        <!-- ProduitPerissable -->
        <div class="col card p-3">
            <h3>Modification Produit Périssable</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                    <input type="text" class="form-control" id="inputNomProduit" name="nom" value="<?= $produit->getNom(); ?>">
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription" name="description"><?= $produit->getDescription(); ?></textarea>
                    <label for="textAreaDescription">Description</label>
                </div>
                <div class="input-group mb-1">
                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)" name="prix" value="<?= $produit->getPrix(); ?>">
                    <span class="input-group-text">€</span>
                </div>
                <div class="mb-3">
                    <label for="numberStock" class="form-label">Stock</label>
                    <input type="number" id="numberStock" class="form-control" name="stock" value="<?= $produit->getStock(); ?>" />
                </div>
                <div class="input-group mb-1">
                    <input type="text" class="form-control" id="inputTemperatureProduit" placeholder="Température de stockage" aria-label="Température en °C" name="temperature" value="<?= $produit->getTemperatureStockage(); ?>">
                    <span class="input-group-text">°C</span>
                </div>
                <div class="mb-3">
                    <label for="inputNomProduit" class="form-label">Date d'expiration :</label>
                    <input type="date" class="form-control" id="inputDateExpirationProduit" name="dateExpiration" value="<?= $produit->getDateExpiration()->format('Y-m-d'); ?>">
                </div>
                <button type="submit" name="perissable" class="btn btn-primary">Modifier</button>
                <a class="btn btn-warning" href="/projet-vente-en-ligne/produit">Annuler</a>
            </form>
        </div>
    <?php endif; ?>

    <?php if ($produit instanceof ProduitPhysique) : ?>
        <!-- ProduitPhysique -->
        <div class="col card p-3">
            <h3>Modification Produit Physique</h3>
            <form method="POST">
                <div class="mb-3">
                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                    <input type="text" class="form-control" id="inputNomProduit" name="nom" value="<?= $produit->getNom(); ?>">
                </div>
                <div class="mb-3 form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription" name="description"><?= $produit->getDescription(); ?></textarea>
                    <label for="textAreaDescription">Description</label>
                </div>
                <div class="input-group mb-1">
                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)" name="prix" value="<?= $produit->getPrix(); ?>">
                    <span class="input-group-text">€</span>
                </div>
                <div class="mb-3">
                    <label for="numberStock" class="form-label">Stock</label>
                    <input type="number" id="numberStock" class="form-control" name="stock" value="<?= $produit->getStock(); ?>" />
                </div>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputPoidsProduit" placeholder="Poids" aria-label="Poids en kg" name="poids" value="<?= $produit->getPoids(); ?>">
                    <span class="input-group-text">kg</span>
                </div>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputLongueurProduit" placeholder="Longueur" aria-label="Longueur en cm" name="longueur" value="<?= $produit->getLongueur(); ?>">
                    <span class="input-group-text">cm</span>
                </div>
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputLargeurProduit" placeholder="Largeur" aria-label="Largeur en cm" name="largeur" value="<?= $produit->getLargeur(); ?>">
                    <span class="input-group-text">cm</span>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="inputHauteurProduit" placeholder="Hauteur" aria-label="Hauteur en cm" name="hauteur" value="<?= $produit->getHauteur(); ?>">
                    <span class="input-group-text">cm</span>
                </div>
                <button type="submit" name="physique" class="btn btn-primary">Modifier</button>
                <a class="btn btn-warning" href="/projet-vente-en-ligne/produit">Annuler</a>
            </form>
        </div>
    <?php endif; ?>
</section>