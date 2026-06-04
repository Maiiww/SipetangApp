import React, { useState, useEffect, useCallback } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Alert,
  StatusBar,
  Image
} from 'react-native';
import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import API_URL from '../../config';
import { useRouter } from 'expo-router';
import { useFocusEffect } from 'expo-router';
import AsyncStorage from '@react-native-async-storage/async-storage';

const COLORS = {
  primary: '#002D62',
  background: '#F5F7FA',
  white: '#FFFFFF',
  orange: '#FF6F20',
  lightBlue: '#749DED',
  grayText: '#6B7280',
  lightGray: '#E5E7EB',
  green: '#0b9068'
};

export default function HomeScreen() {
  const router = useRouter();

  const [jumlahRevisi, setJumlahRevisi] = useState(0);

  const fetchNotifikasiRevisi = async () => {
    try {
      const userId = await AsyncStorage.getItem('user_id');
      const response = await fetch(`${API_URL}/tangkapan/count-revisi?user_id=${userId}`);
      const json = await response.json();
      if (json.status === 'success') {
        setJumlahRevisi(json.data.jumlah_revisi);
      }
    } catch (error) {
      console.log('Gagal memuat notifikasi', error);
    }
  };

  const [cuacaData, setCuacaData] = useState({
      peringatan: 'Memuat data cuaca...',
      cuaca: '-',
  });

  const [produksiData, setProduksiData] = useState({
    total: 0,
    lastUpdate: 'Memuat...',
    persentase: 0,
  });

  const handleBelumTersedia = () => {
    Alert.alert("Informasi", "Halaman ini sedang dalam tahap pengembangan.");
  };


  const fetchCuaca = async () => {
    try {
      const response = await fetch(`${API_URL}/cuaca`);
      const json = await response.json();
      if (json.status === 'success') {
        setCuacaData(json.data);
      }
    } catch (error) {
      console.log('Gagal memuat cuaca', error);
      setCuacaData({ peringatan: 'Gagal terhubung ke server', cuaca: '-' });
    }
  };

    const fetchTotalProduksi = async () => {
    try { 
      const response = await fetch(`${API_URL}/total-produksi`);
      const json = await response.json();

      if (json.status === 'success') {
        const TARGET_PRODUKSI = 200; 

        let hitungPersen = (json.data.total_ton / TARGET_PRODUKSI) * 100;
        
        if (hitungPersen > 100) hitungPersen = 100;

        setProduksiData({
          total: json.data.total_ton,
          lastUpdate: json.data.last_update,
          persentase: hitungPersen
        });
      }
    } catch (error) { 
      console.log('Gagal memuat total produksi', error);
      setProduksiData((prev) => ({ ...prev, lastUpdate: 'Gagal memuat' }));
    }
  };

  useFocusEffect(
  useCallback(() => {
    fetchCuaca();
    fetchTotalProduksi();
    fetchNotifikasiRevisi();
  }, [])
);

  return (
    <View style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />
      
      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        <View style={styles.headerBackground}>
          <View style={styles.headerTop}>
            <View style={styles.logoContainer}>
              <Image
                source={require('../../assets/images/sipetangLogo.jpg')}
                style={styles.logoImage}
                resizeMode="contain"
              />
              <Text style={styles.logoText}>SIPETANG</Text>
            </View>

            <TouchableOpacity 
              style={styles.notificationBtn} 
              onPress={() => router.push('/history')} // Pastikan path ini sesuai dengan rute History Anda
            >
              <Ionicons name="notifications-outline" size={24} color={COLORS.primary} />

              {jumlahRevisi > 0 && (
                <View style={styles.badge}>
                  <Text style={styles.badgeText}>{jumlahRevisi}</Text>
                </View>
              )}
            </TouchableOpacity>

          </View>
          
          <Text style={styles.welcomeText}>Selamat Datang,,,</Text>
          <Text style={styles.descText}>
            Di Sistem Informasi Pencatatan Hasil Tangkap{"\n"}
            Mewujudkan tata kelola data perikanan kabupaten subang yang akurat dan transparan
          </Text>
        </View>


        <View style={styles.produksiCard}>
          <View style={styles.produksiRow}>
            <View style={styles.iconBoxSecondary}>
              <Ionicons name="bar-chart" size={24} color={COLORS.primary} />
            </View>
            <View style={styles.produksiInfo}>
              <Text style={styles.produksiLabel}>PRODUKSI IKAN BULAN INI</Text>
              <View style={styles.produksiValueRow}>
                <Text style={styles.produksiValue}>{produksiData.total}</Text>
                <Text style={styles.produksiUnit}>TON</Text>
              </View>
            </View>
          </View>

          <View style={styles.progressBarBg}>
            <View style={[styles.progressBarFill, { width: `${produksiData.persentase}%` }]} />
          </View>
          <Text style={styles.lastUpdateText}>Update terakhir: {produksiData.lastUpdate}</Text>
        </View>

        <View style={[styles.infoCard, { backgroundColor: COLORS.green }]}>
          <View style={styles.infoCardRow}>
            <View style={styles.iconBoxWhite}>
              <MaterialCommunityIcons name="book-open-page-variant" size={28} color={COLORS.primary} />
            </View>
            <View style={styles.infoCardTexts}>
              <Text style={styles.infoCardTitle}>Panduan</Text>
              <Text style={styles.infoCardDesc}>Panduan penggunaan aplikasi</Text>
            </View>
          </View>
          <TouchableOpacity style={styles.lihatButton} onPress={handleBelumTersedia}>
            <Text style={[styles.lihatButtonText, { color: COLORS.primary }]}>Lihat</Text>
          </TouchableOpacity>
        </View>

        <View style={[styles.infoCard, { backgroundColor: COLORS.lightBlue }]}>
          <View style={styles.infoCardRow}>
            <View style={styles.iconBoxWhite}>
              <MaterialCommunityIcons name="weather-pouring" size={28} color={COLORS.lightBlue} />
            </View>
            <View style={styles.infoCardTexts}>
              <Text style={styles.infoCardTitle}>Cuaca: {cuacaData.cuaca}</Text>
              <Text style={styles.infoCardDesc}>{cuacaData.peringatan}</Text>
            </View>
          </View>
          <TouchableOpacity 
              style={styles.lihatButton} 
              onPress={() => router.push('../detail-cuaca')} 
          >
              <Text style={[styles.lihatButtonText, { color: COLORS.primary }]}>Lihat Detail</Text>
          </TouchableOpacity>
        </View>

        <View style={[styles.infoCard, { backgroundColor: COLORS.orange }]}>
          <View style={styles.infoCardRow}>
            <View style={styles.iconBoxWhite}>
              <MaterialCommunityIcons name="trending-up" size={28} color={COLORS.orange} />
            </View>
            <View style={styles.infoCardTexts}>
              <Text style={styles.infoCardTitle}>Tren Produksi Ikan</Text>
              <Text style={styles.infoCardDesc}>Produksi cakalang naik sekitar 12%</Text>
            </View>
          </View>
          <TouchableOpacity 
              style={styles.lihatButton} 
              onPress={() => router.push('../TrenProduksi')} 
          >
              <Text style={[styles.lihatButtonText, { color: COLORS.orange }]}>Lihat</Text>
          </TouchableOpacity>
        </View>

        <View style={styles.footer}>
          <Text style={styles.footerTitle}>DINAS PERIKANAN KABUPATEN SUBANG</Text>
          
          <View style={styles.footerLine} />
          
          <View style={styles.footerContactRow}>
            <Ionicons name="location-outline" size={16} color={COLORS.grayText} />
            <Text style={styles.footerContactText}>Jl. A. Nata Sukarya No. 28, Subang, Jawa Barat, 41211</Text>
          </View>
          <View style={styles.footerContactRow}>
            <Ionicons name="call-outline" size={16} color={COLORS.grayText} />
            <Text style={styles.footerContactText}>(0260) 411325</Text>
          </View>
          <View style={styles.footerContactRow}>
            <Ionicons name="mail-outline" size={16} color={COLORS.grayText} />
            <Text style={styles.footerContactText}>kabupatensubangdinasperikanan@gmail.com</Text>
          </View>
          
          <View style={styles.footerLine} />
          
          <Text style={styles.copyrightText}>
            © 2024 DINAS PERIKANAN KABUPATEN SUBANG. ALL RIGHTS RESERVED.
          </Text>
        </View>

      </ScrollView>
    </View>
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
  headerBackground: {
    backgroundColor: COLORS.primary,
    paddingTop: 20,
    paddingHorizontal: 20,
    paddingBottom: 70, 
    borderBottomLeftRadius: 30,
    borderBottomRightRadius: 30,
  },
  headerTop: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 30,
    alignSelf: 'flex-start',
    paddingHorizontal: 15,
    paddingVertical: 8,
    borderRadius: 20,
    width: '100%',
  },
  logoImage: {
    width: 35,         
    height: 35,        
    borderRadius: 18,  
  },

  logoContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: COLORS.white,
    paddingHorizontal: 15,
    paddingVertical: 8,
    borderRadius: 20,
  },
  logoText: {
    fontSize: 18,
    fontWeight: 'bold',
    color: COLORS.primary,
    marginLeft: 10,
  },
  notificationBtn: {
    backgroundColor: COLORS.white,
    padding: 10,
    borderRadius: 20,
    position: 'relative',
  },
  badge: {
    position: 'absolute',
    right: -2,
    top: -2,
    backgroundColor: COLORS.orange,
    width: 18,
    height: 18,
    borderRadius: 9,
    justifyContent: 'center',
    alignItems: 'center',
    borderWidth: 1.5,
    borderColor: COLORS.primary,
  },
  badgeText: {
    color: COLORS.white,
    fontSize: 10,
    fontWeight: 'bold',
  },
  welcomeText: {
    fontSize: 24,
    fontWeight: 'bold',
    color: COLORS.white,
    marginBottom: 10,
  },
  descText: {
    fontSize: 12,
    color: COLORS.white,
    opacity: 0.8,
    lineHeight: 18,
  },
  produksiCard: {
    backgroundColor: COLORS.white,
    marginHorizontal: 20,
    marginTop: -40, 
    borderRadius: 20,
    padding: 20,
    elevation: 5,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 5,
    marginBottom: 20,
  },
  produksiRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 15,
  },
  iconBoxSecondary: {
    backgroundColor: '#E6EFFF',
    padding: 15,
    borderRadius: 12,
    marginRight: 15,
  },
  produksiInfo: {
    flex: 1,
  },
  produksiLabel: {
    fontSize: 11,
    fontWeight: 'bold',
    color: COLORS.grayText,
    marginBottom: 5,
  },
  produksiValueRow: {
    flexDirection: 'row',
    alignItems: 'flex-end',
  },
  produksiValue: {
    fontSize: 32,
    fontWeight: 'bold',
    color: COLORS.primary,
    lineHeight: 35,
  },
  produksiUnit: {
    fontSize: 14,
    fontWeight: 'bold',
    color: COLORS.grayText,
    marginLeft: 5,
    marginBottom: 5,
  },
  progressBarBg: {
    height: 6,
    backgroundColor: COLORS.lightGray,
    borderRadius: 3,
    marginBottom: 10,
  },
  progressBarFill: {
    height: '100%',
    // width: '80%', 
    backgroundColor: COLORS.orange,
    borderRadius: 3,
  },
  lastUpdateText: {
    fontSize: 10,
    color: COLORS.grayText,
    fontStyle: 'italic',
  },
  infoCard: {
    marginHorizontal: 20,
    borderRadius: 20,
    padding: 20,
    marginBottom: 15,
  },
  infoCardRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 15,
  },
  iconBoxWhite: {
    backgroundColor: COLORS.white,
    padding: 12,
    borderRadius: 12,

    marginRight: 15,
  },
  infoCardTexts: {
    flex: 1,
  },
  infoCardTitle: {
    fontSize: 14,
    fontWeight: 'bold',
    color: COLORS.white,
    marginBottom: 4,
  },
  infoCardDesc: {
    fontSize: 12,
    color: COLORS.white,
    opacity: 0.9,
    lineHeight: 16,
  },
  lihatButton: {
    backgroundColor: COLORS.white,
    paddingVertical: 12,
    borderRadius: 10,
    alignItems: 'center',
  },
  lihatButtonText: {
    fontWeight: 'bold',
    fontSize: 14,
  },
  footer: {
    marginTop: 20,
    paddingHorizontal: 30,
    alignItems: 'center',
  },
  footerTitle: {
    fontSize: 12,
    fontWeight: 'bold',
    color: COLORS.primary,
    marginBottom: 15,
    textAlign: 'center',
  },
  footerLine: {
    width: '100%',
    height: 1,
    backgroundColor: '#D1D5DB',
    marginVertical: 15,
  },
  footerContactRow: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 8,
    width: '100%',
  },
  footerContactText: {
    fontSize: 11,
    color: COLORS.grayText,
    marginLeft: 10,
  },
  copyrightText: {
    fontSize: 9,
    color: COLORS.grayText,
    textAlign: 'center',
    lineHeight: 14,
  },
});