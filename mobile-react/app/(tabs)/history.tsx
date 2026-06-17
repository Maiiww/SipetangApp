import React, { useState, useCallback } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  FlatList,
  ActivityIndicator,
  Platform,
  StatusBar,
  TextInput,
  RefreshControl
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import DateTimePicker from '@react-native-community/datetimepicker';
import { useRouter, useFocusEffect, useLocalSearchParams } from 'expo-router';
import AsyncStorage from '@react-native-async-storage/async-storage';
import API_URL from '../../config';


const COLORS = {
  primary: '#002D62',
  background: '#F5F7FA',
  white: '#FFFFFF',
  success: '#10B981', 
  successBg: '#D1FAE5', 
  error: '#EF4444', 
  errorBg: '#FEE2E2', 
  grayText: '#6B7280',
  textDark: '#111827',
  badgeBg: '#F3F4F6',
};

interface RiwayatItem {
    id: number;
    status: string;
    jenis_ikan: string;
    berat: number | string; 
    created_at: string;
}

export default function HistoryScreen() {
    const router = useRouter();
    const [historyData, setHistoryData] = useState({ perlu_revisi: [], semua_riwayat: [] });
    const [loading, setLoading] = useState(true);
    const [activeTab, setActiveTab] = useState('semua');

    const [searchQuery, setSearchQuery] = useState('');
    const [filterDate, setFilterDate] = useState<Date | null>(null);
    const [showDatePicker, setShowDatePicker] = useState(false);

    const params = useLocalSearchParams();
    React.useEffect(() => {
        if (params.tab === 'revisi') {
            setActiveTab('revisi');
        }
    }, [params]);

    const getRelativeTime = (dateString: string) => {
        const date = new Date(dateString);
        const now = new Date();
        
        const diffInSeconds = Math.floor((now.getTime() - date.getTime()) / 1000);

        if (diffInSeconds < 60) return 'Baru saja';
        const diffInMinutes = Math.floor(diffInSeconds / 60);
        if (diffInMinutes < 60) return `${diffInMinutes} menit yang lalu`;
        const diffInHours = Math.floor(diffInMinutes / 60);
        if (diffInHours < 24) return `${diffInHours} jam yang lalu`;
        const diffInDays = Math.floor(diffInHours / 24);
        return `${diffInDays} hari yang lalu`;
    };

    const fetchHistory = async () => {
        setLoading(true);
        try {
            const userId = await AsyncStorage.getItem('user_id');
            const response = await fetch(`${API_URL}/tangkapan/riwayat?user_id=${userId}`);
            const textResponse = await response.text();
            console.log("ISI BALASAN DARI LARAVEL:", textResponse);
            const json = JSON.parse(textResponse);

            if (json.status === 'success') {
                setHistoryData(json.data);
            }
        } catch (error) {
            console.error("Gagal mengambil riwayat:", error);
        } finally {
            setLoading(false);
        }
    };

    useFocusEffect(
        useCallback(() => {
            fetchHistory();
        }, [])
    );

    const [refreshing, setRefreshing] = useState(false);

    const onRefresh = useCallback(async () => {
        setRefreshing(true);
        await fetchHistory();
        setRefreshing(false);
    }, []);

    const onDateChange = (event: any, selectedDate?: Date) => {
        setShowDatePicker(Platform.OS === 'ios');
        if (selectedDate) {
            setFilterDate(selectedDate);
        } else if (event.type === 'dismissed') {
            setShowDatePicker(false);
        }
    };
    
    const clearDateFilter = () => {
        setFilterDate(null);
    };

    const getStatusProps = (status: string) => {
        if (status === 'Ditolak') {
            return {
                color: COLORS.error,
                bgColor: COLORS.errorBg,
                icon: 'close' as const,
                title: 'Ditolak / Gagal',
                descPrefix: 'Gagal menambahkan'
            };
        }
        
        // Selain ditolak, semuanya hijau
        return {
            color: COLORS.success,
            bgColor: COLORS.successBg,
            icon: 'checkmark' as const,
            title: 'Berhasil Input',
            descPrefix: 'Menambahkan'
        };
    };

    const renderCard = ({ item }: { item: RiwayatItem }) => {
        const isFailed = item.status === 'Ditolak';
        const props = getStatusProps(item.status);

        return (
            <View style={[
                styles.cardContainer, 
                { borderLeftColor: props.color }
            ]}>
                <View style={[
                    styles.iconBox, 
                    { backgroundColor: props.bgColor }
                ]}>
                    <Ionicons 
                        name={props.icon} 
                        size={24} 
                        color={props.color} 
                    />
                </View>

                <View style={styles.textContainer}>
                    <Text style={styles.titleText}>
                        {props.title}
                    </Text>
                    <Text style={styles.descText}>
                        {props.descPrefix} {item.jenis_ikan} ({item.berat}KG)
                    </Text>
                    
                    {isFailed && (
                        <TouchableOpacity 
                            onPress={() => router.push({ 
                                pathname: '../EditData', 
                                params: { id_tangkapan: item.id } 
                            })}
                        >
                            <Text style={styles.repairText}>Perbaiki Sekarang {'>'}</Text>
                        </TouchableOpacity>
                    )}
                </View>

                <View style={styles.badgeContainer}>
                   <Text style={styles.timeText}>{getRelativeTime(item.created_at)}</Text>
                </View>
            </View>
        );
    };

    const baseData = activeTab === 'semua' 
        ? historyData.semua_riwayat 
        : historyData.perlu_revisi;

    const displayData = baseData.filter((item: RiwayatItem) => {
        const matchesSearch = item.jenis_ikan.toLowerCase().includes(searchQuery.toLowerCase()) || 
                              item.status.toLowerCase().includes(searchQuery.toLowerCase());
        
        let matchesDate = true;
        if (filterDate) {
            const itemDate = new Date(item.created_at);
            matchesDate = itemDate.getFullYear() === filterDate.getFullYear() &&
                          itemDate.getMonth() === filterDate.getMonth() &&
                          itemDate.getDate() === filterDate.getDate();
        }

        return matchesSearch && matchesDate;
    });

    return (
        <View style={styles.container}>
            <View style={styles.tabContainer}>
                <TouchableOpacity 
                    style={[styles.tabButton, activeTab === 'semua' && styles.activeTabButton]}
                    onPress={() => setActiveTab('semua')}
                >
                    <Text style={[styles.tabText, activeTab === 'semua' && styles.activeTabText]}>
                        Semua Riwayat
                    </Text>
                </TouchableOpacity>

                <TouchableOpacity 
                    style={[styles.tabButton, activeTab === 'revisi' && styles.activeTabButton]}
                    onPress={() => setActiveTab('revisi')}
                >
                    <Text style={[styles.tabText, activeTab === 'revisi' && styles.activeTabText]}>
                        Perlu Revisi ({historyData.perlu_revisi.length})
                    </Text>
                </TouchableOpacity>
            </View>

            {/* Filter Section */}
            <View style={styles.filterSection}>
                <View style={styles.searchContainer}>
                    <Ionicons name="search" size={20} color={COLORS.grayText} />
                    <TextInput
                        style={styles.searchInput}
                        placeholder="Cari jenis ikan atau status..."
                        value={searchQuery}
                        onChangeText={setSearchQuery}
                        placeholderTextColor={COLORS.grayText}
                    />
                    {searchQuery.length > 0 && (
                        <TouchableOpacity onPress={() => setSearchQuery('')}>
                            <Ionicons name="close-circle" size={20} color={COLORS.grayText} />
                        </TouchableOpacity>
                    )}
                </View>

                <View style={styles.dateFilterContainer}>
                    <TouchableOpacity 
                        style={[styles.dateButton, filterDate && styles.dateButtonActive]} 
                        onPress={() => setShowDatePicker(true)}
                    >
                        <Ionicons name="calendar" size={20} color={filterDate ? COLORS.white : COLORS.primary} />
                        <Text style={[styles.dateButtonText, filterDate && styles.dateButtonTextActive]}>
                            {filterDate ? filterDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : 'Pilih Tanggal'}
                        </Text>
                    </TouchableOpacity>
                    
                    {filterDate && (
                        <TouchableOpacity style={styles.clearDateButton} onPress={clearDateFilter}>
                            <Ionicons name="close" size={20} color={COLORS.error} />
                        </TouchableOpacity>
                    )}
                </View>

                {showDatePicker && (
                    <DateTimePicker
                        value={filterDate || new Date()}
                        mode="date"
                        display="default"
                        onChange={onDateChange}
                    />
                )}
            </View>

            {loading ? (
                <ActivityIndicator size="large" color={COLORS.primary} style={{marginTop: 50}} />
            ) : (
                <FlatList
                    data={displayData}
                    keyExtractor={(item) => item.id.toString()}
                    renderItem={renderCard}
                    contentContainerStyle={{ 
                        padding: 20,
                        paddingBottom: 100,
                    }}
                    ListEmptyComponent={
                        <Text style={styles.emptyText}>Tidak ada riwayat saat ini.</Text>
                    }
                    refreshControl={
                        <RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[COLORS.primary]} />
                    }
                />
            )}
        </View>
    );
}

