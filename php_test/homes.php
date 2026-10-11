<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];

if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    $conn->query("delete from books where id = '$del_id'");
    header('Location: homes.php');
}

if (isset($_POST['update_book'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $available_copies = $_POST['available_copies'];

    $conn->query("update books set title='$title', author='$author', genre='$genre', available_copies='$available_copies' where id='$id'");
    header('Location: homes.php');
}

$result = $conn->query('select * from books');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light pt-5">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="homes.php">Library</a>
            <div class="ms-auto d-flex align-items-center">
                <span class="navbar-text text-white me-3">Hello <?php echo $username; ?></span>
                <a href="add.php" class="btn btn-primary btn-sm me-2">Add Book</a>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Book Dashboard</h3>
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Download Report
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="generate_pdf.php">PDF Format</a></li>
                    <li><a class="dropdown-item" href="generate_pdf.php">Excel Format</a></li>
                </ul>
            </div>
        </div>

        <style>
            @keyframes shiftGradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            .table-gradient-header th {
                background: linear-gradient(270deg, #0d6efd, #6610f2, #d63384, #0d6efd) ;
                background-size: 400% 400% ;
                animation: shiftGradient 6s ease infinite ;
                color: white;
            }
        </style>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover bg-white text-center">
                <thead class="table-gradient-header">
                    <tr>
                        <th>Book ID</th>
                        <th>Book Title</th>
                        <th>Author Name</th>
                        <th>Genre</th>
                        <th>Available Copies</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['author']; ?></td>
                                <td><?php echo $row['genre']; ?></td>
                                <td><?php echo $row['available_copies']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                </td>
                                <td>
                                    <a href="homes.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('are you sure u want to delete?')">Delete</a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content text-start">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Book</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="homes.php">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3">
                                                    <label class="form-label">Book Title</label>
                                                    <input type="text" name="title" class="form-control" value="<?php echo $row['title']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Author Name</label>
                                                    <input type="text" name="author" class="form-control" value="<?php echo $row['author']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Genre</label>
                                                    <input type="text" name="genre" class="form-control" value="<?php echo $row['genre']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Available Copies</label>
                                                    <input type="number" name="available_copies" class="form-control" value="<?php echo $row['available_copies']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="update_book" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No books found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>