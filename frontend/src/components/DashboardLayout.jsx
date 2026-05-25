import { Outlet } from 'react-router-dom';
import Sidebar from './Sidebar';
import TopHeader from './TopHeader';

export default function DashboardLayout({ title, subtitle, action }) {
  return (
    <div className="flex min-h-screen bg-gray-50">
      <Sidebar />
      <main className="flex-1 overflow-auto p-8">
        {(title || action) && <TopHeader title={title} subtitle={subtitle} action={action} />}
        <Outlet />
      </main>
    </div>
  );
}
