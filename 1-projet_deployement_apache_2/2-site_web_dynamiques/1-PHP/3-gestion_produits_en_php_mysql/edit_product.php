<?php
include_once 'config.php';

if (($_SERVER["REQUEST_METHOD"] == "POST" || $_SERVER["REQUEST_METHOD"] == "GET") && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM produits WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produit non trouvé.";
        exit();
    }
} else {
    
    echo "ID du produit non spécifié.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $regular_price = $_POST['regular_price'];
    $discount_price = $_POST['discount_price'];

    // Traitement de l'upload de l'image
    if($_FILES["image"]["name"] != "") {
        $target_dir = "uploads/"; // Dossier où seront stockées les images
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Vérifier si le fichier image est une image réelle ou une fausse image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // Vérifie si le fichier existe déjà
        if (file_exists($target_file)) {
            echo "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // Vérifie la taille de l'image
        if ($_FILES["image"]["size"] > 500000) {
            echo "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // Autoriser certains formats de fichiers
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "webp") {
            echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        // Vérifier si $uploadOk est défini sur 0 par une erreur
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas été téléchargé.";

        // Si tout est bon, tenter d'uploader l'image
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "Le fichier ". htmlspecialchars( basename( $_FILES["image"]["name"])). " a été téléchargé avec succès.";
                $image_path = $target_file;

            } else {
                echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    } else {
        // Si aucun fichier n'est téléchargé, conserver l'image existante
        $image_path = $row['image'];
    }

    // Mettre à jour les données du produit dans la base de données
    $sql = "UPDATE produits SET name='$name', description='$description', image='$image_path', regular_price='$regular_price', discount_price='$discount_price' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // update_images($conn);
        header("Location: index.php");
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le produit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Modifier le produit</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $id; ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>">
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"><?php echo $row['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="" id="image" name="image">
            <img src="<?php echo $row['image']; ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;">
        </div>
        <div class="form-group">
            <label for="regular_price">Prix régulier:</label>
            <input type="text" class="form-control" id="regular_price" name="regular_price" value="<?php echo $row['regular_price']; ?>">
        </div>
        <div class="form-group">
            <label for="discount_price">Prix avec remise:</label>
            <input type="text" class="form-control" id="discount_price" name="discount_price" value="<?php echo $row['discount_price']; ?>">
        </div>
        
        <div class="d-flex">
        <a href="/" class="btn btn-secondary mr-1">Annuler</a>
        <button type="submit" class="btn btn-primary mr-1">Modifier</button>
    </div>
    </form>
</div>

</body>
</html>
