<?php
<<<<<<< HEAD
<<<<<<< HEAD
include 'database.php';
=======
include 'config/database.php';
>>>>>>> 693392c (login api)
=======
include 'database.php';
>>>>>>> 27ffbef (update role)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $pdo = connectDatabase();

        $sql = "SELECT * FROM dbo.[users] WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($password === $user['password']) {
<<<<<<< HEAD
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    } catch (PDOException $e) {
        echo "error";
    } finally {
        if (isset($pdo)) {
            $pdo = null;
        }
    }
} else {
    echo "error";
}
?>
=======
                session_start();
                $_SESSION['username'] = $username;
                header("Location: info.php");  // Redirect ke info.php jika login berhasil
                exit();
            } else {
                echo "Password salah.";
            }
        } else {
            echo "Username tidak ditemukan.";
        }
    } catch (PDOException $e) {
        echo "Kesalahan: " . $e->getMessage();
    }
}
?>
>>>>>>> 693392c (login api)
