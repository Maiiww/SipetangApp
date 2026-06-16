import React, { useState, useEffect, useCallback } from 'react';
import { View, Text, StyleSheet, Dimensions, ScrollView, TouchableOpacity, ActivityIndicator, RefreshControl } from 'react-native';
import { BarChart } from 'react-native-chart-kit';
import { Ionicons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';
import API_URL from '../config';
import AsyncStorage from '@react-native-async-storage/async-storage';

const screenWidth = Dimensions.get('window').width;

const COLORS = {
  primary: '#002D62',
  background: '#F5F7FA',
  white: '#FFFFFF',
  orange: '#FF6F20',
  grayText: '#6B7280',
};

export default function TrenProduksiScreen() {
  const router = useRouter();

  const getPeriods = () => {
    const result = [];
    const today = new Date();
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"];
    
    result.push({
      label: "Tahun Ini",
      type: "tahunan",
      month: null,
      year: today.getFullYear(),
      id: "year_0"
    });

    for (let i = 0; i < 6; i++) {
      const d = new Date(today.getFullYear(), today.getMonth() - i, 1);
      result.push({
        label: i === 0 ? "Bulan Ini" : `${monthNames[d.getMonth()]} ${d.getFullYear()}`,
        type: "bulanan",
        month: d.getMonth() + 1,
        year: d.getFullYear(),
        id: `month_${i}`
      });
    }
    return result;
  };

  const [periods] = useState(getPeriods());
  const [selectedPeriod, setSelectedPeriod] = useState(periods[0]);

  const [labels, setLabels] = useState(["", "", "", "", "", ""]);
  const [dataPoints, setDataPoints] = useState([0, 0, 0, 0, 0, 0]);
  const [loading, setLoading] = useState(true);
  const [refreshing, setRefreshing] = useState(false);

  const fetchTrenProduksi = useCallback(async () => {
      try {
        const userId = await AsyncStorage.getItem('user_id');
        const response = await fetch(`${API_URL}/tangkapan/tren-per-ikan?user_id=${userId}&type=${selectedPeriod.type}&bulan=${selectedPeriod.month}&tahun=${selectedPeriod.year}`);
        const json = await response.json();

        if (json.status === 'success') {
          setLabels(json.data.labels);
          setDataPoints(json.data.values);
        }
      } catch (error) {
        console.log('Gagal memuat tren:', error);
      }
  }, [selectedPeriod]);

  useEffect(() => {
    setLoading(true);
    fetchTrenProduksi().finally(() => setLoading(false));
  }, [fetchTrenProduksi]);

  const onRefresh = useCallback(async () => {
    setRefreshing(true);
    await fetchTrenProduksi();
    setRefreshing(false);
  }, [fetchTrenProduksi]);

  const chartData = {
    labels: labels.length > 0 ? labels.slice(0, 5) : ["-"],
    datasets: [
      {
        data: dataPoints.length > 0 ? dataPoints.slice(0, 5) : [0],
        color: (opacity = 1) => `rgba(255, 111, 32, ${opacity})`,
      }
    ]
  };

  return (
    <ScrollView 
      style={styles.container}
      refreshControl={
        <RefreshControl refreshing={refreshing} onRefresh={onRefresh} colors={[COLORS.primary]} />
      }
    >
      {/* Header Halaman */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => router.back()} style={styles.backButton}>
          <Ionicons name="arrow-back" size={24} color={COLORS.white} />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Tren Produksi Ikan</Text>
        <View style={{ width: 24 }} />
      </View>

      <View style={styles.chartContainer}>
        <Text style={styles.chartTitle}>Tren Produksi Ikan</Text>

        <ScrollView horizontal showsHorizontalScrollIndicator={false} style={styles.filterContainer}>
          {periods.map((item) => (
            <TouchableOpacity 
              key={item.id} 
              style={[styles.filterChip, selectedPeriod.id === item.id && styles.filterChipActive]}
              onPress={() => setSelectedPeriod(item)}
            >
              <Text style={[styles.filterChipText, selectedPeriod.id === item.id && styles.filterChipTextActive]}>
                {item.label}
              </Text>
            </TouchableOpacity>
          ))}
        </ScrollView>

        {loading ? (
          <View style={{ height: 220, justifyContent: 'center', alignItems: 'center' }}>
            <ActivityIndicator size="large" color={COLORS.primary} />
            <Text style={{ marginTop: 10, color: COLORS.grayText }}>Memuat grafik...</Text>
          </View>
        ) : (
          <BarChart
            data={chartData}
            width={screenWidth - 40}
            height={280}
            yAxisLabel=""
            yAxisSuffix=" T"
            fromZero={true}
            showValuesOnTopOfBars={true}
            chartConfig={{
              backgroundColor: COLORS.white,
              backgroundGradientFrom: COLORS.white,
              backgroundGradientTo: COLORS.white,
              decimalPlaces: 1,
              color: (opacity = 1) => `rgba(0, 45, 98, ${opacity})`,
              labelColor: (opacity = 1) => `rgba(107, 114, 128, ${opacity})`,
              style: {
                borderRadius: 16
              },
              barPercentage: 0.6,
            }}
            style={{
              marginVertical: 10,
              borderRadius: 16
            }}
          />
        )}
      </View>

      {/* Daftar Lengkap */}
      {!loading && labels.length > 0 && labels[0] !== "Belum ada data" && (
        <View style={styles.listContainer}>
          <Text style={styles.listTitle}>Daftar Lengkap Produksi Ikan</Text>
          {labels.map((label, index) => (
            <View key={index} style={styles.listItem}>
              <View style={styles.listItemLeft}>
                <View style={styles.listNumberBadge}>
                  <Text style={styles.listNumberText}>{index + 1}</Text>
                </View>
                <Text style={styles.listItemText}>{label}</Text>
              </View>
              <Text style={styles.listItemValue}>{dataPoints[index]} Ton</Text>
            </View>
          ))}
        </View>
      )}
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: COLORS.background,
  },
  header: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    backgroundColor: COLORS.primary,
    paddingTop: 50,
    paddingBottom: 20,
    paddingHorizontal: 20,
  },
  backButton: {
    padding: 5,
  },
  headerTitle: {
    color: COLORS.white,
    fontSize: 18,
    fontWeight: 'bold',
  },
  chartContainer: {
    backgroundColor: COLORS.white,
    margin: 20,
    padding: 15,
    borderRadius: 15,
    elevation: 3,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    alignItems: 'center'
  },
  chartTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    color: COLORS.primary,
    marginBottom: 15,
    alignSelf: 'flex-start'
  },
  filterContainer: {
    flexDirection: 'row',
    marginBottom: 20,
  },
  filterChip: {
    paddingHorizontal: 15,
    paddingVertical: 8,
    borderRadius: 20,
    backgroundColor: COLORS.background,
    marginRight: 10,
    borderWidth: 1,
    borderColor: '#E5E7EB',
  },
  filterChipActive: {
    backgroundColor: COLORS.orange,
    borderColor: COLORS.orange,
  },
  filterChipText: {
    fontSize: 12,
    color: COLORS.grayText,
    fontWeight: '600',
  },
  filterChipTextActive: {
    color: COLORS.white,
  },
  listContainer: {
    backgroundColor: COLORS.white,
    marginHorizontal: 20,
    marginBottom: 30,
    padding: 15,
    borderRadius: 15,
    elevation: 3,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
  },
  listTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    color: COLORS.primary,
    marginBottom: 15,
  },
  listItem: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingVertical: 12,
    borderBottomWidth: 1,
    borderBottomColor: '#F3F4F6',
  },
  listItemLeft: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  listNumberBadge: {
    width: 24,
    height: 24,
    borderRadius: 12,
    backgroundColor: '#EBF5FF',
    justifyContent: 'center',
    alignItems: 'center',
    marginRight: 10,
  },
  listNumberText: {
    fontSize: 12,
    fontWeight: 'bold',
    color: COLORS.primary,
  },
  listItemText: {
    fontSize: 14,
    color: '#374151',
    fontWeight: '500',
  },
  listItemValue: {
    fontSize: 14,
    fontWeight: 'bold',
    color: COLORS.orange,
  }
});