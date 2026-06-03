import React from 'react';
import { View, Text, StyleSheet, Dimensions, ScrollView, TouchableOpacity } from 'react-native';
import { LineChart } from 'react-native-chart-kit';
import { Ionicons } from '@expo/vector-icons';
import { useRouter } from 'expo-router';

const screenWidth = Dimensions.get('window').width;

const COLORS = {
  primary: '#002D62',
  background: '#F5F7FA',
  white: '#FFFFFF',
  orange: '#FF6F20',
};

export default function TrenProduksiScreen() {
  const router = useRouter();

  const chartData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
    datasets: [
      {
        data: [15, 25, 40, 35, 55, 70],
        color: (opacity = 1) => `rgba(255, 111, 32, ${opacity})`,
        strokeWidth: 3
      }
    ],
    legend: ["Total Tangkapan (Ton)"] 
  };

  return (
    <ScrollView style={styles.container}>
      {/* Header Halaman */}
      <View style={styles.header}>
        <TouchableOpacity onPress={() => router.back()} style={styles.backButton}>
          <Ionicons name="arrow-back" size={24} color={COLORS.white} />
        </TouchableOpacity>
        <Text style={styles.headerTitle}>Tren Produksi Ikan</Text>
        <View style={{ width: 24 }} /> 
      </View>

      {/* Kontainer Grafik */}
      <View style={styles.chartContainer}>
        <Text style={styles.chartTitle}>Statistik 6 Bulan Terakhir</Text>
        
        <LineChart
          data={chartData}
          width={screenWidth - 40}
          height={220}
          yAxisSuffix=" T" 
          chartConfig={{
            backgroundColor: COLORS.white,
            backgroundGradientFrom: COLORS.white,
            backgroundGradientTo: COLORS.white,
            decimalPlaces: 0, 
            color: (opacity = 1) => `rgba(0, 45, 98, ${opacity})`,
            labelColor: (opacity = 1) => `rgba(107, 114, 128, ${opacity})`,
            style: {
              borderRadius: 16
            },
            propsForDots: {
              r: "5",
              strokeWidth: "2",
              stroke: COLORS.primary
            }
          }}
          bezier
          style={{
            marginVertical: 10,
            borderRadius: 16
          }}
        />
      </View>
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
        paddingTop: 50, // Sesuaikan dengan safe area Anda
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
        marginBottom: 10,
        alignSelf: 'flex-start'
    }
});