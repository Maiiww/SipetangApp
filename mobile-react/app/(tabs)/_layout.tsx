import { Tabs } from 'expo-router';
import React from 'react';
import CustomTabBar from '../../components/CustomTabBar'; 

export default function TabLayout() {
  return (
    <Tabs
      
      tabBar={(props) => <CustomTabBar {...props} />}
      
      screenOptions={{
        headerShown: false, 
      }}
    >
      
      <Tabs.Screen
        name="index"
        options={{
          title: 'Beranda', 
        }}
      />
      
      <Tabs.Screen
        name="kelola" 
        options={{
          title: 'Kelola Data',
        }}
      />
      
      <Tabs.Screen
        name="history" 
        options={{
          title: 'History',
        }}
      />
      
      <Tabs.Screen
        name="profil" 
        options={{
          title: 'Profil',
        }}
      />
    </Tabs>
  );
}