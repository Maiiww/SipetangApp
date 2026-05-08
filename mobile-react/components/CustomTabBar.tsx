import React from "react";
import {
    View,
    Text,
    TouchableOpacity,
    StyleSheet,
    SafeAreaView
} from "react-native";
import { Ionicons } from "@expo/vector-icons";
import { BottomTabBarProps } from "@react-navigation/bottom-tabs";

export default function CustomTabBar({ state, descriptors, navigation }: BottomTabBarProps) {
    return (
        <SafeAreaView style={{ backgroundColor: '#F8F9FA' }}>
            <View style={styles.tabContainer}>
                {state.routes.map((route: any, index: number) => {
                const { options } = descriptors[route.key];
                const label = options.title !== undefined ? options.title : route.name;
                const isFocused = state.index === index;

                const onPress = () => {
                    const event = navigation.emit({
                    type: 'tabPress',
                    target: route.key,
                    canPreventDefault: true,
                    });

                    if (!isFocused && !event.defaultPrevented) {
                    navigation.navigate(route.name);
                    }
                };

                // Menentukan Ikon berdasarkan nama rute
                let iconName: any = 'home';
                if (route.name === 'index') iconName = isFocused ? 'home' : 'home-outline';
                if (route.name === 'kelola') iconName = isFocused ? 'bar-chart' : 'bar-chart-outline';
                if (route.name === 'history') iconName = isFocused ? 'time' : 'time-outline';
                if (route.name === 'profil') iconName = isFocused ? 'person' : 'person-outline';

                return (
                    <TouchableOpacity
                    key={index}
                    accessibilityRole="button"
                    accessibilityState={isFocused ? { selected: true } : {}}
                    onPress={onPress}
                    style={[styles.tabButton, isFocused && styles.tabButtonFocused]}
                    >
                    <Ionicons 
                        name={iconName} 
                        size={22} 
                        color={isFocused ? '#002D62' : '#8A8A8A'} 
                    />
                    <Text style={[styles.tabLabel, { color: isFocused ? '#002D62' : '#8A8A8A' }]}>
                        {label === 'index' ? 'BERANDA' : label.toString().toUpperCase()}
                    </Text>
                    </TouchableOpacity>
                );
                })}
            </View>
        </SafeAreaView>
    )
}

const styles = StyleSheet.create({
    tabContainer: {
        flexDirection: 'row',
        backgroundColor: '#FFFFFF',
        height: 70,
        borderRadius: 20,
        marginHorizontal: 15,
        marginBottom: 10,
        justifyContent: 'space-around',
        alignItems: 'center',
        elevation: 10, // Bayangan Android
        shadowColor: '#000', // Bayangan iOS
        shadowOffset: { width: 0, height: 4 },
        shadowOpacity: 0.1,
        shadowRadius: 10,
    },
    tabButton: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center',
        paddingVertical: 10,
        borderRadius: 15,
    },
    tabButtonFocused: {
        backgroundColor: '#E6F0FF', 
        marginHorizontal: 5,
    },
    tabLabel: {
        fontSize: 10,
        fontWeight: 'bold',
        marginTop: 4,
    },
});