import React, { useState, useEffect } from 'react';
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
  Alert,
  ActivityIndicator,
  FlatList
} from 'react-native';
import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';
import AsyncStorage from '@react-native-async-storage/async-storage';
import API_URL from '../config';

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

export default function TambahDataScreen() {
    const router = useRouter();

    const [namaPembeli, setNamaPembeli] = useState('');
    const [namaNelayan, setNamaNelayan] = useState('');
    const [berat, setBerat] = useState('');
    const [jenisIkan, setJenisIkan] = useState('');
    const [harga, setHarga] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    // --- STATE CUSTOM POPUP ---
    const [popupVisible, setPopupVisible] = useState(false);
    const [popupType, setPopupType] = useState<'success' | 'offline' | 'error'>('success');
    const [popupMessage, setPopupMessage] = useState('');

    const [daftarIkanDinamis, setDaftarIkanDinamis] = useState<string[]>([]);

    useEffect(() => {
        const fetchDaftarIkan = async () => {
            try {
                const response = await fetch(`${API_URL}/ikan`); 
                const json = await response.json();
                
                if (json.status === 'success') {
                    setDaftarIkanDinamis(json.data);
                    // Simpan ke cache lokal untuk keperluan offline
                    await AsyncStorage.setItem('cached_ikan', JSON.stringify(json.data));
                }
            } catch (error) {
                console.log("Gagal memuat daftar ikan dari server, mencoba membaca dari cache lokal...", error);
                // Jika offline, ambil dari cache lokal
                try {
                    const cachedIkan = await AsyncStorage.getItem('cached_ikan');
                    if (cachedIkan) {
                        setDaftarIkanDinamis(JSON.parse(cachedIkan));
                    } else {
                        // Fallback data jika belum pernah buka online sama sekali
                        setDaftarIkanDinamis(['Kakap Merah', 'Kerapu', 'Tongkol', 'Tenggiri', 'Cumi-cumi', 'Udang']);
                    }
                } catch (e) {
                    console.log("Gagal membaca cache lokal");
                }
            }
        };

        fetchDaftarIkan();
    }, []);


    const [isDropdownVisible, setIsDropdownVisible] = useState(false);

    const handleSimpanData = async () => {
        if (!namaPembeli || !namaNelayan || !berat || !jenisIkan || !harga) {
            setPopupType('error');
            setPopupMessage('Pastikan semua kolom formulir telah diisi.');
            setPopupVisible(true);
            return;
        }

        setIsLoading(true);

        try {
            const storedUserId = await AsyncStorage.getItem('user_id');

            const activeUserId = storedUserId ? parseInt(storedUserId, 10) : 1; 

            const payload = {
                user_id: activeUserId,
                nama_pembeli: namaPembeli,
                nama_nelayan: namaNelayan,
                berat: parseFloat(berat), 
                jenis_ikan: jenisIkan,
                harga_jual: parseInt(harga.replace(/[^0-9]/g, ''), 10), 
            };

            let isOffline = false;

            try {
                // Coba kirim ke server
                const response = await fetch(`${API_URL}/tangkapan`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    setPopupType('success');
                    setPopupMessage('Data berhasil dikirim dan disimpan ke server!');
                    setPopupVisible(true);
                } else {
                    setPopupType('error');
                    setPopupMessage(data.message || 'Terjadi kesalahan di server.');
                    setPopupVisible(true);
                }
            } catch (networkError) {
                // Jika gagal koneksi, simpan secara offline
                console.log("Jaringan gagal, menyimpan secara offline...");
                isOffline = true;
                
                // Tambahkan field khusus untuk data offline
                const offlinePayload = {
                    ...payload,
                    id: 'offline_' + Date.now(), // ID sementara
                    created_at: new Date().toISOString(),
                    is_offline: true
                };

                // Ambil antrean offline sebelumnya
                const existingOfflineData = await AsyncStorage.getItem('offline_tangkapan');
                let offlineArray = existingOfflineData ? JSON.parse(existingOfflineData) : [];
                
                // Tambahkan data baru ke antrean
                offlineArray.push(offlinePayload);
                await AsyncStorage.setItem('offline_tangkapan', JSON.stringify(offlineArray));

                setPopupType('offline');
                setPopupMessage('Internet terputus. Data Anda diamankan di HP dan akan dikirim saat sinyal kembali.');
                setPopupVisible(true);
            }

        } catch (error) {
            setPopupType('error');
            setPopupMessage('Terjadi kesalahan pada sistem aplikasi.');
            setPopupVisible(true);
            console.log(error);
        } finally {
            setIsLoading(false);
        }
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
                <Text style={styles.inputLabel}>HARGA TERJUAL</Text>
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

            <TouchableOpacity 
                style={[styles.submitButton, isLoading && { opacity: 0.7 }]} 
                onPress={handleSimpanData}
                disabled={isLoading}
                >
                {isLoading ? (
                    <ActivityIndicator color={COLORS.white} />
                ) : (
                    <>
                        <MaterialCommunityIcons name="content-save-outline" size={20} color={COLORS.white} />
                        <Text style={styles.submitButtonText}>Simpan Data</Text>
                    </>
                )}
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
            onPress={() => setIsDropdownVisible(false)}
            >
            <View style={styles.modalContent}>
                <Text style={styles.modalTitle}>Pilih Jenis Ikan</Text>
                <FlatList
                data={daftarIkanDinamis}
                keyExtractor={(item, index) => index.toString()}
                style={{ flex: 1 }}
                showsVerticalScrollIndicator={true}
                contentContainerStyle={{ paddingBottom: 30 }}
                renderItem={({ item }) => {
                    
                    const namaIkan = item;

                    return (
                        <TouchableOpacity
                            style={styles.modalItem}
                            onPress={() => {
                                setJenisIkan(namaIkan);
                                setIsDropdownVisible(false);
                            }}
                        >
                            <Text style={styles.modalItemText}>{namaIkan}</Text>
                            
                            {jenisIkan === namaIkan && (
                                <Ionicons name="checkmark-circle" size={22} color="#002D62" />
                            )}
                        </TouchableOpacity>
                    );
                }}
            />

            </View>
            </TouchableOpacity>
        </Modal>

        {/* --- CUSTOM POPUP MODAL --- */}
        <Modal
            visible={popupVisible}
            transparent={true}
            animationType="fade"
            onRequestClose={() => {
                setPopupVisible(false);
                if (popupType !== 'error') router.back();
            }}
        >
            <View style={styles.popupOverlay}>
                <View style={styles.popupContent}>
                    {popupType === 'success' && (
                        <View style={[styles.popupIconBox, { backgroundColor: '#D1FAE5' }]}>
                            <Ionicons name="checkmark-circle" size={45} color="#059669" />
                        </View>
                    )}
                    {popupType === 'offline' && (
                        <View style={[styles.popupIconBox, { backgroundColor: '#F3F4F6' }]}>
                            <Ionicons name="cloud-offline" size={40} color="#6B7280" />
                        </View>
                    )}
                    {popupType === 'error' && (
                        <View style={[styles.popupIconBox, { backgroundColor: '#FEE2E2' }]}>
                            <Ionicons name="close-circle" size={45} color="#DC2626" />
                        </View>
                    )}
                    
                    <Text style={styles.popupTitle}>
                        {popupType === 'success' ? 'Tersimpan Online!' : 
                         popupType === 'offline' ? 'Tersimpan Offline!' : 'Gagal Menyimpan'}
                    </Text>
                    
                    <Text style={styles.popupMessage}>{popupMessage}</Text>
                    
                    <TouchableOpacity 
                        style={[styles.popupBtn, popupType === 'error' ? {backgroundColor: '#DC2626'} : {backgroundColor: COLORS.primary}]}
                        onPress={() => {
                            setPopupVisible(false);
                            if (popupType !== 'error') {
                                router.back();
                            }
                        }}
                    >
                        <Text style={styles.popupBtnText}>Oke, Mengerti</Text>
                    </TouchableOpacity>
                </View>
            </View>
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
        height: '70%',
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
    // --- STYLING CUSTOM POPUP ---
    popupOverlay: {
        flex: 1,
        backgroundColor: 'rgba(0,0,0,0.6)',
        justifyContent: 'center',
        alignItems: 'center',
    },
    popupContent: {
        width: '85%',
        backgroundColor: COLORS.white,
        borderRadius: 24,
        padding: 30,
        alignItems: 'center',
        elevation: 10,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 5 },
        shadowOpacity: 0.3,
        shadowRadius: 10,
    },
    popupIconBox: {
        width: 80,
        height: 80,
        borderRadius: 40,
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 20,
    },
    popupTitle: {
        fontSize: 20,
        fontWeight: 'bold',
        color: COLORS.primary,
        marginBottom: 10,
        textAlign: 'center',
    },
    popupMessage: {
        fontSize: 14,
        color: COLORS.grayText,
        textAlign: 'center',
        marginBottom: 25,
        lineHeight: 22,
    },
    popupBtn: {
        width: '100%',
        height: 50,
        borderRadius: 14,
        justifyContent: 'center',
        alignItems: 'center',
    },
    popupBtnText: {
        color: COLORS.white,
        fontWeight: 'bold',
        fontSize: 16,
        letterSpacing: 0.5,
    },
});
