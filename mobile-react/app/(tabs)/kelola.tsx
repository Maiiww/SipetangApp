import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';
import React, { useState } from 'react';
import {
    SafeAreaView,
    ScrollView,
    StatusBar,
    StyleSheet,
    Text,
    TouchableOpacity,
    View
} from 'react-native';

const COLORS = {
    primary: '#002D62',
    background: '#F5F7FA',
    white: '#FFFFFF',
    orange: '#FF6F20',
    yellow: '#FFC107', // Warna kuning untuk card produksi
    grayText: '#6B7280',
    lightGray: '#E5E7EB',
    border: '#D1D5DB',
    actionEdit: '#F59E0B',
    actionDelete: '#EF4444',
};

const tableData = [
  { id: '1', tanggal: '12 April 2026\n06:15', pembeli: 'Muhaimin', nelayan: 'Mamat', ikan: 'Tongkol', berat: '15.0', harga: '330.000' },
  { id: '2', tanggal: '12 April 2026\n09:00', pembeli: 'Karina', nelayan: 'Johan', ikan: 'Kembung', berat: '8.5', harga: '148.000' },
  { id: '3', tanggal: '11 April 2026\n07:30', pembeli: 'Maulana', nelayan: 'Kibo', ikan: 'Tuna', berat: '22.0', harga: '990.000' },
];

export default function KelolaScreen() {
 
    const [currentPage, setCurrentPage] = useState(1);

    const router = useRouter();

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
                {/* Card Total Berat */}
                <View style={[styles.summaryCard, { backgroundColor: COLORS.primary }]}>
                    <Text style={[styles.summaryLabel, { color: COLORS.lightGray }]}>TOTAL BERAT</Text>
                    <Text style={[styles.summaryValue, { color: COLORS.white }]}>500 <Text style={styles.summaryUnit}>KG</Text></Text>
                </View>

                <View style={[styles.summaryCard, { backgroundColor: COLORS.yellow }]}>
                    <Text style={[styles.summaryLabel, { color: COLORS.primary }]}>PRODUKSI HARI INI</Text>
                    <Text style={[styles.summaryValue, { color: COLORS.primary }]}>42</Text>
                </View>
                </View>

                <View style={styles.filterContainer}>
                    <TouchableOpacity style={styles.filterBox}>
                        <Text style={styles.filterText}>Jenis Ikan</Text>
                        <Ionicons name="chevron-down" size={18} color={COLORS.grayText} />
                    </TouchableOpacity>

                    <TouchableOpacity style={styles.filterBox}>
                        <Text style={styles.filterText}>Tanggal</Text>
                        <Ionicons name="calendar-outline" size={18} color={COLORS.grayText} />
                    </TouchableOpacity>
                </View>

                <View style={styles.tableWrapper}>
                    <ScrollView horizontal showsHorizontalScrollIndicator={true} style={styles.tableScroll}>
                        <View>
                        
                            <View style={styles.tableHeader}>
                                <Text style={[styles.thText, { width: 100 }]}>Tanggal &{"\n"}Waktu</Text>
                                <Text style={[styles.thText, { width: 120 }]}>Nama{"\n"}Pembeli</Text>
                                <Text style={[styles.thText, { width: 120 }]}>Nama{"\n"}Nelayan</Text>
                                <Text style={[styles.thText, { width: 100 }]}>Jenis Ikan</Text>
                                <Text style={[styles.thText, { width: 80 }]}>Berat{"\n"}(KG)</Text>
                                <Text style={[styles.thText, { width: 120 }]}>Total Harga{"\n"}(Rp)</Text>
                                <Text style={[styles.thText, { width: 80, textAlign: 'center' }]}>Aksi</Text>
                            </View>

                            {tableData.map((row, index) => (
                            <View key={row.id} style={styles.tableRow}>
                                <Text style={[styles.tdText, { width: 100, color: COLORS.grayText }]}>{row.tanggal}</Text>
                                <Text style={[styles.tdText, { width: 120, fontWeight: 'bold' }]}>{row.pembeli}</Text>
                                <Text style={[styles.tdText, { width: 120, fontWeight: 'bold' }]}>{row.nelayan}</Text>
                                <Text style={[styles.tdText, { width: 100, fontWeight: 'bold' }]}>{row.ikan}</Text>
                                <Text style={[styles.tdText, { width: 80 }]}>{row.berat}</Text>
                                <Text style={[styles.tdText, { width: 120, fontWeight: 'bold' }]}>{row.harga}</Text>
                                
                                
                                <View style={[styles.tdAction, { width: 80 }]}>
                                    <TouchableOpacity style={styles.actionBtn}>
                                    <MaterialCommunityIcons name="pencil-outline" size={20} color={COLORS.actionEdit} />
                                    </TouchableOpacity>
                                    <TouchableOpacity style={styles.actionBtn}>
                                    <MaterialCommunityIcons name="trash-can-outline" size={20} color={COLORS.actionDelete} />
                                    </TouchableOpacity>
                                </View>
                            </View>
                        ))}
                        </View>
                    </ScrollView>
                </View>

                <View style={styles.paginationContainer}>
                <TouchableOpacity style={styles.pageBtn}>
                    <Ionicons name="chevron-back" size={16} color={COLORS.grayText} />
                </TouchableOpacity>
                
                <TouchableOpacity style={[styles.pageBtn, styles.pageBtnActive]}>
                    <Text style={styles.pageTextActive}>1</Text>
                </TouchableOpacity>
                
                <TouchableOpacity style={styles.pageBtn}>
                    <Text style={styles.pageText}>2</Text>
                </TouchableOpacity>

                <TouchableOpacity style={styles.pageBtn}>
                    <Ionicons name="chevron-forward" size={16} color={COLORS.grayText} />
                </TouchableOpacity>
                </View>

            </ScrollView>

            {/* --- FLOATING ACTION BUTTON (FAB) --- */}
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
    filterContainer: {
        marginBottom: 20,
    },
    filterBox: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        backgroundColor: COLORS.white,
        borderWidth: 1,
        borderColor: COLORS.border,
        borderRadius: 8,
        paddingHorizontal: 15,
        paddingVertical: 12,
        marginBottom: 10,
    },
    filterText: {
        fontSize: 14,
        color: COLORS.grayText,
    },
    tableWrapper: {
        backgroundColor: COLORS.white,
        borderRadius: 12,
        overflow: 'hidden',
        borderWidth: 1,
        borderColor: COLORS.border,
        marginBottom: 20,
    },
    tableScroll: {
        // Agar scroll bar terlihat jelas
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