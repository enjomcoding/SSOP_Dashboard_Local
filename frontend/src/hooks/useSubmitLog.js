import { useState } from 'react';
import toast from 'react-hot-toast';
import { createLog, deleteLog, updateLog } from '../services/endpoints';

export function useSubmitLog(resourceKey, onSuccess) {
  const [submitting, setSubmitting] = useState(false);

  const save = async (payload, id = null) => {
    setSubmitting(true);
    try {
      if (id) {
        await updateLog(resourceKey, id, payload);
        toast.success('Record updated successfully');
      } else {
        await createLog(resourceKey, payload);
        toast.success('Record created successfully');
      }
      onSuccess?.();
      return true;
    } catch (err) {
      const message = err.response?.data?.message || 'Failed to save record';
      toast.error(message);
      return false;
    } finally {
      setSubmitting(false);
    }
  };

  const remove = async (id) => {
    setSubmitting(true);
    try {
      await deleteLog(resourceKey, id);
      toast.success('Record deleted successfully');
      onSuccess?.();
      return true;
    } catch {
      toast.error('Failed to delete record');
      return false;
    } finally {
      setSubmitting(false);
    }
  };

  return { save, remove, submitting };
}
