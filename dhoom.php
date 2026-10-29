
<?php
// Database connection details
$host = "localhost";
$dbname = "db2439648";
$username = "2439648";
$password = "39Kathmandu@";

try {
    // Connect to MySQL using PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // Retrieve all movies
    $sql = "SELECT Movie_name, Genre, Price, `Date of release`
            FROM movies
            ORDER BY Movie_id";

    $stmt = $pdo->query($sql);
    $movies = $stmt->fetchAll();

} catch (PDOException $e) {
    // Log technical details rather than exposing credentials
    error_log($e->getMessage());
    http_response_code(500);
    die("Database connection failed. Please check your database settings.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies Database</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #eee;
        }

        .message {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h1>Movies Database</h1>

    <table>
        <thead>
            <tr>
                <th>Movie name</th>
                <th>Genre</th>
                <th>Price</th>
                <th>Date of release</th>
            </tr>
        </thead>

        <tbody>
            <?php if (count($movies) > 0): ?>
                <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= htmlspecialchars($movie['Movie_name'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($movie['Genre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= '£' . number_format((float)$movie['Price'], 2) ?></td>
                        <td><?= date('d/m/Y', strtotime($movie['Date of release'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No movies found in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="message">
        Total movies: <?= count($movies) ?>
    </p>

</body>
</html>
