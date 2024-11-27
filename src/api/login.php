<?php
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
include 'database.php';
=======
include 'config/database.php';
>>>>>>> 693392c (login api)
=======
include 'database.php';
>>>>>>> 27ffbef (update role)
=======
include 'config/database.php';
>>>>>>> 2ae0320 (Login dan ruang kosong)
=======
include 'config/database.php';
>>>>>>> c061aa4 (Login dan ruang kosong)

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
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2ae0320 (Login dan ruang kosong)
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
<<<<<<< HEAD
?>
=======
                session_start();
                $_SESSION['username'] = $username;
                header("Location: info.php");  // Redirect ke info.php jika login berhasil
                exit();
=======
                echo "success";
>>>>>>> c061aa4 (Login dan ruang kosong)
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
<<<<<<< HEAD
?>
>>>>>>> 693392c (login api)
=======
?>
>>>>>>> 2ae0320 (Login dan ruang kosong)
=======
?>
>>>>>>> c061aa4 (Login dan ruang kosong)
