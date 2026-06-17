import React, { useState } from 'react';
import { View, Text, StyleSheet, TouchableOpacity, ScrollView, Image } from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';

const COLORS = { 
    primary: '#002D62', 
    white: '#FFFFFF', 
    background: '#F5F7FA', 
    border: '#E5E7EB',
    grayText: '#6B7280',
    red: '#EF4444'
};

export default function PanduanScreen() {
    const router = useRouter();
    const [bukaPanduan, setBukaPanduan] = useState<string | null>(null);

    const togglePanduan = (id: string) => {
        setBukaPanduan(bukaPanduan === id ? null : id);
    };

    return (
        <ScrollView style={styles.container}>
            <View style={styles.header}>
                <TouchableOpacity onPress={() => router.back()} style={{ marginRight: 15 }}>
                    <Ionicons name="arrow-back" size={24} color={COLORS.white} />
                </TouchableOpacity>
                <Text style={styles.headerTitle}>Panduan Penggunaan</Text>
            </View>

            <View style={styles.content}>
                <Text style={styles.introText}>
                    Pilih topik bantuan di bawah ini untuk melihat langkah-langkah penggunaan aplikasi SIPETANG.
                </Text>

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('navigasi')}>
                    <Text style={styles.accordionTitle}>1. Pengenalan Menu Bawah (Navigasi)</Text>
                    <Ionicons name={bukaPanduan === 'navigasi' ? "chevron-up" : "chevron-down"} size={20} color={COLORS.primary} />
                </TouchableOpacity>
                
                {bukaPanduan === 'navigasi' && (
                    <View style={styles.accordionBody}>
                        <Text style={styles.descText}>
                            Di bagian bawah layar Anda, terdapat deretan tombol (Navbar) untuk berpindah halaman dengan cepat:
                        </Text>
                        <View style={styles.stepBox}>
                            <Text style={[styles.stepText, styles.boldText]}><Ionicons name="home-outline" size={14} color={COLORS.primary} /> Beranda (Home)</Text>
                            <Text style={[styles.stepText, {marginBottom: 15}]}>Halaman utama aplikasi. Di sini Anda bisa melihat: {"\n"}• Total tangkapan hari ini{"\n"}• Informasi cuaca laut dan suhu udara terkini{"\n"}• Grafik ringkasan tangkapan harian</Text>
                            
                            <Text style={[styles.stepText, styles.boldText]}><Ionicons name="bar-chart-outline" size={14} color={COLORS.primary} /> Kelola Data</Text>
                            <Text style={[styles.stepText, {marginBottom: 15}]}>Halaman operasional utama Anda. Digunakan untuk: {"\n"}• Mengisi form data tangkapan baru nelayan{"\n"}• Menyimpan dan mengirim laporan tangkapan ke dinas</Text>

                            <Text style={[styles.stepText, styles.boldText]}><Ionicons name="time-outline" size={14} color={COLORS.primary} /> Riwayat (History)</Text>
                            <Text style={[styles.stepText, {marginBottom: 15}]}>Halaman arsip data. Di sini Anda dapat: {"\n"}• Melihat seluruh data tangkapan yang pernah dikirim{"\n"}• Memantau status: Menunggu (Kuning), Disetujui (Hijau), Ditolak (Merah){"\n"}• Melakukan perbaikan (Revisi) jika data ditolak</Text>

                            <Text style={[styles.stepText, styles.boldText]}><Ionicons name="person-outline" size={14} color={COLORS.primary} /> Profil</Text>
                            <Text style={styles.stepText}>Halaman pengaturan akun Anda. Tersedia informasi: {"\n"}• Data diri Anda (Nama, Nomor Induk, Wilayah Tugas){"\n"}• Tombol aman untuk Keluar (Logout) dari aplikasi</Text>
                        </View>

                        {/* Gambar Navigasi Utama */}
                        <Image 
                            source={require('../assets/images/navbar.jpeg')} 
                            style={{ width: '100%', height: 80, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                    </View>
                )}

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('input_data')}>
                    <Text style={styles.accordionTitle}>2. Cara Input Data Hasil Tangkap</Text>
                    <Ionicons name={bukaPanduan === 'input_data' ? "chevron-up" : "chevron-down"} size={20} color={COLORS.primary} />
                </TouchableOpacity>
                
                {bukaPanduan === 'input_data' && (
                    <View style={styles.accordionBody}>
                        <Text style={styles.descText}>
                            Fitur ini digunakan untuk mencatat hasil tangkapan harian nelayan sebelum dikirim ke staf dinas.
                        </Text>
                        <View style={styles.stepBox}>
                            <Text style={styles.stepText}>1. Buka menu <Text style={styles.boldText}>Kelola Data</Text> di navigasi bawah.</Text>
                            <Text style={styles.stepText}>2. Tekan tombol <Text style={styles.boldText}>(+) berwarna biru</Text> di pojok kanan bawah layar.</Text>
                            <Text style={styles.stepText}>3. Isi lengkap form Nama Nelayan, Nama Pembeli, Berat, dan Total Harga.</Text>
                            <Text style={styles.stepText}>4. Tekan kotak <Text style={styles.boldText}>Pilih Jenis Ikan</Text> dan cari ikan yang sesuai.</Text>
                            <Text style={styles.stepText}>5. Terakhir, tekan tombol <Text style={styles.boldText}>Simpan Data</Text>.</Text>
                        </View>
                        
                        {/* Gambar Cara Input Data */}
                        <Image 
                            source={require('../assets/images/TambahData.jpeg')} 
                            style={{ width: '100%', height: 200, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                    </View>
                )}

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('revisi_data')}>
                    <Text style={styles.accordionTitle}>3. Cara Memperbaiki Data (Revisi)</Text>
                    <Ionicons name={bukaPanduan === 'revisi_data' ? "chevron-up" : "chevron-down"} size={20} color={COLORS.primary} />
                </TouchableOpacity>
                
                {bukaPanduan === 'revisi_data' && (
                    <View style={styles.accordionBody}>
                        <Text style={styles.descText}>
                            Jika data yang Anda kirim ditolak oleh staf dinas, Anda wajib melakukan perbaikan pada data tersebut.
                        </Text>
                        <View style={styles.stepBox}>
                            <Text style={styles.stepText}>1. Cek notifikasi berlambang lonceng di Beranda atau buka halaman <Text style={styles.boldText}>Riwayat</Text>.</Text>
                            <Text style={styles.stepText}>2. Cari data yang memiliki status <Text style={{color: COLORS.red, fontWeight: 'bold'}}>Ditolak</Text>.</Text>
                            <Text style={styles.stepText}>3. Tekan tombol <Text style={styles.boldText}>ikon pensil</Text> di sebelah data tersebut.</Text>
                            <Text style={styles.stepText}>4. Baca dengan teliti <Text style={styles.boldText}>Catatan Revisi</Text> berkotak merah muda dari staf.</Text>
                            <Text style={styles.stepText}>5. Ubah data yang salah, lalu tekan <Text style={styles.boldText}>Kirim Revisi</Text>.</Text>
                        </View>

                        {/* Gambar Revisi Data */}
                        <Image 
                            source={require('../assets/images/Editdata.jpeg')} 
                            style={{ width: '100%', height: 200, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                    </View>
                )}

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('status_laporan')}>
                    <Text style={styles.accordionTitle}>4. Memahami Arti Warna Status</Text>
                    <Ionicons name={bukaPanduan === 'status_laporan' ? "chevron-up" : "chevron-down"} size={20} color={COLORS.primary} />
                </TouchableOpacity>
                
                {bukaPanduan === 'status_laporan' && (
                    <View style={styles.accordionBody}>
                        <Text style={styles.descText}>
                            Di halaman Riwayat, setiap data tangkapan ditandai dengan warna status yang berbeda. Berikut artinya:
                        </Text>
                        <View style={styles.stepBox}>
                            <View style={{flexDirection: 'row', alignItems: 'center', marginBottom: 10}}>
                                <View style={{width: 12, height: 12, borderRadius: 6, backgroundColor: '#10B981', marginRight: 8}} />
                                <Text style={[styles.stepText, {marginBottom: 0}]}><Text style={{fontWeight: 'bold', color: '#047857'}}>Hijau (Berhasil Input):</Text> Laporan berhasil disimpan / disetujui dinas.</Text>
                            </View>
                            <View style={{flexDirection: 'row', alignItems: 'center'}}>
                                <View style={{width: 12, height: 12, borderRadius: 6, backgroundColor: COLORS.red, marginRight: 8}} />
                                <Text style={[styles.stepText, {marginBottom: 0}]}><Text style={{fontWeight: 'bold', color: '#B91C1C'}}>Merah (Ditolak):</Text> Laporan ada kesalahan dan butuh perbaikan (Revisi).</Text>
                            </View>
                        </View>

                        {/* Gambar Status Laporan */}
                        <Image 
                            source={require('../assets/images/Statushijau.jpeg')} 
                            style={{ width: '100%', height: 120, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                        <Image 
                            source={require('../assets/images/StatusMerah.jpeg')} 
                            style={{ width: '100%', height: 120, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                    </View>
                )}

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('tren_cuaca')}>
                    <Text style={styles.accordionTitle}>5. Memantau Tren & Cuaca</Text>
                    <Ionicons name={bukaPanduan === 'tren_cuaca' ? "chevron-up" : "chevron-down"} size={20} color={COLORS.primary} />
                </TouchableOpacity>
                
                {bukaPanduan === 'tren_cuaca' && (
                    <View style={styles.accordionBody}>
                        <Text style={styles.descText}>
                            Gunakan halaman Beranda untuk melihat cuaca laut dan tren hasil tangkapan.
                        </Text>
                        <View style={styles.stepBox}>
                            <Text style={styles.stepText}>1. Di halaman <Text style={styles.boldText}>Beranda</Text>, Anda bisa melihat ramalan cuaca, kecepatan angin, dan tinggi gelombang hari ini untuk pertimbangan keselamatan layar.</Text>
                            <Text style={styles.stepText}>2. Untuk melihat total ikan yang ditangkap, klik tombol <Text style={styles.boldText}>Tren Produksi</Text> di bawah bagian cuaca.</Text>
                            <Text style={styles.stepText}>3. Pada tabel Tren Produksi, Anda bisa menggunakan tombol <Text style={styles.boldText}>Tahun Ini</Text>, <Text style={styles.boldText}>Bulan Ini</Text>, atau <Text style={styles.boldText}>Bulan Lalu</Text> untuk memfilter data ikan.</Text>
                        </View>

                        {/* Gambar Cuaca dan Tren */}
                        <Image 
                            source={require('../assets/images/Detailcuaca.jpeg')} 
                            style={{ width: '100%', height: 200, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                        <Image 
                            source={require('../assets/images/TrenProduksi.jpeg')} 
                            style={{ width: '100%', height: 200, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                    </View>
                )}

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('profil_logout')}>
                    <Text style={styles.accordionTitle}>6. Pengaturan Profil & Logout</Text>
                    <Ionicons name={bukaPanduan === 'profil_logout' ? "chevron-up" : "chevron-down"} size={20} color={COLORS.primary} />
                </TouchableOpacity>
                
                {bukaPanduan === 'profil_logout' && (
                    <View style={styles.accordionBody}>
                        <Text style={styles.descText}>
                            Halaman Profil berisi identitas kerja Anda dan pengaturan akun.
                        </Text>
                        <View style={styles.stepBox}>
                            <Text style={styles.stepText}>• Buka halaman <Text style={styles.boldText}>Profil</Text> (ikon orang) untuk melihat Nama, NIK, dan Nama TPI tempat Anda ditugaskan.</Text>
                            <Text style={styles.stepText}>• Tekan tombol <Text style={styles.boldText}>Keluar / Logout</Text> jika Anda ingin meminjamkan HP ke petugas lain, atau jika Anda ingin mengganti akun.</Text>
                            <Text style={styles.stepText}>• Jangan lupa berikan izin Lokasi (GPS) saat diminta agar ramalan cuaca di Beranda semakin akurat!</Text>
                        </View>

                        {/* Gambar Profil */}
                        <Image 
                            source={require('../assets/images/Profile.jpeg')} 
                            style={{ width: '100%', height: 200, borderRadius: 8, marginTop: 10, resizeMode: 'contain' }}
                        />
                    </View>
                )}

            </View>
        </ScrollView>
    );
}

const styles = StyleSheet.create({
    container: { flex: 1, backgroundColor: COLORS.background },
    header: { flexDirection: 'row', alignItems: 'center', backgroundColor: COLORS.primary, paddingTop: 50, paddingBottom: 20, paddingHorizontal: 20 },
    headerTitle: { color: COLORS.white, fontSize: 18, fontWeight: 'bold' },
    content: { padding: 20 },
    introText: { fontSize: 13, color: COLORS.grayText, marginBottom: 20, lineHeight: 20 },
    
    accordionHeader: { flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center', backgroundColor: COLORS.white, padding: 15, borderRadius: 10, borderWidth: 1, borderColor: COLORS.border, marginBottom: 5 },
    accordionTitle: { fontWeight: 'bold', color: COLORS.primary, fontSize: 14, flex: 1 },
    accordionBody: { backgroundColor: COLORS.white, padding: 15, borderBottomLeftRadius: 10, borderBottomRightRadius: 10, borderWidth: 1, borderColor: COLORS.border, borderTopWidth: 0, marginBottom: 15 },
    
    descText: { fontSize: 13, color: '#4B5563', marginBottom: 15, lineHeight: 20 },
    stepBox: { backgroundColor: '#F9FAFB', padding: 12, borderRadius: 8, marginBottom: 15 },
    stepText: { fontSize: 13, color: '#374151', marginBottom: 8, lineHeight: 22 },
    boldText: { fontWeight: 'bold', color: COLORS.primary },
    
    imagePlaceholder: { height: 160, backgroundColor: '#F3F4F6', borderRadius: 8, justifyContent: 'center', alignItems: 'center', borderWidth: 1, borderColor: '#D1D5DB', borderStyle: 'dashed' },
    placeholderText: { color: COLORS.grayText, marginTop: 10, fontSize: 12 }
});