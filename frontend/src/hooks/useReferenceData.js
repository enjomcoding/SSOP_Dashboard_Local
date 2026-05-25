import { useCallback, useEffect, useState } from 'react';
import { fetchProducts, fetchSuppliers, fetchUsers } from '../services/endpoints';

export function useReferenceData() {
  const [users, setUsers] = useState([]);
  const [suppliers, setSuppliers] = useState([]);
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const load = useCallback(async () => {
    setLoading(true);
    setError(null);
    try {
      const [usersRes, suppliersRes, productsRes] = await Promise.all([
        fetchUsers(),
        fetchSuppliers(),
        fetchProducts(),
      ]);
      setUsers(usersRes.data);
      setSuppliers(suppliersRes.data);
      setProducts(productsRes.data);
    } catch (err) {
      setError(err);
      setUsers([]);
      setSuppliers([]);
      setProducts([]);
    } finally {
      setLoading(false);
    }
  }, []);

  useEffect(() => {
    load();
  }, [load]);

  const optionsFor = (referenceKey) => {
    if (referenceKey === 'users') {
      return users.map((user) => ({
        value: user.id,
        label: `${user.full_name} (${user.initials})`,
      }));
    }
    if (referenceKey === 'suppliers') {
      return suppliers.map((supplier) => ({
        value: supplier.id,
        label: supplier.name,
      }));
    }
    if (referenceKey === 'products') {
      return products.map((product) => ({
        value: product.id,
        label: product.category ? `${product.name} — ${product.category}` : product.name,
      }));
    }
    return [];
  };

  return { users, suppliers, products, loading, error, reload: load, optionsFor };
}
