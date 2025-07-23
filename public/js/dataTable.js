import { PHPFetcher } from './handler_DOM.js';

const rowsPerPage = 10;
let currentPage = 1;
let data = [];

async function fetchDataFromBackend() {
  const myVariable = new PHPFetcher('../backend/controller/');
  const response = await myVariable.fetchData('breakers.php', { query: 'ssfb' }, 'POST');
  data = response.breakers.map((item, index) => ({
    id: item.ID,
    name: item.NAME,
    consumo: (item.CONSUMPTION)/100 + ' kWh',
    temperatura: item.LAST_TEMP + '°C',
    fechaRegistro: item.RECORD_DATE,
    propietario: item.PROPERTY,
    idBreaker: item.ID
  }));
  renderTable(currentPage);
}

function renderTable(page) {
  const tbody = document.querySelector('#table-breakerDisplay tbody');
  tbody.innerHTML = '';

  const start = (page - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const pageData = data.slice(start, end);

  for (const item of pageData) {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.id}</td>
      <td>${item.name}</td>
      <td>${item.consumo}</td>
      <td>${item.temperatura}</td>
      <td>${item.fechaRegistro}</td>
      <td>${item.propietario}</td>
      <td>
        <button class="dashboard-showDetails" IdBreaker="${item.idBreaker}">
          <i class='bx bxs-show bx-md'></i>
        </button>
      </td>
    `;
    tbody.appendChild(row);
  }

  renderPagination();
}

document.addEventListener('DOMContentLoaded', () => {
  fetchDataFromBackend();
});


function renderPagination() {
  const pagination = document.getElementById('pagination');
  pagination.innerHTML = '';
  const pageCount = Math.ceil(data.length / rowsPerPage);

  const maxVisible = 5; // Máximo de botones visibles en medio

  const createButton = (label, page, disabled = false) => {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.disabled = disabled;
    btn.style.margin = '0 3px';
    btn.onclick = () => {
      currentPage = page;
      renderTable(currentPage);
    };
    pagination.appendChild(btn);
  };

  // Botón anterior
  createButton('«', currentPage - 1, currentPage === 1);

  // Página 1
  createButton(1, 1, currentPage === 1);

  // Puntos suspensivos antes
  if (currentPage > maxVisible) {
    const dots = document.createElement('span');
    dots.textContent = '...';
    pagination.appendChild(dots);
  }

  // Páginas del medio
  const start = Math.max(2, currentPage - 2);
  const end = Math.min(pageCount - 1, currentPage + 2);

  for (let i = start; i <= end; i++) {
    createButton(i, i, currentPage === i);
  }

  // Puntos suspensivos después
  if (currentPage < pageCount - 3) {
    const dots = document.createElement('span');
    dots.textContent = '...';
    pagination.appendChild(dots);
  }

  // Última página
  if (pageCount > 1) {
    createButton(pageCount, pageCount, currentPage === pageCount);
  }

  // Botón siguiente
  createButton('»', currentPage + 1, currentPage === pageCount);
}


// Mostrar la tabla al cargar
renderTable(currentPage);