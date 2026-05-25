export default function FormInput({ label, name, type = 'text', value, onChange, required = false, options = [] }) {
  const inputId = `field-${name}`;

  const baseClass =
    'mt-1 w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900 focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500';

  if (type === 'checkbox') {
    const checked = value === true || value === 1 || value === '1' || value === 'true';
    return (
      <div className="mb-4 flex items-center gap-2">
        <input
          id={inputId}
          name={name}
          type="checkbox"
          checked={checked}
          onChange={(event) => {
            onChange({
              target: { name, value: event.target.checked, type: 'checkbox' },
            });
          }}
          className="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
        />
        <label htmlFor={inputId} className="text-sm font-medium text-gray-700">
          {label}
        </label>
      </div>
    );
  }

  return (
    <div className="mb-4">
      <label htmlFor={inputId} className="block text-sm font-medium text-gray-700">
        {label}
        {required && <span className="ml-1 text-red-500">*</span>}
      </label>
      {type === 'select' ? (
        <select id={inputId} name={name} value={value ?? ''} onChange={onChange} required={required} className={baseClass}>
          <option value="">Select...</option>
          {options.map((option) => (
            <option key={option} value={option}>
              {option}
            </option>
          ))}
        </select>
      ) : type === 'textarea' ? (
        <textarea
          id={inputId}
          name={name}
          value={value ?? ''}
          onChange={onChange}
          rows={3}
          className={baseClass}
        />
      ) : (
        <input
          id={inputId}
          name={name}
          type={type}
          value={value ?? ''}
          onChange={onChange}
          required={required}
          className={baseClass}
        />
      )}
    </div>
  );
}
