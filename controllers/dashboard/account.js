/*
*   Controlador de uso general en las páginas web del sitio privado.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/dashboard/usuario.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.
const HEADER = document.querySelector('header');
const FOOTER = document.querySelector('footer');

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const JSON = await dataFetch(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (JSON.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            HEADER.innerHTML = `
            <div class="sidebar">
                <a href="dashboard.html">
                    <span class="material-icons-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>
                <a href="usuarios.html" class="active">
                    <span class="material-icons-sharp">person_outline</span>
                    <h3>Usuarios</h3>
                </a>
                <a href="productos.html">
                    <span class="material-icons-sharp">receipt_long</span>
                    <h3>Productos</h3>
                </a>
                <a href="categorias.html">
                    <span class="material-icons-sharp">insights</span>
                    <h3>Categorias</h3>
                </a>
                <a href="marcas.html">
                    <span class="material-icons-sharp">mail_outline</span>
                    <h3>Marcas</h3>
                    <span class="message-count">26</span>
                </a>
                <a href="valoraciones.html">
                    <span class="material-icons-sharp">inventory</span>
                    <h3>Valoraciones</h3>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">settings</span>
                    <h3>Ajustes</h3>
                </a>
                <a href="productos.html">
                    <span class="material-icons-sharp">add</span>
                    <h3>Agregar producto</h3>
                </a>
                <a href="index.html">
                    <span class="material-icons-sharp">logout</span>
                    <h3>Cerrar sesion</h3>
                </a>
            </div>
        </aside>
            `;
            FOOTER.innerHTML = `
            <div class="usuario_notificaciones-nav" >
                    <div class="directorio" id="menu-btn">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="profile-cuenta">
                        <div>
                            <span class="material-icons-sharp">
                                notifications
                            </span>
                        </div>
                        <div>
                            <span class="material-icons-sharp">
                                account_circle
                            </span>
                        </div>
                        <a href="">Billy Cañas</a>
                        <div>
                            <span class="material-icons-sharp">
                                expand_more
                            </span>
                        </div>
                    </div>
                </div>
            `;
            // Se inicializa el componente Dropdown para que funcione la lista desplegable en los menús.
            M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));
            // Se inicializa el componente Sidenav para que funcione la navegación lateral.
            M.Sidenav.init(document.querySelectorAll('.sidebar'));
        } else {
            sweetAlert(3, JSON.exception, false, 'index.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname == '/tecnomaster/views/dashboard/index.html') {
            HEADER.innerHTML = `
                <div class="navbar-fixed">
                    <nav>
                        <div class="nav-wrapper center-align">
                            <a href="index.html" class="brand-logo"><i class="material-icons">dashboard</i></a>
                        </div>
                    </nav>
                </div>
            `;
            
            // Se inicializa el componente Tooltip para que funcionen las sugerencias textuales.
            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        } else {
            location.href = 'index.html';
        }
    }
});