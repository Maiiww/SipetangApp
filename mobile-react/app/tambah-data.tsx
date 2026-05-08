import React, { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  SafeAreaView,
  StatusBar,
  ScrollView,
  Modal,
  Alert
} from 'react-native';
import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';

const COLORS = {
    primary: '#002D62',
    background: '#F5F7FA',
    white: '#FFFFFF',
    orange: '#FF6F20',
    grayInput: '#E5E7EB', 
    grayText: '#6B7280',
    infoBg: '#E0F2FE', 
    infoText: '#0284C7',
};

const JENIS_IKAN_LIST = ['Tongkol', 'Udang', 'Cumi', 'Kembung', 'Tuna', 'Cakalang'];

export default function TambahDataScreen() {
    const router = useRouter();

    const [namaPembeli, setNamaPembeli] = useState('');
    const [namaNelayan, setNamaNelayan] = useState('');
    const [berat, setBerat] = useState('');
    const [jenisIkan, setJenisIkan] = useState('');
    const [harga, setHarga] = useState('');

    const [isDropdownVisible, setIsDropdownVisible] = useState(false);

    const handleSimpanData = () => {
        // 1. Validasi sederhana
        if (!namaPembeli || !namaNelayan || !berat || !jenisIkan || !harga) {
        Alert.alert('Gagal', 'Pastikan semua kolom formulir telah diisi.');
        return;
        }

        const payload = {
        nama_pembeli: namaPembeli,
        nama_nelayan: namaNelayan,
        jumlah_berat: parseFloat(berat),
        jenis_ikan: jenisIkan,
        harga_jual: parseInt(harga.replace(/[^0-9]/g, ''), 10), // Hanya ambil angkanya
        };

        console.log('Data yang akan dikirim ke DB:', payload);

        Alert.alert('Sukses', 'Data berhasil disimpan!', [
        { text: 'OK', onPress: () => router.back() }
        ]);

    };

    return (
        <SafeAreaView style={styles.container}>
        <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />

        {/* --- HEADER BIRU --- */}
        <View style={styles.header}>
            <TouchableOpacity style={styles.backButton} onPress={() => router.back()}>
            <Ionicons name="arrow-back" size={24} color={COLORS.white} />
            </TouchableOpacity>
            <View>
            <Text style={styles.headerTitle}>Input Data Produksi</Text>
            <Text style={styles.headerSubtitle}>SIPETANG</Text>
            </View>
        </View>

        <ScrollView contentContainerStyle={styles.scrollContent}>
            
            <View style={styles.formCard}>
            
            <View style={styles.inputGroup}>
                <Text style={styles.inputLabel}>NAMA PEMBELI</Text>
                <TextInput
                style={styles.textInput}
                placeholder="Masukkan nama pembeli"
                value={namaPembeli}
                onChangeText={setNamaPembeli}
                />
            </View>

            <View style={styles.inputGroup}>
                <Text style={styles.inputLabel}>NAMA NELAYAN</Text>
                <TextInput
                style={styles.textInput}
                placeholder="Masukkan nama nelayan"
                value={namaNelayan}
                onChangeText={setNamaNelayan}
                />
            </View>

            <View style={styles.inputGroup}>
                <Text style={styles.inputLabel}>JUMLAH BERAT</Text>
                <View style={styles.inputWithSuffix}>
                <TextInput
                    style={styles.inputFlex}
                    placeholder="0"
                    keyboardType="numeric"
                    value={berat}
                    onChangeText={setBerat}
                />
                <Text style={styles.suffixText}>KG</Text>
                </View>
            </View>

            <View style={styles.inputGroup}>
                <Text style={styles.inputLabel}>JENIS IKAN</Text>
                <TouchableOpacity 
                style={styles.dropdownButton}
                onPress={() => setIsDropdownVisible(true)}
                >
                <Text style={[styles.dropdownButtonText, !jenisIkan && { color: '#9CA3AF' }]}>
                    {jenisIkan || 'Pilih jenis ikan'}
                </Text>
                <Ionicons name="chevron-down" size={20} color={COLORS.grayText} />
                </TouchableOpacity>
            </View>

            <View style={styles.inputGroup}>
                <Text style={styles.inputLabel}>HARGA JUAL</Text>
                <View style={styles.inputWithPrefix}>
                <Text style={styles.prefixText}>Rp</Text>
                <TextInput
                    style={styles.inputFlex}
                    placeholder="0"
                    keyboardType="numeric"
                    value={harga}
                    onChangeText={setHarga}
                />
                </View>
            </View>

            <TouchableOpacity style={styles.submitButton} onPress={handleSimpanData}>
                <MaterialCommunityIcons name="content-save-outline" size={20} color={COLORS.white} />
                <Text style={styles.submitButtonText}>Simpan Data</Text>
            </TouchableOpacity>

            </View>

            <View style={styles.infoBox}>
            <Ionicons name="information-circle-outline" size={20} color={COLORS.infoText} />
            <Text style={styles.infoBoxText}>
                Data yang disimpan akan otomatis masuk ke laporan harian produksi TPI.
            </Text>
            </View>

        </ScrollView>

        <Modal
            visible={isDropdownVisible}
            transparent={true}
            animationType="fade"
            onRequestClose={() => setIsDropdownVisible(false)}
        >
            <TouchableOpacity 
            style={styles.modalOverlay} 
            activeOpacity={1} 
            onPress={() => setIsDropdownVisible(false)} // Tutup jika area luar di-klik
            >
            <View style={styles.modalContent}>
                <Text style={styles.modalTitle}>Pilih Jenis Ikan</Text>
                <ScrollView>
                {JENIS_IKAN_LIST.map((item, index) => (
                    <TouchableOpacity
                    key={index}
                    style={styles.modalItem}
                    onPress={() => {
                        setJenisIkan(item);
                        setIsDropdownVisible(false);
                    }}
                    >
                    <Text style={styles.modalItemText}>{item}</Text>
                    {jenisIkan === item && (
                        <Ionicons name="checkmark" size={20} color={COLORS.primary} />
                    )}
                    </TouchableOpacity>
                ))}
                </ScrollView>
            </View>
            </TouchableOpacity>
        </Modal>

        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: COLORS.background,
    },
    header: {
        backgroundColor: COLORS.primary,
        flexDirection: 'row',
        alignItems: 'center',
        paddingHorizontal: 20,
        paddingTop: 15,
        paddingBottom: 20,
    },
    backButton: {
        marginRight: 15,
    },
    headerTitle: {
        color: COLORS.white,
        fontSize: 16,
        fontWeight: 'bold',
    },
    headerSubtitle: {
        color: COLORS.white,
        fontSize: 10,
        opacity: 0.8,
        letterSpacing: 1,
    },
    scrollContent: {
        padding: 20,
    },
    formCard: {
        backgroundColor: COLORS.white,
        borderRadius: 16,
        padding: 20,
        marginBottom: 20,
        elevation: 2,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.05,
        shadowRadius: 5,
    },
    inputGroup: {
        marginBottom: 18,
    },
    inputLabel: {
        fontSize: 11,
        fontWeight: 'bold',
        color: '#374151',
        marginBottom: 8,
        letterSpacing: 0.5,
    },
    textInput: {
        backgroundColor: COLORS.grayInput,
        borderRadius: 8,
        paddingHorizontal: 15,
        height: 48,
        fontSize: 14,
        color: '#111827',
    },
    inputWithSuffix: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: COLORS.grayInput,
        borderRadius: 8,
        paddingHorizontal: 15,
        height: 48,
    },
    inputWithPrefix: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: COLORS.grayInput,
        borderRadius: 8,
        paddingHorizontal: 15,
        height: 48,
    },
    inputFlex: {
        flex: 1,
        fontSize: 14,
        color: '#111827',
    },
    suffixText: {
        fontSize: 14,
        color: COLORS.grayText,
        fontWeight: '600',
    },
    prefixText: {
        fontSize: 14,
        color: '#111827',
        fontWeight: 'bold',
        marginRight: 10,
    },
    dropdownButton: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        backgroundColor: COLORS.grayInput,
        borderRadius: 8,
        paddingHorizontal: 15,
        height: 48,
    },
    dropdownButtonText: {
        fontSize: 14,
        color: '#111827',
    },
    submitButton: {
        flexDirection: 'row',
        backgroundColor: COLORS.orange,
        height: 50,
        borderRadius: 8,
        justifyContent: 'center',
        alignItems: 'center',
        marginTop: 10,
    },
    submitButtonText: {
        color: COLORS.white,
        fontWeight: 'bold',
        fontSize: 16,
        marginLeft: 8,
    },
    infoBox: {
        flexDirection: 'row',
        backgroundColor: COLORS.infoBg,
        padding: 15,
        borderRadius: 8,
        borderWidth: 1,
        borderColor: '#BAE6FD',
        alignItems: 'flex-start',
    },
    infoBoxText: {
        flex: 1,
        marginLeft: 10,
        fontSize: 12,
        color: COLORS.infoText,
        lineHeight: 18,
    },
    // --- STYLING MODAL DROPDOWN ---
    modalOverlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.5)',
        justifyContent: 'center',
        alignItems: 'center',
    },
    modalContent: {
        width: '80%',
        backgroundColor: COLORS.white,
        borderRadius: 12,
        padding: 20,
        maxHeight: '60%', // Agar bisa di-scroll jika datanya banyak
    },
    modalTitle: {
        fontSize: 16,
        fontWeight: 'bold',
        color: COLORS.primary,
        marginBottom: 15,
        textAlign: 'center',
    },
    modalItem: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        paddingVertical: 15,
        borderBottomWidth: 1,
        borderBottomColor: COLORS.grayInput,
    },
    modalItemText: {
        fontSize: 14,
        color: '#111827',
    },
});
