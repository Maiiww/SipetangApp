import React from 'react';
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

const COLORS = {
  primary: '#002D62',
  background: '#F5F7FA',
  white: '#FFFFFF',
  orange: '#FF6F20',
  lightBlue: '#749DED',
  grayText: '#6B7280',
  lightGray: '#E5E7EB',
};

export default function HomeScreen() {
  
  const userData = {
    nama: "Petugas",
    totalProduksi: 10,
    lastUpdate: "26 April 2026",
  };

  const handleBelumTersedia = () => {
    Alert.alert("Informasi", "Halaman ini sedang dalam tahap pengembangan.");
  };

  return (
    <View style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />
      
      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        <View style={styles.headerBackground}>
          <View style={styles.headerTop}>
            <Image
              source={require('../../assets/images/sipetangLogo.jpg')}
              style={styles.logoImage}
              resizeMode="contain"
            />
            <Text style={styles.logoText}>SIPETANG</Text>
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
              <Text style={styles.produksiLabel}>TOTAL PRODUKSI IKAN</Text>
              <View style={styles.produksiValueRow}>
                <Text style={styles.produksiValue}>{userData.totalProduksi}</Text>
                <Text style={styles.produksiUnit}>TON</Text>
              </View>
            </View>
          </View>

          <View style={styles.progressBarBg}>
            <View style={styles.progressBarFill} />
          </View>
          <Text style={styles.lastUpdateText}>Update terakhir: {userData.lastUpdate}</Text>
        </View>

        <View style={[styles.infoCard, { backgroundColor: COLORS.lightBlue }]}>
          <View style={styles.infoCardRow}>
            <View style={styles.iconBoxWhite}>
              <MaterialCommunityIcons name="weather-pouring" size={28} color={COLORS.lightBlue} />
            </View>
            <View style={styles.infoCardTexts}>
              <Text style={styles.infoCardTitle}>Peringatan Cuaca</Text>
              <Text style={styles.infoCardDesc}>Wilayah Utara Gelombang Sedang Tinggi</Text>
            </View>
          </View>
          <TouchableOpacity style={styles.lihatButton} onPress={handleBelumTersedia}>
            <Text style={[styles.lihatButtonText, { color: COLORS.primary }]}>Lihat</Text>
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
          <TouchableOpacity style={styles.lihatButton} onPress={handleBelumTersedia}>
            <Text style={[styles.lihatButtonText, { color: COLORS.primary }]}>Lihat</Text>
          </TouchableOpacity>
        </View>

        <View style={styles.footer}>
          <Text style={styles.footerTitle}>DINAS PERIKANAN KABUPATEN SUBANG</Text>
          
          <View style={styles.footerLine} />
          
          <View style={styles.footerContactRow}>
            <Ionicons name="location-outline" size={16} color={COLORS.grayText} />
            <Text style={styles.footerContactText}>JL. IN AJA DULU</Text>
          </View>
          <View style={styles.footerContactRow}>
            <Ionicons name="call-outline" size={16} color={COLORS.grayText} />
            <Text style={styles.footerContactText}>08432567823452335</Text>
          </View>
          <View style={styles.footerContactRow}>
            <Ionicons name="mail-outline" size={16} color={COLORS.grayText} />
            <Text style={styles.footerContactText}>dinasperikanan@hotmail.co.id</Text>
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
    paddingTop: 50,
    paddingHorizontal: 20,
    paddingBottom: 70, 
    borderBottomLeftRadius: 30,
    borderBottomRightRadius: 30,
  },
  headerTop: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 30,
    backgroundColor: COLORS.white,
    alignSelf: 'flex-start',
    paddingHorizontal: 15,
    paddingVertical: 8,
    borderRadius: 20,
  },
  logoImage: {
    width: 35,         
    height: 35,        
    borderRadius: 18,  
  },
  
  logoText: {
    fontSize: 18,
    fontWeight: 'bold',
    color: COLORS.primary,
    marginLeft: 10,
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
    width: '80%', 
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