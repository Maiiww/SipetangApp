import { Ionicons } from '@expo/vector-icons';
import { useRouter } from "expo-router";
import React, { useState } from "react";
import {
    ActivityIndicator,
    Image,
    SafeAreaView,
    ScrollView,
    StatusBar,
    StyleSheet,
    Text,
    TextInput,
    TouchableOpacity,
    View
} from "react-native";
import { useAuth } from "../components/AuthContext";

const COLORS = {
  primary: '#002D62',
  orange: '#FF6F20',
  card: '#FFFFFF',
  grayLabel: '#8A8A8A',
  grayInput: '#F0F2F5',
  error: '#FF0000',
};

export default function LoginScreen() {
    const router = useRouter();
    const { signIn } = useAuth();

    const [username, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [isPasswordVisible, setIsPasswordVisible] = useState(false);
    const [isRememberMeChecked, setIsRememberMeChecked] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [errors, setErrors] = useState({ username: '', password: '', general: '' });

    
    const validateForm = () => {
        let isValid = true;
        let newErrors = { username: '', password: '', general: '' };

        if (!username.trim()) {
        newErrors.username = 'Nama pengguna wajib diisi.';
        isValid = false;
        }

        if (!password.trim()) {
        newErrors.password = 'Kata sandi wajib diisi.';
        isValid = false;
        }

        setErrors(newErrors);
        return isValid;
    };

    const apiLoginSimulasi = async () => {

    await new Promise((resolve) => setTimeout(resolve, 2000));

    if (username.toLowerCase() === 'imamarifin' && password === 'password123') {
      return { success: true, user: { id: 1, nama: 'Petugas Dinas' }, token: 'fake-token' };
    } else {
      throw new Error('Nama pengguna atau kata sandi Anda salah.');
    }
  };



  const handleLogin = async () => {

    setErrors({ username: '', password: '', general: '' });

  
    if (!validateForm()) {
      return; 
    }

    setIsLoading(true);

    try {
      const result = await apiLoginSimulasi();

      console.log('Login Sukses:', result);

      await signIn(); 
      router.replace('/(tabs)');
      
    } catch (error: any) {
      console.log('Login Gagal:', error.message);
      setErrors((prev) => ({ ...prev, general: error.message }));
    } finally {
      setIsLoading(false);
    }
  };


//---------- Handle login with API ------------------------
    // const handleLogin = async () => {
    //     setErrors({ username: '', password: '', general: '' });
    //     if (!validateForm()) return;
    //     setIsLoading(true);

    //     try {
            
    //         const response = await fetch('http://192.168.100.64:8000/api/login', {
    //             method: 'POST',
    //             headers: {
    //                 'Accept': 'application/json',
    //                 'Content-Type': 'application/json',
    //             },
    //             body: JSON.stringify({
    //                 username: username.trim(),
    //                 password: password,
    //             }),
    //         });

    //         const data = await response.json();

           
    //         if (response.ok && data.status === 'success') {      
    //             await signIn(); 
    //             router.replace('/(tabs)');
    //         } else {
                
    //             throw new Error(data.message || 'Nama pengguna atau kata sandi salah.');
    //         }

            
    //     } catch (error: any) {
    //         setErrors((prev) => ({ ...prev, general: error.message || 'Terjadi kesalahan jaringan.' }));
    //     } finally {
    //         setIsLoading(false);
    //     }
    // };

    return (
        <SafeAreaView style={styles.container}>
            <StatusBar barStyle="light-content" backgroundColor={COLORS.primary} />

            <ScrollView contentContainerStyle={styles.scrollContent}>
                <View style={styles.header}>
                <View style={styles.logoContainer}>
                    <View style={styles.logoPlaceholder}>
                      <Image
                        source={require('../assets/images/sipetangLogo.jpg')}
                        style={styles.logoImage}
                        resizeMode="contain"
                      />
                    </View>
                </View>

                <Text style={styles.title}>SIPETANG</Text>
                <Text style={styles.subtitle}>Sistem Pencatatan Hasil Tangkap</Text>
                <Text style={styles.instansi}>DINAS PERIKANAN KABUPATEN SUBANG</Text>
                </View>

                <View style={styles.card}>
                <Text style={styles.cardTitle}>Masuk</Text>

                {errors.general ? (
                    <View style={styles.generalErrorContainer}>
                    <Text style={styles.errorTextSmall}>{errors.general}</Text>
                    </View>
                ) : null}

                <View style={styles.inputField}>
                    <Text style={styles.inputLabel}>NAMA PENGGUNA</Text>
                    <View style={styles.inputContainer}>
                    <Ionicons name="person-outline" size={20} color={COLORS.grayLabel} style={styles.inputIcon} />
                    <TextInput
                        style={styles.textInput}
                        placeholder="Masukkan Nama"
                        value={username}
                        onChangeText={setUsername}
                        autoCapitalize="none"
                    />
                    </View>
                    {errors.username ? <Text style={styles.errorTextSmall}>{errors.username}</Text> : null}
                </View>

                <View style={styles.inputField}>
                    <Text style={styles.inputLabel}>KATA SANDI</Text>
                    <View style={styles.inputContainer}>
                    <Ionicons name="lock-closed-outline" size={20} color={COLORS.grayLabel} style={styles.inputIcon} />
                    <TextInput
                        style={styles.textInput}
                        placeholder="••••••••" 
                        value={password}
                        onChangeText={setPassword}
                        secureTextEntry={!isPasswordVisible} 
                    />
                    <TouchableOpacity onPress={() => setIsPasswordVisible(!isPasswordVisible)} style={styles.inputIconRight}>
                        <Ionicons
                        name={isPasswordVisible ? 'eye-off-outline' : 'eye-outline'}
                        size={20}
                        color={COLORS.grayLabel}
                        />
                    </TouchableOpacity>
                    </View>
                    {errors.password ? <Text style={styles.errorTextSmall}>{errors.password}</Text> : null}
                </View>

                <View style={styles.row}>
                    <TouchableOpacity
                    style={styles.checkboxContainer}
                    onPress={() => setIsRememberMeChecked(!isRememberMeChecked)}
                    >
                    <View style={[styles.checkbox, isRememberMeChecked && styles.checkboxChecked]}>
                        {isRememberMeChecked && <Ionicons name="checkmark" size={12} color="white" />}
                    </View>
                    <Text style={styles.checkboxLabel}>Ingatkan Saya</Text>
                    </TouchableOpacity>
                </View>

                <TouchableOpacity
                    style={[styles.loginButton, isLoading && styles.loginButtonDisabled]}
                    onPress={handleLogin}
                    disabled={isLoading} 
                >
                    {isLoading ? (
                    <ActivityIndicator color="white" />
                    ) : (
                    <>
                        <Text style={styles.loginButtonText}>Masuk</Text>
                        <Ionicons name="arrow-forward" size={18} color="white" style={styles.buttonIcon} />
                    </>
                    )}
                </TouchableOpacity>
                </View>

            </ScrollView>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: COLORS.primary,
    },
    scrollContent: {
        flexGrow: 1,
        paddingVertical: 20,
        alignItems: 'center',
        justifyContent: 'center', 
    },
    header: {
        alignItems: 'center',
        marginBottom: 40,
        paddingHorizontal: 20,
    },
    logoContainer: {
        marginBottom: 20,
    },
    logoPlaceholder: {
        width: 100,
        height: 100,
        borderRadius: 50,
        backgroundColor: 'rgba(255,255,255,0.2)', 
        borderWidth: 2,
        borderColor: 'white',
        alignItems: 'center',
        justifyContent: 'center',
        overflow: 'hidden',
    },
    logoImage: {
        width: '100%',
        height: '100%',
    },
    title: {
        fontSize: 28,
        fontWeight: 'bold',
        color: 'white',
        letterSpacing: 1,
        marginBottom: 5,
    },
    subtitle: {
        fontSize: 14,
        color: 'white',
        opacity: 0.8,
        marginBottom: 3,
    },
    instansi: {
        fontSize: 12,
        color: 'white',
        opacity: 0.6,
        fontWeight: '600',
    },
    card: {
        width: '90%',
        backgroundColor: COLORS.card,
        borderRadius: 20,
        padding: 30,
        elevation: 5, 
        shadowColor: '#000', 
        shadowOffset: { width: 0, height: 2 },
        shadowOpacity: 0.2,
        shadowRadius: 5,
    },
    cardTitle: {
        fontSize: 22,
        fontWeight: 'bold',
        color: COLORS.primary,
        marginBottom: 25,
    },
    generalErrorContainer: {
        backgroundColor: 'rgba(255,0,0,0.1)',
        padding: 10,
        borderRadius: 8,
        marginBottom: 15,
        borderWidth: 1,
        borderColor: 'rgba(255,0,0,0.3)',
    },
    inputField: {
        marginBottom: 20,
    },
    inputLabel: {
        fontSize: 11,
        color: COLORS.grayLabel,
        fontWeight: '700',
        marginBottom: 8,
        letterSpacing: 0.5,
    },
    inputContainer: {
        flexDirection: 'row',
        alignItems: 'center',
        backgroundColor: COLORS.grayInput,
        borderRadius: 10,
        paddingHorizontal: 15,
        height: 50,
        position: 'relative',
    },
    inputIcon: {
        marginRight: 10,
    },
    textInput: {
        flex: 1,
        fontSize: 14,
        color: COLORS.primary,
    },
    inputIconRight: {
        position: 'absolute',
        right: 15,
    },
    row: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        alignItems: 'center',
        marginBottom: 25,
    },
    checkboxContainer: {
        flexDirection: 'row',
        alignItems: 'center',
    },
    checkbox: {
        width: 18,
        height: 18,
        borderRadius: 4,
        borderWidth: 2,
        borderColor: COLORS.grayLabel,
        marginRight: 8,
        alignItems: 'center',
        justifyContent: 'center',
    },
    checkboxChecked: {
        backgroundColor: COLORS.orange,
        borderColor: COLORS.orange,
    },
    checkboxLabel: {
        fontSize: 12,
        color: COLORS.grayLabel,
    },
    loginButton: {
        flexDirection: 'row',
        backgroundColor: COLORS.orange,
        borderRadius: 12,
        height: 55,
        alignItems: 'center',
        justifyContent: 'center',
        elevation: 2,
    },
    loginButtonDisabled: {
        opacity: 0.7,
    },
    loginButtonText: {
        color: 'white',
        fontSize: 16,
        fontWeight: 'bold',
    },
    buttonIcon: {
        marginLeft: 10,
    },
    errorTextSmall: {
        color: COLORS.error,
        fontSize: 11,
        marginTop: 5,
        marginLeft: 5,
    },
});