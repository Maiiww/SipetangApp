import React, { useState, useEffect } from 'react';
import { 
    View, Text, TextInput, TouchableOpacity, StyleSheet, 
    ScrollView, ActivityIndicator, Alert, Modal, FlatList
} from 'react-native';
import { useLocalSearchParams, useRouter } from 'expo-router';
import { Ionicons } from '@expo/vector-icons';
import API_URL from '../config';


export default function EditDataScreen() {
    const router = useRouter();
    const params = useLocalSearchParams();
    
    const [loading, setLoading] = useState(true);
    const [isSaving, setIsSaving] = useState(false);
    const [catatanStaf, setCatatanStaf] = useState('');


    const [namaPembeli, setNamaPembeli] = useState('');
    const [namaNelayan, setNamaNelayan] = useState('');
    const [jenisIkan, setJenisIkan] = useState('');
    const [berat, setBerat] = useState('');
    const [harga, setHarga] = useState('');

    const [daftarIkanDinamis, setDaftarIkanDinamis] = useState([]);

    useEffect(() => {
        const fetchDaftarIkan = async () => {
            try {
                const response = await fetch(`${API_URL}/ikan`);
                const json = await response.json();
                
                if (json.status === 'success') {
                    setDaftarIkanDinamis(json.data);
                }
            } catch (error) {
                console.log("Gagal memuat daftar ikan di Edit Data:", error);
            }
        };

        fetchDaftarIkan();
    }, []);

    const [modalIkanVisible, setModalIkanVisible] = useState(false);

    useEffect(() => {
        if (params.id_tangkapan) {
            fetchDetailData();
        }
    }, [params.id_tangkapan]);

    const fetchDetailData = async () => {
        try {
            const response = await fetch(`${API_URL}/tangkapan/${params.id_tangkapan}`);
            const json = await response.json();
            
            if (json.status === 'success') {
                const data = json.data;
                setNamaPembeli(data.nama_pembeli || '');
                setNamaNelayan(data.nama_nelayan || '');
                setJenisIkan(data.jenis_ikan || '');
                setBerat(data.berat ? data.berat.toString() : '');
                setHarga(data.harga_jual ? data.harga_jual.toString() : '');
                setCatatanStaf(data.catatan || 'Tidak ada catatan khusus dari staf.');
            }
        } catch (error) {
            Alert.alert("Error", "Gagal mengambil data dari server.");
        } finally {
            setLoading(false);
        }
    };

    const handleSimpanRevisi = async () => {
        if (!jenisIkan || !berat || !harga || !namaPembeli || !namaNelayan) {
            Alert.alert("Perhatian", "Semua kolom wajib diisi!");
            return;
        }

        setIsSaving(true);
        try {
            const response = await fetch(`${API_URL}/tangkapan/${params.id_tangkapan}`, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nama_pembeli: namaPembeli,
                    nama_nelayan: namaNelayan,
                    jenis_ikan: jenisIkan,
                    berat: parseFloat(berat),
                    harga_jual: parseFloat(harga)
                })
            });

            const json = await response.json();

            if (json.status === 'success') {
                Alert.alert("Berhasil!", "Data telah direvisi dan dikembalikan ke Staf.", [
                    { text: "OK", onPress: () => router.back() }
                ]);
            } else {
                Alert.alert("Gagal", json.message || "Gagal menyimpan revisi.");
            }
        } catch (error) {
            Alert.alert("Error", "Gagal terhubung ke server.");
        } finally {
            setIsSaving(false);
        }
    };

    if (loading) {
        return (
            <View style={styles.centerContainer}>
                <ActivityIndicator size="large" color="#002D62" />
                <Text style={{marginTop: 10, color: '#666'}}>Memuat Data...</Text>
            </View>
        );
    }

    return (
        <View style={styles.container}>
            <ScrollView showsVerticalScrollIndicator={false} contentContainerStyle={styles.scrollContent}>
                
                <Text style={styles.headerTitle}>Formulir Perbaikan Data</Text>
                <Text style={styles.subTitle}>Silakan perbaiki data sesuai catatan staf</Text>
                
                <View style={styles.warningBox}>
                    <Ionicons name="information-circle" size={24} color="#C53030" />
                    <View style={styles.warningTextContainer}>
                        <Text style={styles.warningTitle}>Catatan Revisi:</Text>
                        <Text style={styles.warningDesc}>{catatanStaf}</Text>
                    </View>
                </View>

                <View style={styles.cardForm}>
                    <View style={styles.formGroup}>
                        <Text style={styles.label}>Nama Nelayan</Text>
                        <TextInput style={styles.input} value={namaNelayan} onChangeText={setNamaNelayan} placeholder="Masukkan nama nelayan" />
                    </View>

                    <View style={styles.formGroup}>
                        <Text style={styles.label}>Nama Pembeli</Text>
                        <TextInput style={styles.input} value={namaPembeli} onChangeText={setNamaPembeli} placeholder="Masukkan nama pembeli" />
                    </View>

                    <View style={styles.formGroup}>
                        <Text style={styles.label}>Jenis Ikan</Text>
                        <TouchableOpacity 
                            style={styles.dropdownButton} 
                            onPress={() => setModalIkanVisible(true)}
                        >
                            <Text style={[styles.dropdownText, !jenisIkan && {color: '#9CA3AF'}]}>
                                {jenisIkan || "Pilih Jenis Ikan"}
                            </Text>
                            <Ionicons name="chevron-down" size={20} color="#6B7280" />
                        </TouchableOpacity>
                    </View>

                    <View style={styles.rowGroup}>
                        <View style={[styles.formGroup, {flex: 1, marginRight: 10}]}>
                            <Text style={styles.label}>Berat (Kg)</Text>
                            <TextInput style={styles.input} value={berat} onChangeText={setBerat} keyboardType="numeric" placeholder="0" />
                        </View>

                        <View style={[styles.formGroup, {flex: 1}]}>
                            <Text style={styles.label}>Total Harga (Rp)</Text>
                            <TextInput style={styles.input} value={harga} onChangeText={setHarga} keyboardType="numeric" placeholder="0" />
                        </View>
                    </View>
                </View>

                {/* Tombol Simpan */}
                <TouchableOpacity 
                    style={[styles.submitBtn, isSaving && {opacity: 0.7}]} 
                    onPress={handleSimpanRevisi}
                    disabled={isSaving}
                >
                    <Ionicons name="paper-plane" size={20} color="#FFF" style={{marginRight: 10}} />
                    <Text style={styles.submitText}>
                        {isSaving ? 'Mengirim Data...' : 'Kirim Revisi'}
                    </Text>
                </TouchableOpacity>

            </ScrollView>

            <Modal visible={modalIkanVisible} transparent={true} animationType="fade">
                <View style={styles.modalOverlay}>
                    <View style={styles.modalContent}>
                        <View style={styles.modalHeader}>
                            <Text style={styles.modalTitle}>Pilih Jenis Ikan</Text>
                            <TouchableOpacity onPress={() => setModalIkanVisible(false)}>
                                <Ionicons name="close" size={24} color="#333" />
                            </TouchableOpacity>
                        </View>
                        
                        <FlatList
                            data={daftarIkanDinamis}
                            keyExtractor={(item, index) => index.toString()}
                            renderItem={({ item }) => {
                                const namaIkan = item;

                                return (
                                    <TouchableOpacity 
                                        style={styles.modalItem}
                                        onPress={() => {
                                            setJenisIkan(namaIkan);
                                            setModalIkanVisible(false);
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
                </View>
            </Modal>
        </View>
    );
}

const styles = StyleSheet.create({
    container: { flex: 1, backgroundColor: '#F5F7FA' },
    scrollContent: { padding: 20, paddingBottom: 50 },
    centerContainer: { flex: 1, justifyContent: 'center', alignItems: 'center' },
    
    headerTitle: { fontSize: 22, fontWeight: 'bold', color: '#002D62', marginBottom: 4, marginTop: 10 },
    subTitle: { fontSize: 13, color: '#6B7280', marginBottom: 20 },
    
    warningBox: {
        flexDirection: 'row', backgroundColor: '#FEF2F2', padding: 15, 
        borderRadius: 12, marginBottom: 20, alignItems: 'flex-start',
        borderWidth: 1, borderColor: '#FECACA'
    },
    warningTextContainer: { marginLeft: 12, flex: 1 },
    warningTitle: { fontSize: 14, fontWeight: 'bold', color: '#991B1B', marginBottom: 4 },
    warningDesc: { fontSize: 13, color: '#7F1D1D', lineHeight: 20 },

    cardForm: {
        backgroundColor: '#FFFFFF',
        borderRadius: 15,
        padding: 20,
        elevation: 2,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 1 },
        shadowOpacity: 0.1,
        shadowRadius: 3,
        marginBottom: 20
    },
    formGroup: { marginBottom: 16 },
    rowGroup: { flexDirection: 'row' },
    label: { fontSize: 13, fontWeight: 'bold', color: '#374151', marginBottom: 8 },
    input: { 
        backgroundColor: '#F9FAFB', borderWidth: 1, borderColor: '#E5E7EB', 
        borderRadius: 10, padding: 12, fontSize: 15, color: '#111827' 
    },
    
    dropdownButton: {
        flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center',
        backgroundColor: '#F9FAFB', borderWidth: 1, borderColor: '#E5E7EB', 
        borderRadius: 10, padding: 12
    },
    dropdownText: { fontSize: 15, color: '#111827' },

    submitBtn: { 
        backgroundColor: '#002D62', padding: 16, borderRadius: 12, 
        flexDirection: 'row', justifyContent: 'center', alignItems: 'center',
        elevation: 2, shadowColor: '#000', shadowOffset: { width: 0, height: 2 }, shadowOpacity: 0.2, shadowRadius: 3,
    },
    submitText: { color: '#FFF', fontSize: 16, fontWeight: 'bold' },

    modalOverlay: {
        flex: 1, backgroundColor: 'rgba(0,0,0,0.5)', 
        justifyContent: 'flex-end'
    },
    modalContent: {
        backgroundColor: '#FFF', borderTopLeftRadius: 20, borderTopRightRadius: 20,
        padding: 20, maxHeight: '60%'
    },
    modalHeader: {
        flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center',
        borderBottomWidth: 1, borderBottomColor: '#F3F4F6', paddingBottom: 15, marginBottom: 10
    },
    modalTitle: { fontSize: 18, fontWeight: 'bold', color: '#111827' },
    modalItem: {
        flexDirection: 'row', justifyContent: 'space-between', alignItems: 'center',
        paddingVertical: 15, borderBottomWidth: 1, borderBottomColor: '#F9FAFB'
    },
    modalItemText: { fontSize: 16, color: '#374151' }
});