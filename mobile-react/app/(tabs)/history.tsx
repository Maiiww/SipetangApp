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
  StatusBar
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
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

    const renderCard = ({ item }: { item: RiwayatItem }) => {
        const isFailed = item.status === 'Ditolak';

        return (
            <View style={[
                styles.cardContainer, 
                { borderLeftColor: isFailed ? COLORS.error : COLORS.success }
            ]}>
                <View style={[
                    styles.iconBox, 
                    { backgroundColor: isFailed ? COLORS.errorBg : COLORS.successBg }
                ]}>
                    <Ionicons 
                        name={isFailed ? "close" : "checkmark"} 
                        size={24} 
                        color={isFailed ? COLORS.error : COLORS.success} 
                    />
                </View>

                <View style={styles.textContainer}>
                    <Text style={styles.titleText}>
                        {isFailed ? 'Gagal Input' : 'Berhasil Input'}
                    </Text>
                    <Text style={styles.descText}>
                        {isFailed 
                            ? `Gagal menambahkan ${item.jenis_ikan} sebesar ${item.berat}KG`
                            : `Menambahkan ${item.jenis_ikan} sebesar ${item.berat}KG`
                        }
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

    const displayData = activeTab === 'semua' 
        ? historyData.semua_riwayat 
        : historyData.perlu_revisi;

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