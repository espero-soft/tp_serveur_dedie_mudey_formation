<?php
function get_products($conn)
{
    $sql = "SELECT * FROM produits";
    $result = $conn->query($sql);
    $products = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}
function update_images($conn)
{
    $images_directory = "uploads/";
    // Ouvrir le répertoire des images
    $images = glob($images_directory . "*");
    // Sélectionner tous les noms de fichiers d'images dans la base de données
    $sql_select_images = "SELECT image FROM produits";
    $result_select_images = $conn->query($sql_select_images);

    // Stocker tous les noms de fichiers d'images associées aux produits
    $images_associated_with_product = array();
    if ($result_select_images->num_rows > 0) {
        while ($row = $result_select_images->fetch_assoc()) {
            $images_associated_with_product[] = $row["image"];
        }
    }

    var_dump($images_associated_with_product);

    // Parcourir chaque image dans le répertoire
    foreach ($images as $image) {
        // Vérifier si l'image est associée à un produit dans la base de données
        if (!in_array(basename($image), $images_associated_with_product)) {
            // Si l'image n'est pas associée à un produit, la supprimer du répertoire
            // unlink($image);
            // echo "Image supprimée : " . basename($image) . "<br>";
        }
    }
}
?>