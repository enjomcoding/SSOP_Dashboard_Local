import { useMemo, useState } from 'react';
import { Plus } from 'lucide-react';
import DataTable from '../components/DataTable';
import FormInput from '../components/FormInput';
import Modal from '../components/Modal';
import PaginationControls from '../components/PaginationControls';
import TableSkeleton from '../components/TableSkeleton';
import TopHeader from '../components/TopHeader';
import { resourceColumns, resourceFields, resourceMeta } from '../config/resourceFields';
import { useFetchLogs } from '../hooks/useFetchLogs';
import { useSubmitLog } from '../hooks/useSubmitLog';

const emptyForm = (fields) =>
  fields.reduce((acc, field) => {
    if (field.type === 'checkbox') {
      acc[field.name] = field.name === 'within_specs' || field.name === 'standard_met' || field.name === 'sanitized' || field.name === 'fifo_fefo_followed';
    } else if (field.type === 'number') {
      acc[field.name] = '';
    } else {
      acc[field.name] = '';
    }
    return acc;
  }, {});

const formatForInput = (field, value) => {
  if (field.type === 'checkbox') {
    return value === true || value === 1 || value === '1';
  }
  if (!value && value !== 0) return field.type === 'checkbox' ? false : '';
  if (field.type === 'time') {
    return String(value).slice(0, 5);
  }
  if (field.type === 'date') {
    return String(value).slice(0, 10);
  }
  return value;
};

const buildPayload = (fields, form) => {
  const payload = { ...form };
  fields.forEach((field) => {
    if (field.type === 'number' && payload[field.name] !== '') {
      payload[field.name] = Number(payload[field.name]);
    } else if (field.type === 'checkbox') {
      payload[field.name] = Boolean(payload[field.name]);
    } else if (payload[field.name] === '') {
      payload[field.name] = null;
    }
  });
  return payload;
};

export default function MonitoringPage({ resourceKey }) {
  const meta = resourceMeta[resourceKey];
  const fields = resourceFields[resourceKey];
  const columns = resourceColumns[resourceKey];

  const [page, setPage] = useState(1);
  const [modalOpen, setModalOpen] = useState(false);
  const [editing, setEditing] = useState(null);
  const [form, setForm] = useState(emptyForm(fields));
  const [deleteTarget, setDeleteTarget] = useState(null);

  const { data, loading, reload } = useFetchLogs(resourceKey, page);
  const { save, remove, submitting } = useSubmitLog(resourceKey, () => {
    setModalOpen(false);
    setEditing(null);
    setForm(emptyForm(fields));
    reload();
  });

  const records = data?.data ?? [];

  const openCreate = () => {
    setEditing(null);
    setForm(emptyForm(fields));
    setModalOpen(true);
  };

  const openEdit = (row) => {
    setEditing(row);
    const nextForm = emptyForm(fields);
    fields.forEach((field) => {
      nextForm[field.name] = formatForInput(field, row[field.name]);
    });
    setForm(nextForm);
    setModalOpen(true);
  };

  const handleChange = (event) => {
    const { name, value, type, checked } = event.target;
    setForm((prev) => ({
      ...prev,
      [name]: type === 'checkbox' ? checked : value,
    }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    const payload = buildPayload(fields, form);
    await save(payload, editing?.id);
  };

  const handleDelete = async () => {
    if (!deleteTarget) return;
    const ok = await remove(deleteTarget.id);
    if (ok) {
      setDeleteTarget(null);
      reload();
    }
  };

  const headerAction = useMemo(
    () => (
      <button
        type="button"
        onClick={openCreate}
        className="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700"
      >
        <Plus size={16} />
        New Record
      </button>
    ),
    []
  );

  return (
    <>
      <TopHeader
        title={meta.title}
        subtitle="Manage monitoring records with full CRUD operations"
        action={headerAction}
      />

      {loading ? (
        <TableSkeleton cols={columns.length + 1} />
      ) : (
        <DataTable columns={columns} data={records} onEdit={openEdit} onDelete={setDeleteTarget} />
      )}

      <PaginationControls pagination={data} onPageChange={setPage} />

      <Modal
        isOpen={modalOpen}
        title={editing ? 'Edit Record' : 'New Record'}
        onClose={() => setModalOpen(false)}
        footer={
          <div className="flex justify-end gap-2">
            <button
              type="button"
              onClick={() => setModalOpen(false)}
              className="rounded-lg border border-gray-300 px-4 py-2 text-sm"
            >
              Cancel
            </button>
            <button
              type="submit"
              form="monitoring-form"
              disabled={submitting}
              className="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 disabled:opacity-50"
            >
              {submitting ? 'Saving...' : 'Save'}
            </button>
          </div>
        }
      >
        <form id="monitoring-form" onSubmit={handleSubmit}>
          {fields.map((field) => (
            <FormInput
              key={field.name}
              label={field.label}
              name={field.name}
              type={field.type}
              value={form[field.name]}
              onChange={handleChange}
              required={field.required}
              options={field.options}
            />
          ))}
        </form>
      </Modal>

      <Modal
        isOpen={!!deleteTarget}
        title="Confirm Delete"
        onClose={() => setDeleteTarget(null)}
        footer={
          <div className="flex justify-end gap-2">
            <button
              type="button"
              onClick={() => setDeleteTarget(null)}
              className="rounded-lg border border-gray-300 px-4 py-2 text-sm"
            >
              Cancel
            </button>
            <button
              type="button"
              onClick={handleDelete}
              disabled={submitting}
              className="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 disabled:opacity-50"
            >
              Delete
            </button>
          </div>
        }
      >
        <p className="text-sm text-gray-600">
          Are you sure you want to delete this record? This action cannot be undone.
        </p>
      </Modal>
    </>
  );
}
