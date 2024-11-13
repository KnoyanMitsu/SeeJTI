import java.util.ArrayList;
import java.util.Comparator;
import java.util.List;
import java.util.Scanner; 

public class Admin extends User {
    public List<Kelas> kelasList;
    public List<PeminjamanKelas> peminjamanRequests;
    public SistemLogin sistemLogin;
    public List<String> ruangKosong;

    public Admin(String username, String password, SistemLogin sistemLogin) {
        super(username, password, "admin");
        this.sistemLogin = sistemLogin;
        kelasList = new ArrayList<>();
        peminjamanRequests = new ArrayList<>();
        ruangKosong = new ArrayList<>();
    }

   
    public void tambahUser(User user) {
        sistemLogin.tambahUser(user); 
        System.out.println("User berhasil ditambahkan.");
    }

   
    
    public void tambahKelas() {
        Scanner scanner = new Scanner(System.in);

        
        String[] hariOptions = {"Senin", "Selasa", "Rabu", "Kamis", "Jumat"};
        System.out.println("Pilih hari (1-5):");
        for (int i = 0; i < hariOptions.length; i++) {
            System.out.println((i + 1) + ". " + hariOptions[i]);
        }
        int hariIndex = scanner.nextInt() - 1;
        scanner.nextLine();  
        if (hariIndex < 0 || hariIndex >= hariOptions.length) {
            System.out.println("Pilihan hari tidak valid.");
            return;
        }
        String hari = hariOptions[hariIndex];

        
        System.out.print("Masukkan nama mata kuliah: ");
        String namaMataKuliah = scanner.nextLine();
        
        System.out.print("Masukkan nama dosen: ");
        String namaDosen = scanner.nextLine();

        System.out.print("Masukkan jam mulai (HH:MM): ");
        String jamMulai = scanner.nextLine();

        System.out.print("Masukkan jam selesai (HH:MM): ");
        String jamSelesai = scanner.nextLine();

        
        Kelas kelasBaru = new Kelas(namaMataKuliah, namaDosen, jamMulai, jamSelesai, hari);
        sistemLogin.getKelasList().add(kelasBaru);  
        System.out.println("Kelas berhasil ditambahkan.");

       
    }

    public void tampilkanJadwal() {
        
        List<Kelas> kelasList = sistemLogin.getKelasList();

        kelasList.sort(Comparator.comparing(kelas -> {
            switch (kelas.getHari()) {
                case "Senin": return 1;
                case "Selasa": return 2;
                case "Rabu": return 3;
                case "Kamis": return 4;
                case "Jumat": return 5;
                default: return 6;
            }
        }));

        
        System.out.println("Jadwal Kelas:");
        for (Kelas kelas : kelasList) {
            System.out.println(kelas);
        }
    }
    public void tambahRuangKosong() {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Masukkan nama ruang kosong: ");
        String ruang = scanner.nextLine();
        ruangKosong.add(ruang);
        System.out.println("Ruang kosong berhasil ditambahkan: " + ruang);
    }

   
    public void prosesPeminjaman(int index, boolean setuju) {
        if (index < 0 || index >= peminjamanRequests.size()) {
            System.out.println("Indeks permintaan tidak valid.");
            return;
        }
        PeminjamanKelas request = peminjamanRequests.get(index);
        if (setuju) {
            request.setStatus("Disetujui");
            ruangKosong.remove(request.getRuang()); 
            System.out.println("Permintaan disetujui untuk ruang: " + request.getRuang());
        } else {
            request.setStatus("Ditolak");
            System.out.println("Permintaan ditolak untuk ruang: " + request.getRuang());
        }
        peminjamanRequests.remove(index); 
    }



    public void lihatPeminjamanRequest() {
        if (peminjamanRequests.isEmpty()) {
            System.out.println("Tidak ada permintaan peminjaman.");
            return;
        }
        for (int i = 0; i < peminjamanRequests.size(); i++) {
            System.out.println((i + 1) + ". " + peminjamanRequests.get(i));
        }
    }

    public void tambahPeminjamanRequest(PeminjamanKelas request) {
        peminjamanRequests.add(request);
    }

    public void lihatJadwalKelas() {
        if (kelasList.isEmpty()) {
            System.out.println("Tidak ada jadwal kelas yang tersedia.");
        } else {
            for (Kelas kelas : kelasList) {
                System.out.println(kelas);
            }
        }
    }

    public List<Kelas> getKelasList() {
        return kelasList;
    }

    @Override
    public void menu() {
        Scanner scanner = new Scanner(System.in);
        while (true) {
            System.out.println("\n--- Menu Admin ---");
            System.out.println("1. Tambah User");
            System.out.println("2. Tambah Kelas");
            System.out.println("3. Tambah ruang kosong");
            System.out.println("4. Lihat Request Peminjaman");
            System.out.println("5. Lihat Jadwal Kelas");
            System.out.println("6. Logout");
            System.out.print("Pilih menu: ");

            int pilihan = scanner.nextInt();
            scanner.nextLine();

            switch (pilihan) {
                case 1:
                    System.out.print("Username: ");
                    String username = scanner.nextLine();
                    System.out.print("Password: ");
                    String password = scanner.nextLine();
                    System.out.print("NIM: ");
                    String nim = scanner.nextLine();
                    tambahUser(new KetuaKelas(username, password, nim, sistemLogin));
                    break;
                case 2:
                    tambahKelas();
                    break;
                case 3:
                    tambahRuangKosong();
                    break;
                case 4:
                    lihatPeminjamanRequest();
                    break;
                case 5:
                    tampilkanJadwal();
                    break;
                case 6:
                    return;
                default:
                    System.out.println("Pilihan tidak valid.");
            }
        }
    }
}