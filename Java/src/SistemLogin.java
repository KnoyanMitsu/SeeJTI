import java.util.List;
import java.util.ArrayList;
import java.util.Scanner;

// Sistem Autentikasi
class SistemLogin {
    public List<User> users;
    public List<Kelas> kelasList; // Tambahkan daftar kelas

    public SistemLogin() {
        users = new ArrayList<>();
        kelasList = new ArrayList<>(); // Inisialisasi kelasList
        // users.add(new Admin("admin", "admin123", this));
    }

    public void tambahKelas(Kelas kelas) {
        kelasList.add(kelas); // Menambahkan kelas ke daftar kelas utama
    }

    public List<Kelas> getKelasList() {
        return kelasList; // Memberikan akses ke kelasList
    }

    public User login(String username, String password) {
        for (User user : users) {
            if (user.username.equals(username) && user.password.equals(password)) {
                return user;
            }
        }
        return null;
    }

    public void tambahUser(User user) {
        users.add(user);
    }
}

