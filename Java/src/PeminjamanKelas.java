
class PeminjamanKelas {
    private KetuaKelas peminjam;
    private String ruang;
    private String waktu;
    private String status;

    public PeminjamanKelas(KetuaKelas peminjam, String ruang, String waktu) {
        this.peminjam = peminjam;
        this.ruang = ruang;
        this.waktu = waktu;
        this.status = "Menunggu";
    }
    
    public String getRuang() {
        return ruang;
    }
    public void setStatus(String status) {
        this.status = status;
    }

    @Override
    public String toString() {
        return "Peminjam: " + peminjam.username + ", NIM: " + peminjam.getNim() + 
               ", Ruang: " + ruang + ", Waktu: " + waktu + ", Status: " + status;
    }
}