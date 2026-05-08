import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  SafeAreaView,
  StatusBar
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';

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

const historyData = [
  {
    id: '1',
    status: 'success',
    title: 'Berhasil Input',
    desc: 'Menambahkan Tuna 30 KG',
    time: 'Baru saja',
  },
  {
    id: '2',
    status: 'error',
    title: 'Gagal Input',
    desc: 'Gagal menambahkan Cakalang sebesar 40KG',
    time: '2 jam yang lalu',
  },
  {
    id: '3',
    status: 'success',
    title: 'Berhasil Input',
    desc: 'Menambahkan Cakalang sebesar 40KG',
    time: 'Baru saja',
  },
  {
    id: '4',
    status: 'success',
    title: 'Berhasil Input',
    desc: 'Menambahkan Tongkol sebesar 20KG',
    time: 'Baru saja',
  },
];

export default function HistoryScreen() {
    const router = useRouter();

    return (
        <SafeAreaView style={styles.container}>
            <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />

            
            <View style={styles.header}>
                {/* Tombol Back mengarah ke Beranda */}
                <TouchableOpacity style={styles.backButton} onPress={() => router.push('/(tabs)')}>
                <Ionicons name="arrow-back" size={24} color={COLORS.white} />
                </TouchableOpacity>
                <View>
                <Text style={styles.headerTitle}>Riwayat Produksi</Text>
                <Text style={styles.headerSubtitle}>SIPETANG</Text>
                </View>
            </View>

            <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
                
                
                {historyData.map((item) => {
                const isSuccess = item.status === 'success';

                return (
                    <View 
                    key={item.id} 
                    style={[
                        styles.card, 
                        // Dinamis: Warna border kiri berubah berdasarkan status
                        { borderLeftColor: isSuccess ? COLORS.success : COLORS.error }
                    ]}
                    >
                    
                    <View style={[
                        styles.iconBox, 
                        { backgroundColor: isSuccess ? COLORS.successBg : COLORS.errorBg }
                    ]}>
                        <Ionicons 
                        name={isSuccess ? "checkmark" : "close"} 
                        size={20} 
                        color={isSuccess ? COLORS.success : COLORS.error} 
                        />
                    </View>

                    
                    <View style={styles.cardContent}>
                        <View style={styles.cardHeader}>
                        <Text style={styles.cardTitle}>{item.title}</Text>
                        
                        
                        <View style={styles.timeBadge}>
                            <Text style={styles.timeText}>{item.time}</Text>
                        </View>
                        </View>
                        
                        <Text style={styles.cardDesc}>{item.desc}</Text>
                        
                
                        {!isSuccess && (
                        <TouchableOpacity onPress={() => console.log('Buka form perbaikan')}>
                            <Text style={styles.actionText}>Perbaiki Sekarang &gt;</Text>
                        </TouchableOpacity>
                        )}
                    </View>
                    </View>
                );
                })}

            </ScrollView>
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
        paddingBottom: 120, 
    },
    card: {
        flexDirection: 'row',
        backgroundColor: COLORS.white,
        borderRadius: 12,
        padding: 15,
        marginBottom: 15,
        borderLeftWidth: 4, 
        elevation: 2,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.05,
        shadowRadius: 4,
    },
    iconBox: {
        width: 40,
        height: 40,
        borderRadius: 10,
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 15,
    },
    cardContent: {
        flex: 1,
        justifyContent: 'center',
    },
    cardHeader: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: 5,
    },
    cardTitle: {
        fontSize: 14,
        fontWeight: 'bold',
        color: COLORS.textDark,
    },
    timeBadge: {
        backgroundColor: COLORS.badgeBg,
        paddingHorizontal: 8,
        paddingVertical: 3,
        borderRadius: 12,
    },
    timeText: {
        fontSize: 10,
        color: COLORS.grayText,
        fontWeight: '500',
    },
    cardDesc: {
        fontSize: 12,
        color: COLORS.grayText,
        lineHeight: 18,
    },
    actionText: {
        fontSize: 11,
        fontWeight: 'bold',
        color: COLORS.error,
        marginTop: 8,
    },
});