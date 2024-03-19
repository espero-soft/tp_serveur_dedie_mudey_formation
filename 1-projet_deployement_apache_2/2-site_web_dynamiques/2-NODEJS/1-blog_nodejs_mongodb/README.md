# Blog App

This is a simple blogging application built with Node.js, Express, MongoDB, and Twig for templating.

## Installation

1. Clone the repository:

```bash
git clone <repository_url>
```

2. Navigate to the project directory:

```bash
cd <project_directory>
```

3. Install dependencies:

```bash
npm install
```

4. Set up environment variables:

Create a `.env` file in the root directory and add the following environment variables:

```plaintext
PORT=3000
MONGODBURI=<your_mongodb_uri>
```

Replace `<your_mongodb_uri>` with the URI of your MongoDB database.

5. Start the server:

```bash
npm start
```

## Usage

- Visit the homepage at `http://localhost:3000` to view all blog posts.
- Navigate to `http://localhost:3000/blogs/new` to create a new blog post.
- Click on a blog post title to view its details.
- Edit or delete a blog post by clicking on the respective buttons on the blog post page.

## Features

- Create, read, update, and delete (CRUD) operations for blog posts.
- Image upload functionality for blog post covers.
- Sanitization of blog post content to prevent XSS attacks.

## Technologies Used

- Node.js
- Express.js
- MongoDB
- Twig (template engine)
- Express Sanitizer (middleware)
- Method-Override (middleware)
- Bootstrap (for styling)

## Credits

This application was created by [Your Name]. 

## License

This project is licensed under the [MIT License](LICENSE).