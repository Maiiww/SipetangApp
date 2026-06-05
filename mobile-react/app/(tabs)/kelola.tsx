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
    Alert,
    ActivityIndicator,
    Platform
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

    const fetchData = async (page = 1, dateObj = selectedDate) => {
        setIsLoading(true);
        try {
            const year = dateObj.getFullYear();
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const day = String(dateObj.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;

            const userId = await AsyncStorage.getItem('user_id');

            const response = await fetch(`${API_URL}/tangkapan?page=${page}&tanggal=${formattedDate}&user_id=${userId}`);
            const json = await response.json();

            if (response.ok && json.status === 'success') {
                setDataTangkapan(json.data.data);
                setCurrentPage(json.data.current_page);
                setTotalPages(json.data.last_page);

                setTotalBerat(json.statistik?.total_berat || 0);
                setTotalProduksi(json.statistik?.total_produksi || 0);
            }
        } catch (error) {
            Alert.alert('Error', 'Gagal terhubung ke server untuk mengambil data.');
        } finally {
            setIsLoading(false);
        }
    };

    useFocusEffect(
        useCallback(() => {
            fetchData(currentPage, selectedDate);
        }, [currentPage, selectedDate])
    );

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
        try {
            const formattedDate = selectedDate.toISOString().split('T')[0];
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
                Alert.alert('Sukses', json.message);
                fetchData(currentPage, selectedDate); 
            } else {
                Alert.alert('Peringatan', json.message || 'Gagal mengirim data.');
            }
        } catch (error) {
            Alert.alert('Error', 'Terjadi kesalahan jaringan.');
        }
    };

    return (
        <SafeAreaView style={styles.container}>
            <StatusBar barStyle="dark-content" backgroundColor={COLORS.background} />

            <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
           
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
                            Alert.alert(
                                'Kirim Laporan Harian',
                                `Apakah Anda yakin ingin mengirim data produksi tanggal ${selectedDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })} ke Staf Dinas untuk divalidasi? Data yang sudah dikirim tidak bisa diubah.`,
                                [
                                    { text: 'Batal', style: 'cancel' },
                                    { 
                                        text: 'Kirim Sekarang', 
                                        onPress: () => handleSendToStaff()
                                    }
                                ]
                            )
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
                                        
                                        <View style={[styles.tdAction, { width: 80 }]}>
                                            <TouchableOpacity 
                                                style={styles.actionBtn}
                                                onPress={() => router.push({ 
                                                    pathname: '../EditData',
                                                    params: { id_tangkapan: row.id }
                                                })}
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
});