const styles = StyleSheet.create({
    container: { 
        flex: 1, 
        backgroundColor: COLORS.background,
    },
    tabContainer: {
        flexDirection: 'row',
        paddingHorizontal: 20,
        paddingTop: 20,
        paddingBottom: 10,
        backgroundColor: COLORS.white,
        borderBottomWidth: 1,
        borderBottomColor: COLORS.badgeBg,
    },
    tabButton: {
        flex: 1,
        paddingVertical: 10,
        alignItems: 'center',
        borderBottomWidth: 2,
        borderBottomColor: 'transparent',
    },
    activeTabButton: {
        borderBottomColor: COLORS.primary,
    },
    tabText: {
        fontSize: 14,
        fontWeight: 'bold',
        color: COLORS.grayText,
    },
    activeTabText: {
        color: COLORS.primary,
    },
    filterSection: {
        padding: 20,
        backgroundColor: COLORS.background,
        paddingBottom: 0,
    },
    searchContainer: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: COLORS.white,
        borderRadius: 12,
        paddingHorizontal: 15,
        paddingVertical: 10,
        marginBottom: 10,
        borderWidth: 1,
        borderColor: COLORS.badgeBg,
    },
    searchInput: {
        flex: 1,
        marginLeft: 10,
        fontSize: 14,
        color: COLORS.textDark,
        paddingVertical: 0, 
    },
    dateFilterContainer: {
        flexDirection: 'row',
        alignItems: 'center',
    },
    dateButton: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: COLORS.white,
        borderWidth: 1,
        borderColor: COLORS.primary,
        borderRadius: 12,
        paddingHorizontal: 15,
        paddingVertical: 8,
    },
    dateButtonActive: {
        backgroundColor: COLORS.primary,
    },
    dateButtonText: {
        marginLeft: 8,
        color: COLORS.primary,
        fontWeight: '500',
        fontSize: 13,
    },
    dateButtonTextActive: {
        color: COLORS.white,
    },
    clearDateButton: {
        marginLeft: 10,
        backgroundColor: COLORS.errorBg,
        padding: 8,
        borderRadius: 12,
    },
    cardContainer: {
        flexDirection: 'row',
        backgroundColor: COLORS.white,
        borderRadius: 12,
        padding: 15,
        marginBottom: 15,
        borderLeftWidth: 6,
        elevation: 2,
        shadowColor: '#000',
        shadowOpacity: 0.05,
        shadowRadius: 4,
    },
    iconBox: { 
        width: 40, 
        height: 40, 
        borderRadius: 8, 
        justifyContent: 'center', 
        alignItems: 'center', 
        marginRight: 15 
    },
    textContainer: { 
        flex: 1, 
        justifyContent: 'center' 
    },
    titleText: { 
        fontWeight: 'bold', 
        fontSize: 16, 
        color: COLORS.textDark, 
        marginBottom: 4 
    },
    descText: { 
        fontSize: 13, 
        color: COLORS.grayText,
        lineHeight: 18,
    },
    repairText: { 
        fontSize: 13, 
        color: COLORS.error, 
        fontWeight: 'bold', 
        marginTop: 8 
    },
    badgeContainer: {
        position: 'absolute', 
        right: 15, 
        top: 15,
        backgroundColor: COLORS.badgeBg,
        paddingHorizontal: 8,
        paddingVertical: 4,
        borderRadius: 12,
    },
    timeText: { 
        fontSize: 11, 
        color: COLORS.grayText, 
        fontWeight: '500'
    },
    emptyText: { 
        textAlign: 'center', 
        marginTop: 50, 
        color: COLORS.grayText, 
        fontSize: 14 
    },
});