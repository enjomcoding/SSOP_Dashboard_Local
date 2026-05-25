import { NavLink } from 'react-router-dom';
import {
  ClipboardList,
  Droplets,
  LayoutDashboard,
  Package,
  Thermometer,
  Truck,
  Bug,
  Warehouse,
} from 'lucide-react';
import { resourceMeta } from '../config/resourceFields';

const iconMap = {
  raw_material_logs: Package,
  delivery_truck_logs: Truck,
  pest_control_logs: Bug,
  oil_temperature_logs: Thermometer,
  cleaning_logs: Droplets,
  stock_management_logs: Warehouse,
};

const navItems = [
  { to: '/', label: 'Overview', icon: LayoutDashboard },
  ...Object.entries(resourceMeta).map(([key, meta]) => ({
    to: meta.path,
    label: meta.title,
    icon: iconMap[key],
  })),
];

export default function Sidebar() {
  return (
    <aside className="flex h-full w-64 flex-col border-r border-gray-200 bg-white">
      <div className="border-b border-gray-200 px-6 py-5">
        <h1 className="text-lg font-bold text-emerald-700">FSQA Monitor</h1>
        <p className="text-xs text-gray-500">Food Safety & Quality</p>
      </div>
      <nav className="flex-1 space-y-1 p-4">
        {navItems.map(({ to, label, icon: Icon }) => (
          <NavLink
            key={to}
            to={to}
            end={to === '/'}
            className={({ isActive }) =>
              `flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors ${
                isActive
                  ? 'bg-emerald-50 text-emerald-700'
                  : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'
              }`
            }
          >
            <Icon size={18} />
            {label}
          </NavLink>
        ))}
      </nav>
    </aside>
  );
}
