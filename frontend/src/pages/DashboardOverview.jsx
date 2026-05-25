import {
  Bar,
  BarChart,
  CartesianGrid,
  Cell,
  Pie,
  PieChart,
  ResponsiveContainer,
  Tooltip,
  XAxis,
  YAxis,
} from 'recharts';
import { Activity, Bug, PackageCheck, ClipboardList } from 'lucide-react';
import TopHeader from '../components/TopHeader';
import TableSkeleton from '../components/TableSkeleton';
import { useAnalytics } from '../hooks/useAnalytics';

const PIE_COLORS = ['#059669', '#dc2626'];

function MetricCard({ icon: Icon, label, value, detail }) {
  return (
    <div className="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
      <div className="flex items-center gap-3">
        <div className="rounded-lg bg-emerald-50 p-2 text-emerald-700">
          <Icon size={20} />
        </div>
        <div>
          <p className="text-sm text-gray-500">{label}</p>
          <p className="text-2xl font-bold text-gray-900">{value}</p>
          {detail && <p className="text-xs text-gray-500">{detail}</p>}
        </div>
      </div>
    </div>
  );
}

export default function DashboardOverview() {
  const { data, loading, error } = useAnalytics();

  if (loading) {
    return (
      <>
        <TopHeader title="Analytics Overview" subtitle="Sanitation Standard Operating Procedures" />
        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
          {Array.from({ length: 4 }).map((_, i) => (
            <div key={i} className="h-24 animate-pulse rounded-lg bg-gray-200" />
          ))}
        </div>
        <div className="mt-6 grid gap-6 lg:grid-cols-2">
          <TableSkeleton rows={6} cols={1} />
          <TableSkeleton rows={6} cols={1} />
        </div>
      </>
    );
  }

  if (error || !data) {
    return (
      <>
        <TopHeader title="Analytics Overview" subtitle="Sanitation Standard Operating Procedures" />
        <div className="rounded-lg border border-red-200 bg-red-50 p-6 text-red-700">
          Unable to load analytics. Ensure the API server is running.
        </div>
      </>
    );
  }

  const pestTotal = data.pest_activity_counts?.total ?? 0;

  return (
    <>
      <TopHeader
        title="Analytics Overview"
        subtitle="Sanitation Standard Operating Procedures"
      />

      <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <MetricCard
          icon={ClipboardList}
          label="Total Logs This Month"
          value={data.total_logs_this_month}
        />
        <MetricCard
          icon={Bug}
          label="Pest Activity Records"
          value={pestTotal}
          detail={`Truck: ${data.pest_activity_counts?.delivery_truck ?? 0} · Control: ${data.pest_activity_counts?.pest_control ?? 0}`}
        />
        <MetricCard
          icon={PackageCheck}
          label="Raw Material Acceptance"
          value={`${data.raw_material_acceptance_rate}%`}
          detail={`${data.raw_material_totals?.accepted ?? 0} accepted / ${data.raw_material_totals?.total ?? 0} total`}
        />
        <MetricCard
          icon={Activity}
          label="Rejected Materials"
          value={data.raw_material_totals?.rejected ?? 0}
        />
      </div>

      <div className="mt-6 grid gap-6 lg:grid-cols-2">
        <div className="rounded-lg border border-gray-200 bg-white p-5">
          <h3 className="mb-4 text-lg font-semibold text-gray-900">Logs (Last 7 Days)</h3>
          <ResponsiveContainer width="100%" height={280}>
            <BarChart data={data.inspections_last_7_days}>
              <CartesianGrid strokeDasharray="3 3" stroke="#e5e7eb" />
              <XAxis dataKey="label" tick={{ fontSize: 12 }} />
              <YAxis allowDecimals={false} tick={{ fontSize: 12 }} />
              <Tooltip />
              <Bar dataKey="count" fill="#059669" radius={[4, 4, 0, 0]} />
            </BarChart>
          </ResponsiveContainer>
        </div>

        <div className="rounded-lg border border-gray-200 bg-white p-5">
          <h3 className="mb-4 text-lg font-semibold text-gray-900">Packaging Condition (GOOD vs DAMAGED)</h3>
          <ResponsiveContainer width="100%" height={280}>
            <PieChart>
              <Pie
                data={data.material_condition_chart}
                dataKey="value"
                nameKey="name"
                cx="50%"
                cy="50%"
                innerRadius={60}
                outerRadius={100}
                paddingAngle={2}
                label={({ name, value }) => `${name}: ${value}`}
              >
                {data.material_condition_chart?.map((entry, index) => (
                  <Cell key={entry.name} fill={PIE_COLORS[index % PIE_COLORS.length]} />
                ))}
              </Pie>
              <Tooltip />
            </PieChart>
          </ResponsiveContainer>
        </div>
      </div>

      <div className="mt-6 rounded-lg border border-gray-200 bg-white p-5">
        <h3 className="mb-3 text-lg font-semibold text-gray-900">Pest Activity Breakdown</h3>
        <div className="flex flex-wrap gap-4">
          <div className="rounded-lg bg-gray-50 px-4 py-2 text-sm">
            <span className="font-medium text-gray-700">Delivery Truck:</span>{' '}
            <span className="text-gray-900">{data.pest_activity_counts?.delivery_truck ?? 0}</span>
          </div>
          <div className="rounded-lg bg-gray-50 px-4 py-2 text-sm">
            <span className="font-medium text-gray-700">Pest Control:</span>{' '}
            <span className="text-gray-900">{data.pest_activity_counts?.pest_control ?? 0}</span>
          </div>
        </div>
      </div>
    </>
  );
}
