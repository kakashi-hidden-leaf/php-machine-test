<?php
include 'db.php';
session_start();
$type = $_GET['type'] ?? 'pdf';
$result = $conn->query("select * from books");

require '../vendor/autoload.php';

$pdf = new TCPDF();
$pdf->AddPage();

$html = '<h2>Library Books</h2>
<table border="1" cellpadding="2">
    <tr>
        <th><b>ID</b></th>
        <th><b>Title</b></th>
        <th><b>Author</b></th>
        <th><b>Genre</b></th>
        <th><b>Available</b></th>
    </tr>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . $row['title'] . '</td>
        <td>' . $row['author'] . '</td>
        <td>' . $row['genre'] . '</td>
        <td>' . $row['available_copies'] . '</td>
    </tr>';
}

$html .= '</table>';

$pdf->writeHTML($html);
$pdf->Output('books.pdf', 'D');
?>