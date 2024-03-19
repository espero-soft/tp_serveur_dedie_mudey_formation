<?php
// Nom de la base de données SQLite
$dbname = "jstore_ecommerce.sqlite";

try {
    // Connexion à la base de données SQLite avec PDO
    $conn = new PDO("sqlite:$dbname");

    // Définir le mode d'erreur PDO sur exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Créer la table 'produits' si elle n'existe pas
    $sql_create_table = "CREATE TABLE IF NOT EXISTS produits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        description TEXT,
        image TEXT,
        regular_price REAL NOT NULL,
        discount_price REAL NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sql_create_table);

    // Vérifier si la table de produits est vide
    $sql_check_empty = "SELECT COUNT(*) AS count FROM produits";
    $result_check_empty = $conn->query($sql_check_empty);
    $product_count = $result_check_empty->fetchColumn();

    // Si la table de produits est vide, insérer des données fictives
    if ($product_count == 0) {
        // Tableau de noms de produits fictifs
        $names = array("Robe", "Chemisier", "Jupe", "Pantalon", "Blouse", "Veste", "T-shirt", "Pull", "Manteau", "Jean");

        // Tableau de descriptions fictives
        $descriptions = array("Conçu pour le confort et le style.", "Un must-have pour votre garde-robe.", "Idéal pour toutes les occasions.", "Fabriqué à partir de matériaux de haute qualité.", "Coupe élégante et moderne.", "Détails de couture élégants.", "Disponible dans une variété de couleurs et de tailles.", "Parfait pour une journée décontractée ou une soirée chic.", "Ajoute une touche de sophistication à votre look.", "Facile à assortir avec d'autres vêtements.");

        // Préparation de la requête SQL
        $sql = "INSERT INTO produits (name, description, image, regular_price, discount_price) VALUES (:name, :description, :image, :regular_price, :discount_price)";
        $stmt = $conn->prepare($sql);

        // Vérification de la préparation de la requête
        if (!$stmt) {
            die("Erreur lors de la préparation de la requête : " . $conn->errorInfo()[2]);
        }

        // Boucle pour insérer des données fictives dans la table
        for ($i = 0; $i < 50; $i++) {
            $name = $names[array_rand($names)];
            $description = $descriptions[array_rand($descriptions)];
            $image = "https://via.placeholder.com/600x300"; // URL d'une image fictive
            $regular_price = rand(20, 200); // Prix régulier aléatoire entre 20 et 200
            $discount_price = $regular_price - rand(5, 20); // Prix avec remise aléatoire entre 5 et 20 de moins que le prix régulier

            // Liaison des valeurs aux paramètres de la requête
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':regular_price', $regular_price);
            $stmt->bindParam(':discount_price', $discount_price);

            // Exécution de la requête
            if (!$stmt->execute()) {
                die("Erreur lors de l'insertion du produit : " . $stmt->errorInfo()[2]);
            }
        }

        // echo "Données de produits générées avec succès.";

        // Fermeture du statement
        $stmt->closeCursor();
    } else {
        // echo "La table de produits n'est pas vide. Aucune donnée de produit n'a été générée.";
    }
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
} finally {
    // Fermeture de la connexion à la base
}