export default function PaginationControls({ pagination, onPageChange }) {
  if (!pagination || pagination.last_page <= 1) {
    return null;
  }

  return (
    <div className="mt-4 flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-3 print:hidden">
      <p className="text-sm text-gray-600">
        Page {pagination.current_page} of {pagination.last_page} ({pagination.total} records)
      </p>
      <div className="flex gap-2">
        <button
          type="button"
          disabled={pagination.current_page <= 1}
          onClick={() => onPageChange(pagination.current_page - 1)}
          className="rounded-lg border border-gray-300 px-3 py-1 text-sm disabled:cursor-not-allowed disabled:opacity-50"
        >
          Previous
        </button>
        <button
          type="button"
          disabled={pagination.current_page >= pagination.last_page}
          onClick={() => onPageChange(pagination.current_page + 1)}
          className="rounded-lg border border-gray-300 px-3 py-1 text-sm disabled:cursor-not-allowed disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>
  );
}
