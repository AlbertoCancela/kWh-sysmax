const rowsPerPage = 10;
let currentPage = 1;

let _tableId, _rowTemplate, _data;

export function renderTable(page, tableId, rowTemplate, data) {
  _tableId = tableId;
  _rowTemplate = rowTemplate;
  _data = data;
  currentPage = page;

  const tbody = document.querySelector(`#${_tableId} tbody`);
  if (!tbody) return;
  tbody.innerHTML = '';

  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const pageData = _data.slice(start, end);

  for (const item of pageData) {
    const tr = document.createElement('tr');
    tr.innerHTML = _rowTemplate(item);
    tbody.appendChild(tr);
  }

  renderPagination();
}

function renderPagination() {
  const pagination = document.getElementById('pagination');
  if (!pagination) return;
  pagination.innerHTML = '';

  const pageCount = Math.ceil(_data.length / rowsPerPage);
  const maxVisible = 5;

  const createButton = (label, page, disabled = false) => {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.disabled = disabled;
    btn.style.margin = '0 3px';
    btn.addEventListener('click', () => {
      if (page < 1 || page > pageCount) return;
      renderTable(page, _tableId, _rowTemplate, _data); // ← siempre con todos los args
    });
    pagination.appendChild(btn);
  };

  createButton('«', currentPage - 1, currentPage === 1);

  createButton(1, 1, currentPage === 1);

  if (currentPage > maxVisible) {
    const dots = document.createElement('span');
    dots.textContent = '...';
    pagination.appendChild(dots);
  }

  const start = Math.max(2, currentPage - 2);
  const end = Math.min(pageCount - 1, currentPage + 2);
  for (let i = start; i <= end; i++) {
    createButton(i, i, currentPage === i);
  }

  if (currentPage < pageCount - 3) {
    const dots = document.createElement('span');
    dots.textContent = '...';
    pagination.appendChild(dots);
  }

  if (pageCount > 1) {
    createButton(pageCount, pageCount, currentPage === pageCount);
  }

  createButton('»', currentPage + 1, currentPage === pageCount);
}
