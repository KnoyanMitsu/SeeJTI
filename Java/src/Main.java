import java.util.List;
import java.util.ArrayList;
import java.util.Scanner;


public class Main {
    public static User currentUser ;
    public static Admin adminInstance;
    public static SistemLogin sistemLogin = new SistemLogin();

    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        SistemLogin sistemLogin = new SistemLogin();

        adminInstance = new Admin("admin", "admin123", sistemLogin);
        sistemLogin.tambahUser(adminInstance); 

        while (true) {
            System.out.println("\n--- Sistem Peminjaman Ruang ---");
            System.out.print("Username: ");
            String username = scanner.nextLine();
            System.out.print("Password: ");
            String password = scanner.nextLine();

            currentUser  = sistemLogin.login(username, password);
            if (currentUser  != null) {
                if (currentUser  instanceof Admin) {
                    ((Admin) currentUser ).menu();
                } else if (currentUser  instanceof KetuaKelas) {
                    ((KetuaKelas) currentUser ).menu();
                }
            } else {
                System.out.println("Login gagal, silakan coba lagi.");
            }
        }
    }
}