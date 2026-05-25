import api from './api';

const resources = {
  raw_material_logs: 'raw-material-logs',
  delivery_truck_logs: 'delivery-truck-logs',
  pest_control_logs: 'pest-control-logs',
  oil_temperature_logs: 'oil-temperature-logs',
  cleaning_logs: 'cleaning-logs',
  stock_management_logs: 'stock-management-logs',
};

export const getResourcePath = (resourceKey) => resources[resourceKey];

export const fetchLogs = (resourceKey, page = 1) =>
  api.get(`/${resources[resourceKey]}`, { params: { page } });

export const fetchLog = (resourceKey, id) =>
  api.get(`/${resources[resourceKey]}/${id}`);

export const createLog = (resourceKey, payload) =>
  api.post(`/${resources[resourceKey]}`, payload);

export const updateLog = (resourceKey, id, payload) =>
  api.put(`/${resources[resourceKey]}/${id}`, payload);

export const deleteLog = (resourceKey, id) =>
  api.delete(`/${resources[resourceKey]}/${id}`);

export const fetchAnalytics = () => api.get('/analytics');
