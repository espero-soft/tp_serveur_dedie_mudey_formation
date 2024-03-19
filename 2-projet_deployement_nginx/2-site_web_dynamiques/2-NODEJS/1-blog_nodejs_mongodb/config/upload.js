const multer = require("multer");

const storage = multer.diskStorage({
    destination: function (req, file, cb) {
      cb(null, "public/uploads"); // Dossier de destination des images
    },
    filename: function (req, file, cb) {
      cb(null, Date.now() + "-" + file.originalname); // Nom du fichier téléchargé
    },
  });
  
  const upload = multer({ storage: storage });

  module.exports = {upload}