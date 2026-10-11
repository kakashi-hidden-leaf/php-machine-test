<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $total_copies = $_POST['total_copies'];
    $available_copies = $_POST['available_copies'];

    $sql = "insert into books (title, author, genre, total_copies, available_copies) values ('$title', '$author', '$genre', '$total_copies', '$available_copies')";

    if ($conn->query($sql)) {
        header('Location: homes.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">add new book</h3>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label">book title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Author Name</label>
                                <input type="text" name="author" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Genre</label>
                                <input type="text" name="genre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Total Copies</label>
                                <input type="number" name="total_copies" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Available Copies</label>
                                <input type="number" name="available_copies" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mb-2">Save Book</button>
                            <a href="homes.php" class="btn btn-secondary w-100">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>