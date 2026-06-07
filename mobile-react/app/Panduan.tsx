import React, { useState } from 'react';
import { View, Text, StyleSheet, TouchableOpacity, ScrollView } from 'react-native';
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

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('input_data')}>
                    <Text style={styles.accordionTitle}>1. Cara Input Data Hasil Tangkap</Text>
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
                        
                        <View style={styles.imagePlaceholder}>
                            <Ionicons name="image-outline" size={40} color={COLORS.grayText} />
                            <Text style={styles.placeholderText}>[ Masukkan Screenshot Halaman Tambah Data ]</Text>
                        </View>
                    </View>
                )}

                <TouchableOpacity style={styles.accordionHeader} onPress={() => togglePanduan('revisi_data')}>
                    <Text style={styles.accordionTitle}>2. Cara Memperbaiki Data (Revisi)</Text>
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

                        <View style={styles.imagePlaceholder}>
                            <Ionicons name="image-outline" size={40} color={COLORS.grayText} />
                            <Text style={styles.placeholderText}>[ Masukkan Screenshot Kotak Catatan Revisi ]</Text>
                        </View>
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