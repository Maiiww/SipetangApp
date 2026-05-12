import React, { createContext, useCallback, useContext, useEffect, useState } from "react";

type AuthContextType = {
  isAuthenticated: boolean;
  isAuthChecking: boolean;
  signIn: () => Promise<void>;
  signOut: () => void;
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [isAuthenticated, setIsAuthenticated] = useState(false);
  const [isAuthChecking, setIsAuthChecking] = useState(true);

  useEffect(() => {
    const initializeAuth = async () => {
      setIsAuthenticated(false);
      setIsAuthChecking(false);
    };

    initializeAuth();
  }, []);

  const signIn = useCallback(async () => {
    setIsAuthenticated(true);
  }, []);

  const signOut = useCallback(() => {
    setIsAuthenticated(false);
  }, []);

  return (
    <AuthContext.Provider value={{ isAuthenticated, isAuthChecking, signIn, signOut }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within AuthProvider");
  }
  return context;
}
