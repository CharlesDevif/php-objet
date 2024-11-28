<?php

use App\Entity\Produit\ProduitNumerique;
use App\Entity\Produit\ProduitPhysique;
use App\Entity\Produit\ProduitPerissable;

?>

<div class="container p-4">
    <section class="mb-3">
        <h2 class="mb-2">Produits</h2>

        <div class="accordion" id="accordionProduit">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Ajout de produits
                    </button>
                </h2>

                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionProduit">
                    <section class="row gap-5 accordion-body">

                        <!-- ProduitNumerique -->
                        <div class="col card p-3">
                            <h3>Ajout Produit Numérique</h3>
                            <form action="produit/add" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                                    <input type="text" class="form-control" id="inputNomProduit" name="nom">
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription" name="description"></textarea>
                                    <label for="textAreaDescription">Description</label>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)" name="prix">
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="mb-2">
                                    <label for="numberStock" class="form-label">Stock</label>
                                    <input type="number" id="numberStock" class="form-control" name="stock" />
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Sélectionner le fichier à importer.</label>
                                    <input class="form-control" type="file" id="formFile" name="file">
                                </div>
                                <button type="submit" name="numerique" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>

                        <!-- ProduitPerissable -->
                        <div class="col card p-3">
                            <h3>Ajout Produit Périssable</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                                    <input type="text" class="form-control" id="inputNomProduit" name="nom">
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription" name="description"></textarea>
                                    <label for="textAreaDescription">Description</label>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)" name="prix">
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="mb-3">
                                    <label for="numberStock" class="form-label">Stock</label>
                                    <input type="number" id="numberStock" class="form-control" name="stock" />
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputTemperatureProduit" placeholder="Température de stockage" aria-label="Température en °C" name="temperature">
                                    <span class="input-group-text">°C</span>
                                </div>
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Date d'expiration :</label>
                                    <input type="date" class="form-control" id="inputDateExpirationProduit" name="dateExpiration">
                                </div>
                                <button type="submit" name="perissable" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>

                        <!-- ProduitPhysique -->
                        <div class="col card p-3">
                            <h3>Ajout Produit Physique</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                                    <input type="text" class="form-control" id="inputNomProduit" name="nom">
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription" name="description"></textarea>
                                    <label for="textAreaDescription">Description</label>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)" name="prix">
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="mb-3">
                                    <label for="numberStock" class="form-label">Stock</label>
                                    <input type="number" id="numberStock" class="form-control" name="stock" />
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="inputPoidsProduit" placeholder="Poids" aria-label="Poids en kg" name="poids">
                                    <span class="input-group-text">kg</span>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="inputLongueurProduit" placeholder="Longueur" aria-label="Longueur en cm" name="longueur">
                                    <span class="input-group-text">cm</span>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="inputLargeurProduit" placeholder="Largeur" aria-label="Largeur en cm" name="largeur">
                                    <span class="input-group-text">cm</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="inputHauteurProduit" placeholder="Hauteur" aria-label="Hauteur en cm" name="hauteur">
                                    <span class="input-group-text">cm</span>
                                </div>
                                <button type="submit" name="physique" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>
                    </section>
                </div>

            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Table de produits
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionProduit">
                    <section class="accordion-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Prix</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Fichier</th>
                                    <th scope="col">Température de stockage</th>
                                    <th scope="col">Date d'expiration</th>
                                    <th scope="col">Poids</th>
                                    <th scope="col">Longueur</th>
                                    <th scope="col">Largeur</th>
                                    <th scope="col">Hauteur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produits as $produit): ?>
                                    <tr>
                                        <th scope="row"><?= $produit->getId() ?></th>
                                        <td><?= $produit->getNom() ?></td>
                                        <td><?= $produit->getDescription() ?></td>
                                        <td><?= $produit->getPrix() ?></td>
                                        <td><?= $produit->getStock() ?></td>
                                        <td><?= ($produit instanceof ProduitNumerique) ? basename($produit->getLienTelechargement()) : 'null' ?></td>
                                        <td><?= ($produit instanceof ProduitPerissable) ? $produit->getTemperatureStockage() : 'null' ?></td>
                                        <td><?= ($produit instanceof ProduitPerissable) ? $produit->getDateExpiration()->format('dd-MM-YYYY') : 'null' ?></td>
                                        <td><?= ($produit instanceof ProduitPhysique) ? $produit->getPoids() : 'null' ?></td>
                                        <td><?= ($produit instanceof ProduitPhysique) ? $produit->getLongueur() : 'null' ?></td>
                                        <td><?= ($produit instanceof ProduitPhysique) ? $produit->getLargeur() : 'null' ?></td>
                                        <td><?= ($produit instanceof ProduitPhysique) ? $produit->getHauteur() : 'null' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>
    </section>
</div>