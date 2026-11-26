<?php
    include("verificar.php");

    $titulo = "Manual de usuario";

    include("menu.php");
?>

    <h2 class="mb-3">Manual de usuario</h2>

    <div class="card shadow-sm">
        <div class="card-body manual">

            <p>Este manual explica cómo usar el sistema de gestión de Kachow Autopartes S.A. para registrar clientes, productos, proveedores, citas de asesoría y ventas, y para obtener reportes y respaldos. Las secciones marcadas como <strong>solo administrador</strong> no aparecen en el menú del vendedor.</p>

            <h5>Contenido</h5>
            <ol>
                <li><a href="#ingreso">Ingresar y salir del sistema</a></li>
                <li><a href="#panel">Panel principal</a></li>
                <li><a href="#clientes">Clientes</a></li>
                <li><a href="#productos">Productos</a></li>
                <li><a href="#citas">Citas de asesoría</a></li>
                <li><a href="#ventas">Ventas</a></li>
                <li><a href="#proveedores">Proveedores</a> <span class="badge bg-secondary">solo administrador</span></li>
                <li><a href="#reportes">Reportes</a> <span class="badge bg-secondary">solo administrador</span></li>
                <li><a href="#respaldo">Respaldo de la base de datos</a> <span class="badge bg-secondary">solo administrador</span></li>
                <li><a href="#mensajes">Mensajes frecuentes</a></li>
            </ol>

            <h4 id="ingreso" class="mt-4">1. Ingresar y salir del sistema</h4>

            <p>Abra el navegador y escriba la dirección del sistema. En la computadora donde está instalado con Laragon es <strong>http://localhost/Kachow</strong>. Escriba su usuario y su contraseña y presione <strong>Ingresar</strong>.</p>

            <img src="manual/login.png" alt="Pantalla de ingreso" class="img-fluid border rounded mb-3 d-block">

            <p>Si el usuario o la contraseña están mal, el sistema muestra "Usuario o contrasena incorrectos" y no deja pasar. Por seguridad no dice cuál de los dos falló.</p>

            <p>Para salir presione <strong>Salir</strong>, arriba a la derecha. Cierre la sesión cada vez que deje la computadora, porque cualquiera que la use después entraría con su usuario.</p>

            <p>Hay dos tipos de usuario. El <strong>administrador</strong> puede usar todo el sistema. El <strong>vendedor</strong> solo ve Clientes, Productos, Citas y Ventas; si intenta abrir otra sección, el sistema lo devuelve al panel con el aviso "No tiene permiso para entrar a esa seccion".</p>

            <h4 id="panel" class="mt-4">2. Panel principal</h4>

            <p>Es la primera pantalla después de ingresar. Las tarjetas muestran cuántos clientes y productos hay, las citas de hoy y las ventas de hoy con su importe. Cada tarjeta tiene un enlace que lleva a su módulo.</p>

            <p>Más abajo está la lista de <strong>productos con stock bajo</strong>: los que tienen un stock igual o menor a su stock mínimo. Conviene revisarla cada mañana para pedir mercadería a tiempo.</p>

            <p>El administrador ve además un recuadro oscuro con el total vendido en el mes. El botón <strong>Manual de usuario</strong> abre este manual.</p>

            <img src="manual/panel.png" alt="Panel principal del administrador" class="img-fluid border rounded mb-3 d-block">

            <p>En el celular el menú se esconde. Se abre con el botón de tres rayas que aparece arriba a la derecha.</p>

            <h4 id="clientes" class="mt-4">3. Clientes</h4>

            <p><strong>Registrar un cliente.</strong> Llene el formulario y presione <strong>Registrar</strong>. El nombre y el documento son obligatorios. El documento lleva solo números, entre 5 y 15, y no puede repetirse. El teléfono, si se escribe, debe tener 7 u 8 números.</p>

            <p><strong>Buscar.</strong> Escriba parte del nombre o del documento en el cuadro de búsqueda y presione <strong>Buscar</strong>. <strong>Ver todos</strong> vuelve a mostrar la lista completa.</p>

            <p><strong>Editar.</strong> Presione el botón amarillo <strong>Editar</strong> del cliente, corrija los datos y presione <strong>Guardar cambios</strong>.</p>

            <p><strong>Eliminar.</strong> Presione el botón rojo <strong>Eliminar</strong> y confirme. Un cliente que ya tiene citas o ventas no se puede eliminar, porque esos registros quedarían sin dueño; el sistema avisa cuántas tiene.</p>

            <img src="manual/clientes.png" alt="Módulo de clientes" class="img-fluid border rounded mb-3 d-block">

            <h4 id="productos" class="mt-4">4. Productos</h4>

            <p>Se registran igual que los clientes. El código no puede repetirse y el precio debe ser mayor que cero. El <strong>stock mínimo</strong> es la cantidad a partir de la cual el producto se considera escaso: cuando el stock llega a ese número o baja de él, aparece en rojo en la lista y en el panel principal.</p>

            <p>El stock baja solo cada vez que se vende el producto y vuelve a subir si se quita de una venta. Solo hace falta editarlo a mano cuando llega mercadería nueva.</p>

            <p>Un producto que ya figura en alguna venta no se puede eliminar.</p>

            <img src="manual/productos.png" alt="Módulo de productos" class="img-fluid border rounded mb-3 d-block">

            <h4 id="citas" class="mt-4">5. Citas de asesoría</h4>

            <p>Elija el cliente, escriba el vehículo, elija la fecha, la hora y el asesor, y presione <strong>Registrar</strong>. El motivo es opcional.</p>

            <p>El <strong>asesor</strong> se elige de una lista con los nombres de los vendedores. La <strong>hora</strong> también se elige de una lista, cada 30 minutos y solo dentro del horario de atención:</p>

            <ul>
                <li>Lunes a viernes: de 08:30 a 12:30 y de 14:30 a 18:30.</li>
                <li>Sábados: de 08:30 a 12:30.</li>
                <li>Domingos: cerrado.</li>
            </ul>

            <p>La última hora de cada turno es media hora antes del cierre, para que la cita termine dentro del horario. Si se elige un sábado por la tarde, un domingo, una fecha pasada o una hora que ya pasó, el sistema no guarda la cita y explica el motivo. Tampoco deja dar dos citas al mismo asesor el mismo día a la misma hora; a otro asesor sí.</p>

            <img src="manual/citas.png" alt="Módulo de citas" class="img-fluid border rounded mb-3 d-block">

            <p>En la lista, cada cita tiene una etiqueta: <strong>Hoy</strong> (verde), <strong>Próxima</strong> (azul) o <strong>Pasada</strong> (gris).</p>

            <h4 id="ventas" class="mt-4">6. Ventas</h4>

            <p>Una venta se registra en dos pasos: primero se crea y después se le agregan los productos.</p>

            <ol>
                <li>En <strong>Ventas</strong>, elija el cliente, el método de pago y la fecha, y presione <strong>Crear venta</strong>.</li>
                <li>Se abre el detalle de la venta. Elija un producto, escriba la cantidad y presione <strong>Agregar</strong>. Repita con cada producto.</li>
                <li>El total se calcula solo y el stock de cada producto baja en ese momento.</li>
            </ol>

            <img src="manual/ventas.png" alt="Creación de una venta" class="img-fluid border rounded mb-3 d-block">

            <p>Si se pide más cantidad de la que hay en stock, el sistema avisa cuántas unidades quedan y no agrega la línea. Si se agrega un producto que ya estaba en la venta, se suma a la misma línea. El botón <strong>Quitar</strong> saca un producto de la venta y devuelve su cantidad al stock.</p>

            <img src="manual/venta_detalle.png" alt="Detalle de una venta" class="img-fluid border rounded mb-3 d-block">

            <p><strong>Si se olvidó registrar una venta.</strong> Puede registrarla después. Al crearla, en el campo <strong>Fecha</strong> elija el día en que realmente se hizo la venta, en lugar de la fecha de hoy. La venta queda guardada con esa fecha, aparece en la lista en el lugar que le corresponde y se cuenta en los reportes de ese día. El stock se descuenta al momento de registrarla. Lo que el sistema no acepta son fechas futuras.</p>

            <p><strong>Eliminar una venta.</strong> El botón rojo <strong>Eliminar</strong> de la lista borra la venta completa y devuelve al stock todos sus productos. Una venta que se creó y quedó sin productos aparece con la etiqueta amarilla "Sin productos"; se puede completar o eliminar.</p>

            <h4 id="proveedores" class="mt-4">7. Proveedores <span class="badge bg-secondary">solo administrador</span></h4>

            <p>Al registrar un proveedor se elige su <strong>rubro</strong>, es decir, el tipo de repuesto que vende: Llantas, Motores, Frenos, Suspensión, Eléctricos, Plásticos, Lubricantes o Accesorios. El NIT lleva solo números y no puede repetirse.</p>

            <p>Arriba de la lista hay un botón por cada rubro, con la cantidad de proveedores entre paréntesis. Al presionar uno, la lista muestra solo los proveedores de ese rubro; <strong>Todos</strong> quita el filtro. Dentro de un rubro también se puede buscar por nombre o por NIT.</p>

            <img src="manual/proveedores.png" alt="Módulo de proveedores con los botones de rubro" class="img-fluid border rounded mb-3 d-block">

            <h4 id="reportes" class="mt-4">8. Reportes <span class="badge bg-secondary">solo administrador</span></h4>

            <p>Elija las fechas <strong>Desde</strong> y <strong>Hasta</strong> y presione <strong>Ver reporte</strong>. El reporte muestra las ventas del período, la cantidad de ventas, el importe total y los productos más vendidos.</p>

            <p>Con los botones de descarga se obtiene el mismo reporte como archivo: <strong>CSV</strong> para abrirlo en Excel (ventas, detalle o productos más vendidos) o <strong>PDF</strong> para imprimirlo, con el total por método de pago.</p>

            <img src="manual/reportes.png" alt="Reporte de ventas" class="img-fluid border rounded mb-3 d-block">

            <h4 id="respaldo" class="mt-4">9. Respaldo de la base de datos <span class="badge bg-secondary">solo administrador</span></h4>

            <p><strong>Crear respaldo ahora</strong> guarda una copia de todos los datos en un archivo .sql con la fecha y la hora en el nombre. Se recomienda hacerlo al final de cada día.</p>

            <p><strong>Descargar</strong> baja el archivo a la computadora. Guárdelo también en una memoria USB o en otro disco: si el disco de la computadora se daña, los respaldos guardados en ella se pierden.</p>

            <p><strong>Restaurar</strong> deja la base de datos exactamente como estaba cuando se hizo ese respaldo. Todo lo que se registró después se pierde, por eso el sistema pide confirmación.</p>

            <img src="manual/respaldo.png" alt="Pantalla de respaldo" class="img-fluid border rounded mb-3 d-block">

            <h4 id="mensajes" class="mt-4">10. Mensajes frecuentes</h4>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr><th>Mensaje</th><th>Qué hacer</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Ya existe un cliente con ese documento</td><td>El cliente ya está registrado. Búsquelo en la lista.</td></tr>
                        <tr><td>Solo hay N unidades en stock</td><td>Venda una cantidad menor o registre la mercadería que llegó.</td></tr>
                        <tr><td>El asesor ya tiene una cita ese dia a esa hora</td><td>Elija otra hora u otro asesor.</td></tr>
                        <tr><td>Los sabados solo se atiende de 08:30 a 12:30</td><td>Elija una hora de la mañana o un día de lunes a viernes.</td></tr>
                        <tr><td>Los domingos no se atiende</td><td>Elija otro día.</td></tr>
                        <tr><td>La fecha de la venta no puede ser futura</td><td>Elija la fecha de hoy o el día en que se hizo la venta.</td></tr>
                        <tr><td>No se puede eliminar: el cliente tiene citas o ventas</td><td>El cliente no se puede borrar. Puede dejarlo registrado.</td></tr>
                        <tr><td>No tiene permiso para entrar a esa seccion</td><td>Esa sección es solo para el administrador.</td></tr>
                    </tbody>
                </table>
            </div>

            <a href="index.php" class="btn btn-secondary">Volver al panel</a>

        </div>
    </div>

<?php include("pie.php"); ?>
