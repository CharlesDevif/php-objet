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
                            <form action="produit/add" method="post">
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                                    <input type="text" class="form-control" id="inputNomProduit">
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription"></textarea>
                                    <label for="textAreaDescription">Description</label>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)">
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="mb-2">
                                    <label for="numberStock" class="form-label">Stock</label>
                                    <input type="number" id="numberStock" class="form-control" />
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Sélectionner le fichier à importer.</label>
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>

                        <!-- ProduitPerissable -->
                        <div class="col card p-3">
                            <h3>Ajout Produit Périssable</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                                    <input type="text" class="form-control" id="inputNomProduit">
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription"></textarea>
                                    <label for="textAreaDescription">Description</label>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)">
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="mb-3">
                                    <label for="numberStock" class="form-label">Stock</label>
                                    <input type="number" id="numberStock" class="form-control" />
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputTemperatureProduit" placeholder="Température de stockage" aria-label="Température en °C">
                                    <span class="input-group-text">°C</span>
                                </div>
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Date d'expiration :</label>
                                    <input type="date" class="form-control" id="inputDateExpirationProduit">
                                </div>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </form>
                        </div>

                        <!-- ProduitPhysique -->
                        <div class="col card p-3">
                            <h3>Ajout Produit Physique</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="inputNomProduit" class="form-label">Nom du produit :</label>
                                    <input type="text" class="form-control" id="inputNomProduit">
                                </div>
                                <div class="mb-3 form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" id="textAreaDescription"></textarea>
                                    <label for="textAreaDescription">Description</label>
                                </div>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" id="inputPrixProduit" placeholder="Prix HT" aria-label="Montant (à l'euro près)">
                                    <span class="input-group-text">€</span>
                                </div>
                                <div class="mb-3">
                                    <label for="numberStock" class="form-label">Stock</label>
                                    <input type="number" id="numberStock" class="form-control" />
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="inputPoidsProduit" placeholder="Poids" aria-label="Poids en kg">
                                    <span class="input-group-text">kg</span>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="inputLongueurProduit" placeholder="Longueur" aria-label="Longueur en cm">
                                    <span class="input-group-text">cm</span>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="inputLargeurProduit" placeholder="Largeur" aria-label="Largeur en cm">
                                    <span class="input-group-text">cm</span>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="inputHauteurProduit" placeholder="Hauteur" aria-label="Hauteur en cm">
                                    <span class="input-group-text">cm</span>
                                </div>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produits as $produit): ?>
                                    <tr>
                                        <th scope="row"><?= $produit->getId() ?></th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
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