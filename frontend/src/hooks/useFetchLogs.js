import { useCallback, useEffect, useState } from 'react';
import { fetchLogs } from '../services/endpoints';

export function useFetchLogs(resourceKey, page = 1) {
  const [data, setData] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const load = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const response = await fetchLogs(resourceKey, page);
      setData(response.data);
    } catch (err) {
      setError(err);
      setData(null);
    } finally {
      setLoading(false);
    }
  }, [resourceKey, page]);

  useEffect(() => {
    load();
  }, [load]);

  return { data, loading, error, reload: load };
}
