import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import { useRouter, useFocusEffect } from 'expo-router';
import React, { useCallback, useState } from 'react';
import {
    SafeAreaView,
    ScrollView,
    StatusBar,
    StyleSheet,
    Text,
    TouchableOpacity,
    View,
    Modal,
    Alert,
    ActivityIndicator,
    Platform,
    RefreshControl
} from 'react-native';
import DateTimePicker from '@react-native-community/datetimepicker';
import AsyncStorage from '@react-native-async-storage/async-storage';
import API_URL from '../../config';

const COLORS = {
    primary: '#002D62',
    background: '#F5F7FA',
    white: '#FFFFFF',
    orange: '#FF6F20',
    yellow: '#FFC107', 
    grayText: '#6B7280',
    lightGray: '#E5E7EB',
    border: '#D1D5DB',
    actionEdit: '#F59E0B',
    actionDelete: '#EF4444',
    success: '#10B981', 
};

export default function KelolaScreen() {
 
    const router = useRouter();

    const [dataTangkapan, setDataTangkapan] = useState<any[]>([]);
    const [isLoading, setIsLoading] = useState(true);

    const [currentPage, setCurrentPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);

    const [totalBerat, setTotalBerat] = useState<number>(0);
    const [totalProduksi, setTotalProduksi] = useState<number>(0);

    const [selectedDate, setSelectedDate] = useState(new Date());
    const [showDatePicker, setShowDatePicker] = useState(false);

    // --- STATE CUSTOM POPUP ---
    const [popupVisible, setPopupVisible] = useState(false);
    const [popupType, setPopupType] = useState<'success' | 'offline' | 'error' | 'confirm'>('success');
    const [popupTitle, setPopupTitle] = useState('');
    const [popupMessage, setPopupMessage] = useState('');
    const [onConfirm, setOnConfirm] = useState<(() => void) | null>(null);

    const showPopup = (type: 'success' | 'offline' | 'error' | 'confirm', title: string, message: string, confirmAction: (() => void) | null = null) => {
        setPopupType(type);
        setPopupTitle(title);
        setPopupMessage(message);
        setOnConfirm(() => confirmAction);
        setPopupVisible(true);
    };

    const fetchData = async (page = 1, dateObj = selectedDate) => {
        setIsLoading(true);
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0');
        const day = String(dateObj.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;
        try {
            const userId = await AsyncStorage.getItem('user_id');

            // 1. Ambil offline data
            const existingOfflineData = await AsyncStorage.getItem('offline_tangkapan');
            let offlineArray = existingOfflineData ? JSON.parse(existingOfflineData) : [];
            
            // Filter offline data hanya untuk tanggal yang dipilih
            let filteredOffline = offlineArray.filter((item: any) => {
                const itemDate = new Date(item.created_at);
                const itemFormatted = `${itemDate.getFullYear()}-${String(itemDate.getMonth() + 1).padStart(2, '0')}-${String(itemDate.getDate()).padStart(2, '0')}`;
                return itemFormatted === formattedDate;
            });

            // Hitung berat offline
            let offlineBerat = 0;
            filteredOffline.forEach((item: any) => {
                offlineBerat += parseFloat(item.berat);
            });

            const response = await fetch(`${API_URL}/tangkapan?page=${page}&tanggal=${formattedDate}&user_id=${userId}`);
            const json = await response.json();

            if (response.ok && json.status === 'success') {
                // Gabungkan offline data di atas data online
                const combinedData = [...filteredOffline, ...json.data.data];
                setDataTangkapan(combinedData);
                setCurrentPage(json.data.current_page);
                setTotalPages(json.data.last_page);

                setTotalBerat((json.statistik?.total_berat || 0) + offlineBerat);
                setTotalProduksi((json.statistik?.total_produksi || 0) + filteredOffline.length);
            }
        } catch (error) {
            // Jika fetch API gagal (karena tidak ada sinyal internet)
            const existingOfflineData = await AsyncStorage.getItem('offline_tangkapan');
            let offlineArray = existingOfflineData ? JSON.parse(existingOfflineData) : [];
            let filteredOffline = offlineArray.filter((item: any) => {
                const itemDate = new Date(item.created_at);
                const itemFormatted = `${itemDate.getFullYear()}-${String(itemDate.getMonth() + 1).padStart(2, '0')}-${String(itemDate.getDate()).padStart(2, '0')}`;
                return itemFormatted === formattedDate;
            });
            
            let offlineBerat = 0;
            filteredOffline.forEach((item: any) => {
                offlineBerat += parseFloat(item.berat);
            });

            setDataTangkapan(filteredOffline);
            setTotalBerat(offlineBerat);
            setTotalProduksi(filteredOffline.length);
            setCurrentPage(1);
            setTotalPages(1);
        } finally {
            setIsLoading(false);
        }
    };

    useFocusEffect(
        useCallback(() => {
            fetchData(currentPage, selectedDate);
        }, [currentPage, selectedDate])
    );

    const syncOfflineData = async () => {
        try {
            const existingOfflineData = await AsyncStorage.getItem('offline_tangkapan');
            let offlineArray = existingOfflineData ? JSON.parse(existingOfflineData) : [];
            
            if (offlineArray.length === 0) return true; // nothing to sync

            let remainingOffline = [];
            let syncedCount = 0;

            for (let i = 0; i < offlineArray.length; i++) {
                const item = offlineArray[i];
                try {
                    // hapus is_offline dan id sementara sebelum kirim
                    const { is_offline, id, created_at, ...payload } = item;
                    
                    const response = await fetch(`${API_URL}/tangkapan`, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });
                    
                    if (response.ok) {
                        syncedCount++;
                    } else {
                        remainingOffline.push(item);
                    }
                } catch (e) {
                    remainingOffline.push(item);
                }
            }

            // update storage
            await AsyncStorage.setItem('offline_tangkapan', JSON.stringify(remainingOffline));
            
            if (syncedCount > 0) {
                showPopup('success', 'Sinkronisasi Sukses', `${syncedCount} data berhasil dikirim ke server.`);
            }

            return remainingOffline.length === 0;
        } catch (error) {
            return false;
        }
    };

    const [refreshing, setRefreshing] = useState(false);

    const onRefresh = useCallback(async () => {
        setRefreshing(true);
        await syncOfflineData();
        await fetchData(currentPage, selectedDate);
        setRefreshing(false);
    }, [currentPage, selectedDate]);

    const onChangeDate = (event: any, date?: Date) => {
        setShowDatePicker(Platform.OS === 'ios');
        if (date) {
            setSelectedDate(date);
            setCurrentPage(1);
        }
    };

    const formatRupiah = (angka: number | string) => {
        if (!angka) return 'Rp 0';
        const numerik = typeof angka === 'string' ? parseInt(angka, 10) : angka;
        return 'Rp ' + numerik.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    };

    const formatTanggal = (tanggalString: string) => {
        if (!tanggalString) return '-\n-';
        const date = new Date(tanggalString);
        const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        const tanggal = date.getDate().toString().padStart(2, '0');
        const bulan = bulanIndo[date.getMonth()];
        const tahun = date.getFullYear();
        const jam = date.getHours().toString().padStart(2, '0');
        const menit = date.getMinutes().toString().padStart(2, '0');
        return `${tanggal} ${bulan} ${tahun}\n${jam}:${menit}`;
    };

    const renderPaginationButtons = () => {
        let buttons = [];
        for (let i = 1; i <= totalPages; i++) {
            buttons.push(
                <TouchableOpacity 
                    key={i} 
                    style={[styles.pageBtn, currentPage === i && styles.pageBtnActive]}
                    onPress={() => setCurrentPage(i)}
                >
                    <Text style={currentPage === i ? styles.pageTextActive : styles.pageText}>{i}</Text>
                </TouchableOpacity>
            );
        }
        return buttons;
    };

    const handleSendToStaff = async () => {
        const hasOffline = dataTangkapan.some(item => item.is_offline);
        if (hasOffline) {
            showPopup('offline', 'Tunggu Sebentar', 'Masih ada data offline (abu-abu). Tarik layar ke bawah (Pull-to-Refresh) untuk menyinkronkan data ke server sebelum mengirim ke Staf.');
            return;
        }

        try {
            const year = selectedDate.getFullYear();
            const month = String(selectedDate.getMonth() + 1).padStart(2, '0');
            const day = String(selectedDate.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;

            const userId = await AsyncStorage.getItem('user_id');

            const response = await fetch(`${API_URL}/tangkapan/kirim`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tanggal: formattedDate,
                    user_id: userId
                }),
            });

            const json = await response.json();

            if (response.ok && json.status === 'success') {
                showPopup('success', 'Sukses Dikirim', json.message);
                fetchData(currentPage, selectedDate); 
            } else {
                showPopup('error', 'Gagal Mengirim', json.message || 'Gagal mengirim data ke staf.');
            }
        } catch (error) {
            showPopup('error', 'Error Jaringan', 'Terjadi kesalahan jaringan.');
        }
    };

    return (
        <SafeAreaView style={styles.container}>
            <StatusBar barStyle="dark-content" backgroundColor={COLORS.background} />

            <ScrollView 
                contentContainerStyle={styles.scrollContent} 
                showsVerticalScrollIndicator={false}
                refreshControl={
                    <RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[COLORS.primary]} />
                }
            >
           
                <View style={styles.header}>
                    <View>
                        <Text style={styles.headerTitle}>Data Hasil Tangkap</Text>
                        <Text style={styles.headerSubtitle}>SIPETANG</Text>
                    </View>
                    <TouchableOpacity>
                        <Ionicons name="search" size={24} color={COLORS.primary} />
                    </TouchableOpacity>
                </View>
                <Text style={styles.pageDescription}>Monitor data operasional harian perikanan.</Text>

                <View style={styles.cardRow}>
                    <View style={[styles.summaryCard, { backgroundColor: COLORS.primary }]}>
                        <Text style={[styles.summaryLabel, { color: COLORS.lightGray }]}>TOTAL BERAT</Text>
                        <Text style={[styles.summaryValue, { color: COLORS.white }]}>
                            {totalBerat} <Text style={styles.summaryUnit}>KG</Text>
                        </Text>
                    </View>

                    <View style={[styles.summaryCard, { backgroundColor: COLORS.yellow }]}>
                        <Text style={[styles.summaryLabel, { color: COLORS.primary }]}>TOTAL PRODUKSI</Text>
                        <Text style={[styles.summaryValue, { color: COLORS.primary }]}>{totalProduksi}</Text>
                    </View>
                </View>

                <View style={styles.actionRow}>
                    <View style={styles.filterGroup}>
                        {/* <TouchableOpacity style={styles.filterBox}>
                            <Text style={styles.filterText}>Jenis Ikan</Text>
                            <Ionicons name="chevron-down" size={16} color={COLORS.grayText} />
                        </TouchableOpacity> */}

                        <TouchableOpacity style={styles.filterBox} onPress={() => setShowDatePicker(true)}>
                            <Text style={styles.filterText}>
                                {selectedDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}
                            </Text>
                            <Ionicons name="calendar-outline" size={16} color={COLORS.grayText} />
                        </TouchableOpacity>
                    </View>

                    <TouchableOpacity 
                        style={[styles.printButton, { backgroundColor: '#3B82F6' }]} 
                        onPress={() => {
                            showPopup(
                                'confirm',
                                'Kirim Laporan Harian',
                                `Apakah Anda yakin ingin mengirim data produksi tanggal ${selectedDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })} ke Staf Dinas? Data yang sudah dikirim tidak bisa diubah.`,
                                () => handleSendToStaff()
                            );
                        }}
                    >
                        <Ionicons name="send-outline" size={18} color={COLORS.white} />
                        <Text style={styles.printButtonText}>Kirim ke Staf</Text>
                    </TouchableOpacity>
                </View>

                {showDatePicker && (
                    <DateTimePicker
                        value={selectedDate}
                        mode="date"
                        display="default"
                        onChange={onChangeDate}
                    />
                )}

                <View style={styles.tableWrapper}>
                    <ScrollView horizontal showsHorizontalScrollIndicator={true}>
                        <View>
                            <View style={styles.tableHeader}>
                                <Text style={[styles.thText, { width: 120 }]}>Tanggal &{"\n"}Waktu</Text>
                                <Text style={[styles.thText, { width: 120 }]}>Nama{"\n"}Pembeli</Text>
                                <Text style={[styles.thText, { width: 120 }]}>Nama{"\n"}Nelayan</Text>
                                <Text style={[styles.thText, { width: 100 }]}>Jenis Ikan</Text>
                                <Text style={[styles.thText, { width: 80 }]}>Berat{"\n"}(KG)</Text>
                                <Text style={[styles.thText, { width: 120 }]}>Total Harga{"\n"}(Rp)</Text>
                                <Text style={[styles.thText, { width: 100 }]}>Status</Text>
                                <Text style={[styles.thText, { width: 80, textAlign: 'center' }]}>Aksi</Text>
                            </View>

                            {isLoading ? (
                                <View style={{ padding: 30, alignItems: 'center' }}>
                                    <ActivityIndicator size="large" color={COLORS.primary} />
                                    <Text style={{ marginTop: 10, color: COLORS.grayText }}>Memuat data...</Text>
                                </View>
                            ) : dataTangkapan.length === 0 ? (
                                <View style={{ padding: 30, alignItems: 'center' }}>
                                    <Text style={{ color: COLORS.grayText }}>Belum ada tangkapan di tanggal ini.</Text>
                                </View>
                            ) : (
                                dataTangkapan.map((row) => (
                                    <View key={row.id.toString()} style={styles.tableRow}>
                                        <Text style={[styles.tdText, { width: 120, color: COLORS.grayText }]}>{formatTanggal(row.created_at)}</Text>
                                        <Text style={[styles.tdText, { width: 120, fontWeight: 'bold' }]}>{row.nama_pembeli}</Text>
                                        <Text style={[styles.tdText, { width: 120, fontWeight: 'bold' }]}>{row.nama_nelayan}</Text>
                                        <Text style={[styles.tdText, { width: 100, fontWeight: 'bold' }]}>{row.jenis_ikan}</Text>
                                        <Text style={[styles.tdText, { width: 80 }]}>{row.berat}</Text>
                                        <Text style={[styles.tdText, { width: 120, fontWeight: 'bold', color: COLORS.success }]}>{formatRupiah(row.harga_jual)}</Text>
                                        
                                        <View style={{ width: 100, justifyContent: 'center' }}>
                                            {row.is_offline ? (
                                                <View style={{ backgroundColor: '#E5E7EB', paddingHorizontal: 8, paddingVertical: 4, borderRadius: 12, alignSelf: 'flex-start' }}>
                                                    <Text style={{ fontSize: 10, color: '#6B7280', fontWeight: 'bold' }}>Offline</Text>
                                                </View>
                                            ) : (
                                                <View style={{ backgroundColor: '#D1FAE5', paddingHorizontal: 8, paddingVertical: 4, borderRadius: 12, alignSelf: 'flex-start' }}>
                                                    <Text style={{ fontSize: 10, color: '#059669', fontWeight: 'bold' }}>Tersimpan</Text>
                                                </View>
                                            )}
                                        </View>

                                        <View style={[styles.tdAction, { width: 80 }]}>
                                            <TouchableOpacity 
                                                style={styles.actionBtn}
                                                onPress={() => {
                                                    if (row.is_offline) {
                                                        showPopup('offline', 'Data Masih Offline', 'Data offline tidak bisa diedit. Harap sinkronisasi (tarik layar ke bawah) terlebih dahulu.');
                                                    } else {
                                                        router.push({ 
                                                            pathname: '../EditData',
                                                            params: { id_tangkapan: row.id }
                                                        });
                                                    }
                                                }}
                                            >
                                                <MaterialCommunityIcons name="pencil-outline" size={20} color={COLORS.actionEdit} />
                                            </TouchableOpacity>
                                        </View>
                                    </View>
                                ))
                            )}
                        </View>
                    </ScrollView>
                </View>

                {!isLoading && dataTangkapan.length > 0 && (
                    <View style={styles.paginationContainer}>
                        <TouchableOpacity 
                            style={[styles.pageBtn, currentPage === 1 && { opacity: 0.5 }]}
                            disabled={currentPage === 1}
                            onPress={() => setCurrentPage(currentPage - 1)}
                        >
                            <Ionicons name="chevron-back" size={16} color={COLORS.grayText} />
                        </TouchableOpacity>
                        
                        {renderPaginationButtons()}

                        <TouchableOpacity 
                            style={[styles.pageBtn, currentPage === totalPages && { opacity: 0.5 }]}
                            disabled={currentPage === totalPages}
                            onPress={() => setCurrentPage(currentPage + 1)}
                        >
                            <Ionicons name="chevron-forward" size={16} color={COLORS.grayText} />
                        </TouchableOpacity>
                    </View>
                )}

            </ScrollView>

            <TouchableOpacity 
                style={styles.fab}
                onPress={() => router.push('/tambah-data')} 
            >
                <Ionicons name="add" size={30} color={COLORS.white} />
            </TouchableOpacity>

            {/* --- CUSTOM POPUP MODAL --- */}
            <Modal
                visible={popupVisible}
                transparent={true}
                animationType="fade"
                onRequestClose={() => setPopupVisible(false)}
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
                        {popupType === 'confirm' && (
                            <View style={[styles.popupIconBox, { backgroundColor: '#DBEAFE' }]}>
                                <Ionicons name="help-circle" size={45} color="#2563EB" />
                            </View>
                        )}
                        
                        <Text style={styles.popupTitle}>{popupTitle}</Text>
                        <Text style={styles.popupMessage}>{popupMessage}</Text>
                        
                        {popupType === 'confirm' ? (
                            <View style={styles.popupBtnRow}>
                                <TouchableOpacity 
                                    style={[styles.popupBtnHalf, {backgroundColor: COLORS.lightGray}]}
                                    onPress={() => setPopupVisible(false)}
                                >
                                    <Text style={[styles.popupBtnText, {color: COLORS.grayText}]}>Batal</Text>
                                </TouchableOpacity>
                                <TouchableOpacity 
                                    style={[styles.popupBtnHalf, {backgroundColor: '#3B82F6'}]}
                                    onPress={() => {
                                        setPopupVisible(false);
                                        if (onConfirm) onConfirm();
                                    }}
                                >
                                    <Text style={styles.popupBtnText}>Kirim Sekarang</Text>
                                </TouchableOpacity>
                            </View>
                        ) : (
                            <TouchableOpacity 
                                style={[styles.popupBtn, popupType === 'error' ? {backgroundColor: '#DC2626'} : {backgroundColor: COLORS.primary}]}
                                onPress={() => setPopupVisible(false)}
                            >
                                <Text style={styles.popupBtnText}>Oke, Mengerti</Text>
                            </TouchableOpacity>
                        )}
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
    scrollContent: {
        padding: 20,
        paddingBottom: 100, 
    },
    header: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: 5,
    },
    headerTitle: {
        fontSize: 20,
        fontWeight: 'bold',
        color: COLORS.primary,
    },
    headerSubtitle: {
        fontSize: 10,
        fontWeight: 'bold',
        color: COLORS.primary,
        letterSpacing: 2,
        marginTop: -2,
    },
    pageDescription: {
        fontSize: 12,
        color: COLORS.grayText,
        marginBottom: 20,
    },
    cardRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        marginBottom: 20,
    },
    summaryCard: {
        flex: 1,
        padding: 15,
        borderRadius: 12,
        marginHorizontal: 5,
        elevation: 3,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.1,
        shadowRadius: 3,
    },
    summaryLabel: {
        fontSize: 10,
        fontWeight: 'bold',
        marginBottom: 8,
    },
    summaryValue: {
        fontSize: 26,
        fontWeight: 'bold',
    },
    summaryUnit: {
        fontSize: 14,
        fontWeight: 'bold',
    },
    
    // STYLE FILTER & CETAK BUTTON
    actionRow: {
        flexDirection: 'column',
        marginBottom: 15,
    },
    filterGroup: {
        flexDirection: 'row',
        justifyContent: 'flex-start',
        marginBottom: 10,
    },
    filterBox: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        backgroundColor: COLORS.white,
        borderWidth: 1,
        borderColor: COLORS.border,
        borderRadius: 8,
        paddingHorizontal: 12,
        paddingVertical: 10,
        marginRight: 10,
        width: 120,
    },
    filterText: {
        fontSize: 12,
        color: COLORS.grayText,
    },
    printButton: {
        flexDirection: 'row',
        backgroundColor: COLORS.success,
        paddingVertical: 12,
        paddingHorizontal: 15,
        borderRadius: 8,
        alignItems: 'center',
        justifyContent: 'center',
        elevation: 2,
    },
    printButtonText: {
        color: COLORS.white,
        fontWeight: 'bold',
        fontSize: 14,
        marginLeft: 8,
    },
    /* ----------------------------------------------- */

    tableWrapper: {
        backgroundColor: COLORS.white,
        borderRadius: 12,
        overflow: 'hidden',
        borderWidth: 1,
        borderColor: COLORS.border,
        marginBottom: 20,
    },
    tableHeader: {
        flexDirection: 'row',
        backgroundColor: COLORS.primary,
        paddingVertical: 12,
        paddingHorizontal: 10,
    },
    thText: {
        color: COLORS.white,
        fontSize: 12,
        fontWeight: 'bold',
        marginRight: 10,
    },
    tableRow: {
        flexDirection: 'row',
        paddingVertical: 15,
        paddingHorizontal: 10,
        borderBottomWidth: 1,
        borderBottomColor: COLORS.lightGray,
        alignItems: 'center',
    },
    tdText: {
        fontSize: 12,
        color: COLORS.primary,
        marginRight: 10,
    },
    tdAction: {
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
    },
    actionBtn: {
        marginHorizontal: 5,
    },
    paginationContainer: {
        flexDirection: 'row',
        justifyContent: 'center',
        alignItems: 'center',
        marginBottom: 20,
    },
    pageBtn: {
        backgroundColor: COLORS.white,
        width: 35,
        height: 35,
        borderRadius: 8,
        justifyContent: 'center',
        alignItems: 'center',
        marginHorizontal: 5,
        borderWidth: 1,
        borderColor: COLORS.border,
    },
    pageBtnActive: {
        backgroundColor: COLORS.yellow,
        borderColor: COLORS.yellow,
    },
    pageText: {
        color: COLORS.grayText,
        fontWeight: 'bold',
    },
    pageTextActive: {
        color: COLORS.primary,
        fontWeight: 'bold',
    },
    fab: {
        position: 'absolute',
        right: 20,
        bottom: 90, 
        backgroundColor: COLORS.primary,
        width: 60,
        height: 60,
        borderRadius: 30,
        justifyContent: 'center',
        alignItems: 'center',
        elevation: 8,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 4 },
        shadowOpacity: 0.3,
        shadowRadius: 5,
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
    popupBtnRow: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        width: '100%',
    },
    popupBtnHalf: {
        width: '48%',
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