<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $regular_price = $_POST['regular_price'];
    $discount_price = $_POST['discount_price'];

    // Traitement de l'upload de l'image
    $target_dir = "uploads/"; // Dossier où seront stockées les images
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Vérifier si le fichier image est une image réelle ou une fausse image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "Le fichier est une image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }
    }

  // Vérifie si le fichier existe déjà
if (file_exists($target_file)) {
    $file_info = pathinfo($target_file);
    $file_extension = isset($file_info['extension']) ? '.' . $file_info['extension'] : '';
    $basename = isset($file_info['filename']) ? $file_info['filename'] : '';
    $counter = 1;
    
    // Ajoute un suffixe numérique au nom du fichier jusqu'à ce qu'il soit unique
    while (file_exists($target_file)) {
        $new_basename = $basename . '_' . $counter;
        $target_file = $file_info['dirname'] . '/' . $new_basename . $file_extension;
        $counter++;
    }
    
    // echo "Le fichier existe déjà. Renommé en: " . basename($target_file) . "<br>";
    $uploadOk = 1; // Autoriser l'upload avec le nouveau nom de fichier
}

    // Vérifie la taille de l'image
    if ($_FILES["image"]["size"] > 500000) {
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Autoriser certains formats de fichiers
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
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
            // Insérer le produit dans la base de données avec le chemin de l'image
            $image_path = $target_file;
            $sql = "INSERT INTO produits (name, description, image, regular_price, discount_price)
            VALUES ('$name', '$description', '$image_path', '$regular_price', '$discount_price')";

            if ($conn->query($sql) === TRUE) {
                
                header("Location: index.php");
            } else {
                echo "Erreur: " . $sql . "<br>" . $conn->error;
            }

        } else {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }

}


$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Ajouter un produit</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Nom:</label>
        <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" class="" id="image" name="image">
    </div>
    <div class="form-group">
        <label for="regular_price">Prix régulier:</label>
        <input type="text" class="form-control" id="regular_price" name="regular_price">
    </div>
    <div class="form-group">
        <label for="discount_price">Prix avec remise:</label>
        <input type="text" class="form-control" id="discount_price" name="discount_price">
    </div>
    <div class="d-flex">
        <a href="/" class="btn btn-secondary mr-1">Annuler</a>
        <button type="submit" class="btn btn-primary mr-1">Ajouter</button>
    </div>
</form>

</div>

</body>
</html>
