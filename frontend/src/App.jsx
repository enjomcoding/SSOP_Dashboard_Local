import { BrowserRouter, Navigate, Route, Routes } from 'react-router-dom';
import { Toaster } from 'react-hot-toast';
import { AuthProvider, useAuth } from './contexts/AuthContext';
import DashboardLayout from './components/DashboardLayout';
import DashboardOverview from './pages/DashboardOverview';
import RawMaterialLogsPage from './pages/RawMaterialLogsPage';
import DeliveryTruckLogsPage from './pages/DeliveryTruckLogsPage';
import PestControlLogsPage from './pages/PestControlLogsPage';
import OilTemperatureLogsPage from './pages/OilTemperatureLogsPage';
import CleaningLogsPage from './pages/CleaningLogsPage';
import StockManagementLogsPage from './pages/StockManagementLogsPage';
import LoginPage from './pages/LoginPage';
import RegisterPage from './pages/RegisterPage';

const ProtectedRoute = ({ children }) => {
  const { user } = useAuth();
  if (!user) {
    return <Navigate to="/login" replace />;
  }
  return children;
};

const AuthRoute = ({ children }) => {
  const { user } = useAuth();
  if (user) {
    return <Navigate to="/" replace />;
  }
  return children;
};

export default function App() {
  return (
    <BrowserRouter>
      <AuthProvider>
        <Toaster position="top-right" />
        <Routes>
          <Route
            path="/login"
            element={
              <AuthRoute>
                <LoginPage />
              </AuthRoute>
            }
          />
          <Route
            path="/register"
            element={
              <AuthRoute>
                <RegisterPage />
              </AuthRoute>
            }
          />
          
          <Route
            path="/"
            element={
              <ProtectedRoute>
                <DashboardLayout />
              </ProtectedRoute>
            }
          >
            <Route index element={<DashboardOverview />} />
            <Route path="raw-material-logs" element={<RawMaterialLogsPage />} />
            <Route path="delivery-truck-logs" element={<DeliveryTruckLogsPage />} />
            <Route path="pest-control-logs" element={<PestControlLogsPage />} />
            <Route path="oil-temperature-logs" element={<OilTemperatureLogsPage />} />
            <Route path="cleaning-logs" element={<CleaningLogsPage />} />
            <Route path="stock-management-logs" element={<StockManagementLogsPage />} />
            <Route path="*" element={<Navigate to="/" replace />} />
          </Route>
        </Routes>
      </AuthProvider>
    </BrowserRouter>
  );
}
