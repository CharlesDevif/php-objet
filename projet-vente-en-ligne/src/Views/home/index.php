<div class="container p-4">
    <div class="row gap-5">
        <h2>Ajout de produits</h2>

        <!-- ProduitNumerique -->
        <div class="col card p-3">
            <h3>Ajout Produit Numérique</h3>
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
    </div>
</div>