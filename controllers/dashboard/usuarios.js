const USUARIO_API = 'api/business/dashboard/usuario.php';
const SEARCH_FORM = document.getElementById('search-form');
const SAVE_FORM = document.getElementById('save-form');
const MODAL_TITLE = document.getElementById('modal-title');
const TBODY_ROWS = document.getElementById('tbody-rows');
const RECORDS = document.getElementById('records');

const OPTIONS = {
    dismissible: false
}

//M.Modal.init(document.querySelectorAll('.modal'), OPTIONS);
//const SAVE_MODAL = M.Modal.getInstance(document.getElementById('save-modal'));

//document.addEventListener('DOMContentLoaded', () => {
    //filltable();
//});

SEARCH_FORM.addEventListener('boton-productos_filtrar', (event) => {
    event.preventDefault();
    const FORM = new FormData(SEARCH_FORM);
    fillTable(FORM);
});

SAVE_FORM.addEventListener('boton-productos_filtrar', async (event) => {
    event.preventDefault();
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    const FORM = new FormData(SAVE_FORM);
    const JSON = await dataFetch(USUARIO_API, action, FORM);
    if (JSON.status) {
        fillTable();
        SAVE_MODAL.close();
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


async function fillTable(form = null) {
    TBODY_ROWS.innerHTML = '';
    RECORDS.textContent = '';
    (form) ? action = 'search' : action = 'readAll';
    const JSON = await dataFetch(USUARIO_API, action, form);
    if (JSON.status) {
        JSON.dataset.forEach(row => {
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td>${row.nombre_usuario}</td>
                    <td>${row.apellido_usuario}</td>
                    <td>${row.correo_usuario}</td>
                    <td>${row.alias_usuario}</td>
                    <td>${row.Estado_usuario}</td>
                    <td>${row.Tipo_usuario}</td>
                    <td>
                        <a onclick="openUpdate(${row.id_usuario})" class="btn waves-effect blue tooltipped" data-tooltip="Actualizar">
                            <i class="material-icons">mode_edit</i>
                        </a>
                        <a onclick="openDelete(${row.id_usuario})" class="btn waves-effect red tooltipped" data-tooltip="Eliminar">
                            <i class="material-icons">delete</i>
                        </a>
                    </td>
                </tr>
            `;
        });
        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        RECORDS.textContent = JSON.message;
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

function openCreate() {
    SAVE_MODAL.open();
    SAVE_FORM.reset();
    MODAL_TITLE.textContent = 'Crear usuario';
    document.getElementById('alias').disabled = false;
    document.getElementById('clave').disabled = false;
    document.getElementById('confirmar').disabled = false;
}

async function openUpdate(id) {
    const FORM = new FormData();
    FORM.append('id_usuario', id);
    const JSON = await dataFetch(USUARIO_API, 'readOne', FORM);
    if (JSON.status) {
        SAVE_MODAL.open();
        SAVE_FORM.reset();
        MODAL_TITLE.textContent = 'Actualizar usuario';
        document.getElementById('alias').disabled = true;
        document.getElementById('clave').disabled = true;
        document.getElementById('confirmar').disabled = true;
        document.getElementById('id').value = JSON.dataset.id_usuario;
        document.getElementById('nombre').value = JSON.dataset.nombre_usuario;
        document.getElementById('apellido').value = JSON.dataset.apellido_usuario;
        document.getElementById('correo').value = JSON.dataset.correo_usuario;
        document.getElementById('alias').value = JSON.dataset.alias_usuario;
        M.updateTextFields();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openDelete(id) {
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
    if (RESPONSE) {
        const FORM = new FormData();
        FORM.append('id_usuario', id);
        const JSON = await dataFetch(USUARIO_API, 'delete', FORM);
        if (JSON.status) {
            fillTable();
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}