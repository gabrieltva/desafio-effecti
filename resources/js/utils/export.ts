/**
 * Export data to CSV file
 * @param data Array of objects to be exported to CSV
 */
export const exportToCsv = (data: Array<any>) => {
  console.log(data);
  const csvHeader = Object.keys(data[0]).map(escapeCsvValue).join(",") + "\n";
  const csv = csvHeader + data.map(row => Object.values(row).map(escapeCsvValue).join(",")).join("\n");

  const blob = new Blob([csv], { type: 'text/csv' });
  const url = window.URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'users.csv';
  a.click();
  window.URL.revokeObjectURL(url);
};

const escapeCsvValue = (value) => {
  if (typeof value === 'string' && value.includes(',')) {
    return `"${value.replace(/"/g, '""')}"`;
  }
  return value;
};