<?php


$servername = "localhost";
$username = "root";
$password = "";

// Connexion au serveur MySQL
$conn = new mysqli($servername, $username, $password);

// Vérification de la connexion
if ($conn->connect_error) {
    die ("La connexion a échoué : " . $conn->connect_error);
}

// Nom de la base de données
$dbname = "jstore_ecommerce";

// Vérification si la base de données existe
$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");

// Si la base de données n'existe pas, la créer
if ($result->num_rows == 0) {
    $sql_create_db = "CREATE DATABASE $dbname";
    if ($conn->query($sql_create_db) === TRUE) {
        // echo "Base de données '$dbname' créée avec succès.<br>";
    } else {
        die ("Erreur lors de la création de la base de données : " . $conn->error);
    }
}

// Sélection de la base de données
$conn->select_db($dbname);

// Créer la table 'produits' si elle n'existe pas
$sql_create_table = "CREATE TABLE IF NOT EXISTS produits (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    regular_price DECIMAL(10, 2) NOT NULL,
    discount_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql_create_table) === TRUE) {
    // echo "Table 'produits' créée avec succès ou existe déjà.<br>";
} else {
    die ("Erreur lors de la création de la table 'produits' : " . $conn->error);
}

// Vérifier si la table de produits est vide
$sql_check_empty = "SELECT COUNT(*) AS count FROM produits";
$result_check_empty = $conn->query($sql_check_empty);
$row_check_empty = $result_check_empty->fetch_assoc();
$product_count = $row_check_empty['count'];

// Si la table de produits est vide, insérer des données fictives
if ($product_count == 0) {
    // Tableau de noms de produits fictifs
    $names = array("Robe", "Chemisier", "Jupe", "Pantalon", "Blouse", "Veste", "T-shirt", "Pull", "Manteau", "Jean");

    // Tableau de descriptions fictives
    $descriptions = array("Conçu pour le confort et le style.", "Un must-have pour votre garde-robe.", "Idéal pour toutes les occasions.", "Fabriqué à partir de matériaux de haute qualité.", "Coupe élégante et moderne.", "Détails de couture élégants.", "Disponible dans une variété de couleurs et de tailles.", "Parfait pour une journée décontractée ou une soirée chic.", "Ajoute une touche de sophistication à votre look.", "Facile à assortir avec d'autres vêtements.");

    // Préparation de la requête SQL
    $sql = "INSERT INTO produits (name, description, image, regular_price, discount_price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Vérification de la préparation de la requête
    if (!$stmt) {
        die ("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    // Boucle pour insérer des données fictives dans la table
    for ($i = 0; $i < 50; $i++) {
        $name = $names[array_rand($names)];
        $description = $descriptions[array_rand($descriptions)];
        $image = "https://via.placeholder.com/600x300"; // URL d'une image fictive
        $regular_price = rand(20, 200); // Prix régulier aléatoire entre 20 et 200
        $discount_price = $regular_price - rand(5, 20); // Prix avec remise aléatoire entre 5 et 20 de moins que le prix régulier

        // Liaison des valeurs aux paramètres de la requête
        $stmt->bind_param("ssssd", $name, $description, $image, $regular_price, $discount_price);

        // Exécution de la requête
        if (!$stmt->execute()) {
            // echo "Erreur lors de l'insertion du produit : " . $stmt->error;
        }
    }

    // echo "Données de produits générées avec succès.";

    // Fermeture du statement
    $stmt->close();
} else {
    // echo "La table de produits n'est pas vide. Aucune donnée de produit n'a été générée.";
}



// Fermeture de la connexion à la base de données
// $conn->close();
?>