import java.util.List;
import java.util.ArrayList;
import java.util.Comparator;
import java.util.Scanner;

class KetuaKelas extends User {
    private String nim;
    private List<PeminjamanKelas> peminjamanSaya;
    public List<Kelas> kelasList;
    public SistemLogin sistemLogin;

    public KetuaKelas(String username, String password, String nim, SistemLogin sistemLogin) {
        super(username, password, "ketua_kelas");
        this.sistemLogin = sistemLogin;
        this.nim = nim;
        peminjamanSaya = new ArrayList<>();
    }

    
    public void requestPeminjaman(Admin admin) {
        Scanner scanner = new Scanner(System.in);
        List<String> ruangKosong = admin.ruangKosong; 

        if (ruangKosong.isEmpty()) {
            System.out.println("Tidak ada ruang kosong yang tersedia.");
            return;
        }

        
        System.out.println("Ruang kosong yang tersedia:");
        for (int i = 0; i < ruangKosong.size(); i++) {
            System.out.println((i + 1) + ". " + ruangKosong.get(i));
        }

        
        System.out.print("Pilih nomor ruang yang ingin dipinjam: ");
        int ruangIndex = scanner.nextInt() - 1;
        scanner.nextLine();  

        if (ruangIndex < 0 || ruangIndex >= ruangKosong.size()) {
            System.out.println("Pilihan ruang tidak valid.");
            return;
        }

        String ruang = ruangKosong.get(ruangIndex);
        System.out.print("Masukkan waktu peminjaman: ");
        String waktu = scanner.nextLine();

        PeminjamanKelas peminjaman = new PeminjamanKelas(this, ruang, waktu);
        admin.tambahPeminjamanRequest(peminjaman); 
        peminjamanSaya.add(peminjaman);
        System.out.println("Request peminjaman terkirim untuk ruang: " + ruang);
    }

    
    public void lihatJadwalKelas() {
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

    
    @Override
    public void menu() {
        Scanner scanner = new Scanner(System.in);
        while (true) {
            System.out.println("\n--- Menu Ketua Kelas ---");
            System.out.println("1. Lihat Jadwal Kelas");
            System.out.println("2. Request Peminjaman Ruang");
            System.out.println("3. Logout");
            System.out.print("Pilih menu: ");
    
            int pilihan = scanner.nextInt();
            scanner.nextLine();
    
            switch (pilihan) {
                case 1:
                lihatJadwalKelas();
                break;
                case 2:
                   
                Admin admin = null;
                for (User user : sistemLogin.users) {
                    if (user instanceof Admin) {
                        admin = (Admin) user;
                        break;
                    }
                }
                
                // Pastikan Admin ditemukan
                if (admin != null) {
                    requestPeminjaman(admin); // Panggil requestPeminjaman dengan admin
                } else {
                    System.out.println("Admin tidak ditemukan.");
                }
                break;
                case 3:
                    return;
                default:
                    System.out.println("Pilihan tidak valid.");
            }
        }
    }
    

    public String getNim() {
        return nim;
    }
}