class Kelas {
    private String namaMataKuliah;
    private String namaDosen;
    private String jamMulai;
    private String jamSelesai;
    private String hari;

    public Kelas(String namaMataKuliah, String namaDosen, String jamMulai, String jamSelesai, String hari) {
        this.namaMataKuliah = namaMataKuliah;
        this.namaDosen = namaDosen;
        this.jamMulai = jamMulai;
        this.jamSelesai = jamSelesai;
        this.hari = hari;
    }

    public String getHari() {
        return hari;
    }

    @Override
    public String toString() {
        return hari + " "+  namaMataKuliah+ " : " + namaDosen + 
               ", Jam: " + jamMulai + "-" + jamSelesai;
    }
}
