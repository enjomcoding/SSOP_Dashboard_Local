export function exportToCsv(data, columns, filename) {
  if (!data || !data.length) return;

  const headers = columns.map((col) => col.label);

  const rows = data.map((row) =>
    columns.map((col) => {
      let val = '';
      if (col.render) {
        val = col.render(row);
      } else {
        val = row[col.key] ?? '';
      }
      // Escape quotes and wrap in quotes to handle commas
      const escaped = String(val).replace(/"/g, '""');
      return `"${escaped}"`;
    })
  );

  const csvContent = [headers.join(','), ...rows.map((row) => row.join(','))].join('\n');

  const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);

  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', filename);
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
