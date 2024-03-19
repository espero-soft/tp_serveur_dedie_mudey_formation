<?php
include_once 'config.php';
include_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer le chemin de l'image associée au produit
    $sql = "SELECT image FROM produits WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $image_path = $stmt->fetchColumn();
    
    if (!$image_path) {
        echo "Produit non trouvé.";
        exit();
    }

    // Supprimer l'image du système de fichiers
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    // Supprimer le produit de la base de données
    $sql = "DELETE FROM produits WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Erreur: " . $sql . "<br>" . $stmt->error;
    }
} else {
    echo "ID du produit non spécifié.";
}

?>
