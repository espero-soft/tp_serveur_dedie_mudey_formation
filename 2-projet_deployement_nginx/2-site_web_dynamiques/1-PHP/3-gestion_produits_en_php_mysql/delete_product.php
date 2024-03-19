<?php
include_once 'config.php';
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer le chemin de l'image associée au produit
    $sql = "SELECT image FROM produits WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $image_path = $row['image'];
    } else {
        echo "Produit non trouvé.";
        exit();
    }

    // Supprimer l'image du système de fichiers
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Supprimer le produit de la base de données
    $sql = "DELETE FROM produits WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // update_images($conn);
        header("Location: index.php");
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID du produit non spécifié.";
}

$conn->close();
?>
