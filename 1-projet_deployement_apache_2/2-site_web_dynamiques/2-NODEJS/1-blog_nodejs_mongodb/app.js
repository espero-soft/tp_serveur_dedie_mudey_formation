require("dotenv").config();

const express = require("express");
const app = express();
const mongoose = require("mongoose");
const expressSanitizer = require("express-sanitizer");
const bodyParser = require("body-parser");
const methodOverride = require("method-override");
const PORT = process.env.PORT || 3000;

// Connexion à la base de données
console.log({MONGODBURI: process.env.MONGODBURI});
mongoose.connect(process.env.MONGODBURI, { useNewUrlParser: true, useUnifiedTopology: true, useCreateIndex: true })
  .then(() => console.log(`Connected to the DataBase!`))
  .catch(err => console.error(`Error connecting to the database: ${err}`));

app.set("view engine", "twig");
app.use(bodyParser.urlencoded({ extended: true }));
app.use(expressSanitizer());
app.use(express.static("public"));
app.use(methodOverride("_method"));




// Importer les routes
const indexRoutes = require('./routes/index.route');
const blogsRoutes = require('./routes/blogs.route');

// Utiliser les routes dans l'application
app.use('/', indexRoutes);
app.use('/blogs', blogsRoutes);



app.listen(PORT, () => {
  console.log(`Server for Blog App has started on ${PORT}`);
});
