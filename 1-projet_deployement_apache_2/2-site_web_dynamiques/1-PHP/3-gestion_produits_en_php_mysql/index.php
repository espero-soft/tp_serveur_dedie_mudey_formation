<?php
include_once 'config.php';

// Pagination
$results_per_page = 5; // Nombre de résultats par page
if (!isset ($_GET['page'])) {
    $page = 1; // Par défaut, afficher la première page
} else {
    $page = $_GET['page'];
}
$start_from = ($page - 1) * $results_per_page; // Index de départ pour la requête SQL

// Récupérer le nombre total de produits
$sql_count = "SELECT COUNT(*) AS total FROM produits";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_products = $row_count['total'];

// Récupérer les produits pour la page actuelle
$sql = "SELECT * FROM produits ORDER BY id DESC LIMIT $start_from, $results_per_page";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD des produits</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Liste des produits</h2>
        <div class="d-flex justify-content-between">

            <a href="add_product.php" class="btn btn-primary mb-3">Ajouter un produit</a>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    // Calcul du nombre total de pages
                    $total_pages = ceil($total_products / $results_per_page);

                    // Affichage du lien vers la première page
                    echo "<li class='page-item " . ($page == 1 ? 'disabled' : '') . "'><a class='page-link' href='index.php?page=1'>Début</a></li>";

                    // Affichage des liens pour les pages
                    for ($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++) {
                        $active_class = ($i == $page) ? 'active' : '';
                        echo "<li class='page-item $active_class'><a class='page-link' href='index.php?page=" . $i . "'>" . $i . "</a></li>";
                    }

                    // Affichage du lien vers la dernière page
                    echo "<li class='page-item " . ($page == $total_pages ? 'disabled' : '') . "'><a class='page-link' href='index.php?page=$total_pages'>Fin</a></li>";
                    ?>
                </ul>
            </nav>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Prix régulier</th>
                    <th>Prix avec remise</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $product['id'] . "</td>";
                        echo "<td>" . $product['name'] . "</td>";
                        echo "<td>" . $product['description'] . "</td>";
                        echo "<td><img src='" . $product['image'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
                        echo "<td>" . $product['regular_price'] . " €</td>";
                        echo "<td>" . $product['discount_price'] . " €</td>";

                        echo "<td>
                        <div class='d-flex'>
                        <a href='edit_product.php?id=" . $product['id'] . "' class='btn btn-warning m-1'>Modifier</a>
                        <button type='button' class='btn btn-danger delete-product m-1' data-product-id='" . $product['id'] . "' 
                        data-bs-toggle='modal' 
                        data-bs-target='#confirmDeleteModal'>Supprimer</button>
                        </div>
                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Aucun produit trouvé</td></tr>";
                }
                ?>


            </tbody>
        </table>


        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
            aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation de suppression</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer ce produit ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <a href="#" class="btn btn-danger" id="confirmDeleteButton">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('.delete-product').on('click', function () {
                var productId = $(this).data('product-id');
                console.log({ productId });
                $('#confirmDeleteButton').attr('href', 'delete_product.php?id=' + productId);
            });
        });
    </script>

</body>

</html>