const express = require('express');
const router = express.Router();
const Blog = require('../model/blog');
const { upload } = require('../config/upload');

router.get("/", async (req, res) => {
    try {
        const blogs = await Blog.find({});
        res.render("index", { blogs: blogs });
    } catch (err) {
        console.error(`Error fetching blogs: ${err}`);
        res.redirect("/");
    }
});

router.get("/new", (req, res) => {
    res.render("new");
});

router.post("/", upload.single("image"), async (req, res) => {
    req.body.blog.body = req.sanitize(req.body.blog.body);
    try {
        const newBlog = {
            title: req.body.blog.title,
            image: "/uploads/" + req.file.filename, // Chemin de l'image dans le dossier public
            body: req.body.blog.body,
        };
        await Blog.create(newBlog);
        console.log("Blog created!");
        res.redirect("/blogs");
    } catch (err) {
        console.error(`Error creating blog: ${err}`);
        res.render("new");
    }
});

router.get("/:id", async (req, res) => {
    try {
        const foundBlog = await Blog.findById(req.params.id);
        res.render("show", { blog: foundBlog });
    } catch (err) {
        console.error(`Error fetching blog: ${err}`);
        res.redirect("/blogs");
    }
});

router.get("/:id/edit", async (req, res) => {
    try {
        const foundBlog = await Blog.findById(req.params.id);
        res.render("edit", { blog: foundBlog });
    } catch (err) {
        console.error(`Error fetching blog: ${err}`);
        res.redirect("/blogs");
    }
});

router.put("/:id", upload.single("image"), async (req, res) => {
    req.body.blog.body = req.sanitize(req.body.blog.body);
    try {
        const blog = await Blog.findById(req.params.id);
        if (!blog) {
            return res.status(404).send("Blog not found");
        }

        // Vérifier si un fichier image a été téléchargé
        let image_path = blog.image; // Chemin de l'image existante par défaut

        if (req.file) {
            // Si un fichier image a été téléchargé, mettre à jour le chemin de l'image
            image_path = "/uploads/" + req.file.filename;
        }

        // Mettre à jour les autres champs du blog
        const updatedBlog = await Blog.findByIdAndUpdate(
            req.params.id,
            {
                title: req.body.blog.title,
                body: req.body.blog.body,
                image: image_path,
            },
            { new: true }
        );

        res.redirect(`/${req.params.id}`);
    } catch (err) {
        console.error(`Error updating blog: ${err}`);
        res.redirect("/blogs");
    }
});

router.delete("/:id", async (req, res) => {
    try {
        await Blog.findByIdAndRemove(req.params.id);
        res.redirect("/blogs");
    } catch (err) {
        console.error(`Error deleting blog: ${err}`);
        res.redirect("/blogs");
    }
});

module.exports = router;