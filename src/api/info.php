<?php
include 'config/database.php';

try {
    $pdo = connectDatabase();

    $sql = "SELECT * FROM dbo.[users]"; // Perhatikan pembungkusan nama tabel dengan []
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Nama</th></tr>";

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id_user']) . "</td>";
            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
            echo "<td>" . htmlspecialchars($user['password']) . "</td>";
            echo "<td>" . htmlspecialchars($user['nama']) . "</td>";
            echo "<td>" . htmlspecialchars($user['level']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Tidak ada data ditemukan.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} finally {
    if (isset($pdo)) {
        $pdo = null;
    }
}
?>
