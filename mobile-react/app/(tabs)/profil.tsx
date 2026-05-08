import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  SafeAreaView,
  StatusBar,
  ScrollView,
  Image,
  Alert
} from 'react-native';
import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';
import { useAuth } from '../../components/AuthContext';

const COLORS = {
  primary: '#002D62',
  background: '#F5F7FA',
  white: '#FFFFFF',
  orange: '#FF6F20',
  textDark: '#111827',
  grayText: '#6B7280',
  lightGray: '#E5E7EB',
  badgeBg: '#BAE6FD', 
  badgeText: '#0284C7',
  iconBg: '#F0F9FF', 
  success: '#10B981', 
};

export default function ProfilScreen() {
    const router = useRouter();
    const { signOut } = useAuth();

    const userData = {
        nama: 'IMAM ARIFIN',
        role: 'JURU REKAP',
        idRekap: 'JR04',
        telepon: '0895346788823',
        wilayah: 'TPI Blanakan',
        status: 'Aktif',
        avatar: 'https://randomuser.me/api/portraits/men/32.jpg', 
    };

    // --- FUNGSI LOGOUT ---
    const handleLogout = () => {
        Alert.alert(
        "Konfirmasi Keluar",
        "Apakah Anda yakin ingin keluar dari aplikasi?",
        [
            { text: "Batal", style: "cancel" },
            { 
            text: "Keluar", 
            style: "destructive",
            onPress: () => {
                signOut();
                router.replace('/login');
            }
            }
        ]
        );
    };

    return (
        <SafeAreaView style={styles.container}>
            <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />

            <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
                
                {/* --- HEADER --- */}
                <View style={styles.header}>
                <TouchableOpacity style={styles.backButton} onPress={() => router.push('/(tabs)')}>
                    <Ionicons name="arrow-back" size={24} color={COLORS.white} />
                </TouchableOpacity>
                <Text style={styles.headerTitle}>Profil Saya</Text>
                <View style={{ width: 24 }} /> 
                </View>

                {/* --- AREA PROFIL --- */}
                <View style={styles.profileSection}>
                {/* Foto Profil */}
                <View style={styles.avatarContainer}>
                    <Image 
                    source={{ uri: userData.avatar }} 
                    style={styles.avatar}
                    />
                </View>

                <Text style={styles.userName}>{userData.nama}</Text>
                <View style={styles.roleBadge}>
                    <Text style={styles.roleText}>{userData.role}</Text>
                </View>
                </View>

                {/* --- KARTU INFORMASI --- */}
                <View style={styles.infoCard}>
                
                <View style={styles.infoRow}>
                    <View style={styles.iconContainer}>
                    <MaterialCommunityIcons name="badge-account-outline" size={22} color={COLORS.primary} />
                    </View>
                    <View style={styles.infoTextContainer}>
                    <Text style={styles.infoLabel}>ID Juru Rekap</Text>
                    <Text style={styles.infoValue}>{userData.idRekap}</Text>
                    </View>
                </View>

                <View style={styles.infoRow}>
                    <View style={styles.iconContainer}>
                    <Ionicons name="call-outline" size={20} color={COLORS.primary} />
                    </View>
                    <View style={styles.infoTextContainer}>
                    <Text style={styles.infoLabel}>Nomor Telepon</Text>
                    <Text style={styles.infoValue}>{userData.telepon}</Text>
                    </View>
                </View>

                <View style={styles.infoRow}>
                    <View style={styles.iconContainer}>
                    <Ionicons name="location-outline" size={22} color={COLORS.primary} />
                    </View>
                    <View style={styles.infoTextContainer}>
                    <Text style={styles.infoLabel}>Wilayah Tugas</Text>
                    <Text style={styles.infoValue}>{userData.wilayah}</Text>
                    </View>
                </View>

                <View style={[styles.infoRow, { borderBottomWidth: 0 }]}>
                    <View style={styles.iconContainer}>
                    <Ionicons name="information-circle-outline" size={22} color={COLORS.primary} />
                    </View>
                    <View style={styles.infoTextContainer}>
                    <Text style={styles.infoLabel}>Status Akun</Text>
                    <View style={styles.statusRow}>
                        <Text style={styles.infoValue}>Status: {userData.status}</Text>
                        <View style={styles.statusDot} />
                    </View>
                    </View>
                </View>

                </View>

                <TouchableOpacity style={styles.logoutButton} onPress={handleLogout}>
                <Text style={styles.logoutButtonText}>LOGOUT</Text>
                </TouchableOpacity>

                <Text style={styles.versionText}>Versi Aplikasi 2.1.0-stable</Text>

            </ScrollView>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: COLORS.background,
    },
    scrollContent: {
        paddingBottom: 100, 
    },
    header: {
        backgroundColor: COLORS.primary,
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'space-between', 
        paddingHorizontal: 20,
        paddingTop: 15,
        paddingBottom: 80, 
    },
    backButton: {
        padding: 5,
    },
    headerTitle: {
        color: COLORS.white,
        fontSize: 18,
        fontWeight: 'bold',
    },
    profileSection: {
        alignItems: 'center',
        marginTop: -55, 
        marginBottom: 20,
    },
    avatarContainer: {
        width: 100,
        height: 100,
        borderRadius: 50,
        backgroundColor: COLORS.white,
        padding: 4, 
        elevation: 5,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.2,
        shadowRadius: 5,
    },
    avatar: {
        width: '100%',
        height: '100%',
        borderRadius: 50,
    },
    userName: {
        fontSize: 20,
        fontWeight: 'bold',
        color: COLORS.textDark,
        marginTop: 15,
        letterSpacing: 0.5,
    },
    roleBadge: {
        backgroundColor: COLORS.badgeBg,
        paddingHorizontal: 15,
        paddingVertical: 5,
        borderRadius: 15,
        marginTop: 8,
    },
    roleText: {
        color: COLORS.badgeText,
        fontSize: 12,
        fontWeight: 'bold',
    },
    infoCard: {
        backgroundColor: COLORS.white,
        marginHorizontal: 20,
        borderRadius: 12,
        borderWidth: 1,
        borderColor: COLORS.lightGray,
        marginBottom: 25,
    },
    infoRow: {
        flexDirection: 'row',
        alignItems: 'center',
        paddingVertical: 15,
        paddingHorizontal: 15,
        borderBottomWidth: 1,
        borderBottomColor: COLORS.lightGray,
    },
    iconContainer: {
        width: 40,
        height: 40,
        backgroundColor: COLORS.iconBg,
        borderRadius: 8,
        justifyContent: 'center',
        alignItems: 'center',
        marginRight: 15,
    },
    infoTextContainer: {
        flex: 1,
    },
    infoLabel: {
        fontSize: 11,
        color: COLORS.grayText,
        fontWeight: '600',
        marginBottom: 2,
    },
    infoValue: {
        fontSize: 14,
        fontWeight: 'bold',
        color: COLORS.textDark,
    },
    statusRow: {
        flexDirection: 'row',
        alignItems: 'center',
        justifyContent: 'space-between',
    },
    statusDot: {
        width: 10,
        height: 10,
        borderRadius: 5,
        backgroundColor: COLORS.success,
    },
    logoutButton: {
        backgroundColor: COLORS.orange,
        marginHorizontal: 20,
        height: 55,
        borderRadius: 28, 
        justifyContent: 'center',
        alignItems: 'center',
        elevation: 3,
        shadowColor: '#000',
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.1,
        shadowRadius: 4,
        marginBottom: 20,
    },
    logoutButtonText: {
        color: COLORS.white,
        fontSize: 16,
        fontWeight: 'bold',
        letterSpacing: 1,
    },
    versionText: {
        textAlign: 'center',
        fontSize: 12,
        color: COLORS.grayText,
    },
});