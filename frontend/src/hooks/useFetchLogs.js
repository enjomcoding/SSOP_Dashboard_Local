import { useCallback, useEffect, useState } from 'react';
import { fetchLogs } from '../services/endpoints';
import { normalizePaginatedResponse } from '../utils/pagination';

export function useFetchLogs(resourceKey, page = 1) {
  const [pagination, setPagination] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const load = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await fetchLogs(resourceKey, page);
      setPagination(normalizePaginatedResponse(response.data));
    } catch (err) {
      setError(err);
      setPagination(null);
    } finally {
      setLoading(false);
    }
  }, [resourceKey, page]);

  useEffect(() => {
    load();
  }, [load]);

  return {
    records: pagination?.records ?? [],
    pagination,
    loading,
    error,
    reload: load,
  };
}
