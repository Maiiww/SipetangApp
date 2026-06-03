import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, ScrollView, TouchableOpacity, StatusBar, ActivityIndicator } from 'react-native';
import { Ionicons, MaterialCommunityIcons } from '@expo/vector-icons';
import { useNavigation } from '@react-navigation/native';
import API_URL from '../config';

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

export default function DetailCuacaScreen() {
  const navigation = useNavigation();
  const [loading, setLoading] = useState(true);
  const [cuacaData, setCuacaData] = useState({
    suhu: '-',
    kecepatan_angin: '-',
    arah_angin: '-',
    prakiraan_hourly: [] as any[]
  });


  useEffect(() => {
    const fetchDetailCuaca = async () => {
      try {
        const response = await fetch(`${API_URL}/cuaca`);
        const json = await response.json();
        if (json.status === 'success') {
          setCuacaData(json.data);
        }
      } catch (error) {
        console.log('Gagal memuat detail cuaca', error);
      } finally {
        setLoading(false);
      }
    };
    fetchDetailCuaca();
  }, []);

  return (
    <View style={styles.container}>
      <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />
      
      {/* Header Halaman */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => navigation.goBack()} style={styles.backButton}>
          <Ionicons name="arrow-back" size={24} color={COLORS.white} />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Detail Cuaca & Angin Laut</Text>
        <View style={{ width: 24 }} />
      </View>

      {loading ? (
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" color={COLORS.primary} />
          <Text style={styles.loadingText}>Memuat data cuaca laut...</Text>
        </View>
      ) : (
        <ScrollView contentContainerStyle={styles.content}>
          {/* Grid Informasi Utama */}
          <View style={styles.detailGrid}>
            <View style={styles.detailBox}>
              <MaterialCommunityIcons name="thermometer" size={32} color={COLORS.orange} />
              <Text style={styles.detailValue}>{cuacaData.suhu}</Text>
              <Text style={styles.detailLabel}>Suhu Udara</Text>
            </View>

            <View style={styles.detailBox}>
              <MaterialCommunityIcons name="weather-windy" size={32} color={COLORS.lightBlue} />
              <Text style={styles.detailValue}>{cuacaData.kecepatan_angin}</Text>
              <Text style={styles.detailLabel}>Kecepatan Angin</Text>
            </View>

            <View style={styles.detailBox}>
              <MaterialCommunityIcons name="compass-outline" size={32} color={COLORS.green} />
              <Text style={styles.detailValue}>{cuacaData.arah_angin}</Text>
              <Text style={styles.detailLabel}>Arah Tiupan</Text>
            </View>
          </View>

          {/* Judul Prakiraan Per Jam */}
          <Text style={styles.sectionTitle}>Prakiraan 4 Jam ke Depan (Utara Subang)</Text>
          
          {/* List Prakiraan Jam */}
          <View style={styles.hourlyContainer}>
            {cuacaData.prakiraan_hourly.map((item, index) => (
              <View key={index} style={styles.hourlyRow}>
                <Text style={styles.hourlyTime}>{item.jam}</Text>
                <Text style={styles.hourlyCondition}>{item.cuaca}</Text>
                <Text style={styles.hourlyTemp}>{item.suhu}</Text>
                <View style={styles.hourlyWindBox}>
                  <Ionicons name="flag-outline" size={14} color={COLORS.grayText} />
                  <Text style={styles.hourlyWind}>{item.angin}</Text>
                </View>
              </View>
            ))}
          </View>
        </ScrollView>
      )}
    </View>
  );
}

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: COLORS.background },
  header: { 
    flexDirection: 'row', 
    alignItems: 'center', 
    justifyContent: 'space-between',
    backgroundColor: COLORS.primary, 
    paddingTop: 50, 
    paddingBottom: 20, 
    paddingHorizontal: 20 
  },
  backButton: { padding: 5 },
  headerTitle: { color: COLORS.white, fontSize: 18, fontWeight: 'bold' },
  loadingContainer: { flex: 1, justifyContent: 'center', alignItems: 'center' },
  loadingText: { marginTop: 10, color: COLORS.grayText },
  content: { padding: 20 },
  detailGrid: { flexDirection: 'row', justifyContent: 'space-between', marginBottom: 30 },
  detailBox: { 
    flex: 1, 
    backgroundColor: COLORS.white, 
    padding: 15, 
    borderRadius: 15, 
    alignItems: 'center', 
    marginHorizontal: 4, 
    elevation: 2,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.1,
    shadowRadius: 3,
  },
  detailValue: { fontSize: 16, fontWeight: 'bold', color: COLORS.primary, marginTop: 8, textAlign: 'center' },
  detailLabel: { fontSize: 11, color: COLORS.grayText, marginTop: 4, textAlign: 'center' },
  sectionTitle: { fontSize: 15, fontWeight: 'bold', color: COLORS.primary, marginBottom: 15 },
  hourlyContainer: { backgroundColor: COLORS.white, borderRadius: 15, padding: 15, elevation: 2 },
  hourlyRow: { 
    flexDirection: 'row', 
    justifyContent: 'space-between', 
    alignItems: 'center', 
    paddingVertical: 15, 
    borderBottomWidth: 1, 
    borderBottomColor: COLORS.lightGray 
  },
  hourlyTime: { fontSize: 14, fontWeight: 'bold', color: COLORS.primary, width: '25%' },
  hourlyCondition: { fontSize: 13, color: COLORS.grayText, width: '35%' },
  hourlyTemp: { fontSize: 14, fontWeight: 'bold', color: COLORS.orange, width: '15%' },
  hourlyWindBox: { flexDirection: 'row', alignItems: 'center', justifyContent: 'flex-end', width: '25%' },
  hourlyWind: { fontSize: 12, color: COLORS.grayText, marginLeft: 5 },
});