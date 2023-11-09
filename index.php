<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: /3.3/login.php');
  exit;
}

if (isset($_GET['insertado'])) {
    echo "<script>alert('Datos insertados correctamente.')</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="estiloss.css"/>
    <link rel="stylesheet" href="jquery-ui/jquery-ui.css" />
    <link rel="stylesheet" href="jquery-ui/jquery-ui.structure.css" />
    <link rel="stylesheet" href="jquery-ui/jquery-ui.theme.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
   

<script>
      $(document).ready(function() {
        $('header').css('background-color', '#E04F56');
      });
    </script>
    <script src="jquery-ui/jquery-ui.js"></script>
    <title>Integradora 3</title>
  </head>
  <body>
    <header>
      <h1>Integradora 3. Animaciones y Efectos Tanya Ortega</h1>
    </header>

    <div class="top-bar">
      <form>
        <div class="search-container">
          <input type="text" id="busqueda" placeholder="Buscar" />
        </div>
      </form>
      <div>
        <button onclick="cerrarSesion()" class="ui-button" id="boton-sesion">Cerrar sesión</button>
      </div>
      <script>
      function cerrarSesion() {
  window.location.href = "/3.3/login.php";
}

    </script>
    </div>
    <div id="personas-scroll">
      <table border="1" id="personas">
      <thead>
    <tr  id="encabezado">
      <th>ID</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Edad</th>
      <th>Teléfono</th>
      <th>Email</th>
      <th>Editar</th>
      <th>Guardar</th>
      <th>Eliminar</th>
    </tr>
  </thead>
        <tbody id="personas-table"></tbody>
      </table>
      <script>
$(document).ready(function() {
  mostrarTodos();
});


function llenarTabla(respuesta) {
  $('#personas-table').empty();
  $.each(respuesta, function(i, persona) {
    var esPrimeraFila = i === 0;

    var fila = '<tr class="persona">' +
                '<td class="editable">' + persona.id + '</td>' +
                 '<td class="editable" data-editable="nombre">' + persona.nombre + '</td>' +
                 '<td class="editable" data-editable="apellido">' + persona.apellido + '</td>' +
                 '<td class="editable" data-editable="edad">' + persona.edad + '</td>' +
                 '<td class="editable" data-editable="telefono">' + persona.telefono + '</td>' +
                 '<td class="editable" data-editable="email">' + persona.email + '</td>' +
                 '<td><button class="editar ui-button" data-id="' + persona.id + '">Editar</button></td>' +
                 '<td><button class="guardar ui-button" data-id="' + persona.id + '">Guardar</button></td>' +
                '<td><button  id="btn-eliminar" class="eliminar ui-button" data-id="' + persona.id + '">Eliminar</button></td>' +
               '</tr>';

    $('#personas-table').append(fila);
    if (esPrimeraFila) {
      $('.persona').first().attr('id', 'encabezado');
    }
    $('#personas-table tr:last').hide().fadeIn(1000); //efecto fadein!!!
  });
  showTableRows();
}


function mostrarTodos() {

  $.ajax({
    url: 'todos.php',
    type: 'POST',
    dataType: 'json',
    success: function(respuesta) {
      llenarTabla(respuesta);
    }
  });
}

//BUSQUEDA
$('#busqueda').keyup(function() {
  var consulta = $(this).val();
  // Petición AJAX
  $.ajax({
    url: 'busqueda.php',
    type: 'POST',
    data: { busqueda: consulta },
    dataType: 'json',
    success: function(respuesta) {
      llenarTabla(respuesta);
    }
  });
});


//EDITAR

$(document).on('click', '.editar', function() {
  $('.persona').removeClass('highlight');
  $(this).closest('.persona').addClass('highlight');
  $(this).closest('.persona').find('.guardar').prop('disabled', true);
  $(this).closest('.persona').find('.editable').addClass('active').prop('contenteditable', true);
  $(this).closest('.persona').find('.guardar').prop('disabled', false);
});


$(document).on('click', '.guardar', function() {
  var fila = $(this).closest('.persona');
  var id = fila.find('td:eq(0)').text();
  var nombre = fila.find('td:eq(1)').text();
  var apellido = fila.find('td:eq(2)').text();
  var edad = fila.find('td:eq(3)').text();
  var telefono = fila.find('td:eq(4)').text();
  var email = fila.find('td:eq(5)').text();

  $.ajax({
    url: 'actualizar.php',
    type: 'POST',
    data: { id: id, nombre: nombre, apellido: apellido, edad: edad, telefono: telefono, email: email },
    success: function() {
      fila.removeClass('editando');
    }
  });
});

//ORDENAR COLUMNAS

var ordenAscendente = true;

$('#personas th').click(function() {
  var indice = $(this).index();
  var filas = $('#personas-table tr.persona').get();
  filas.sort(function(a, b) {
    var valorA = parseInt($(a).children('td').eq(indice).text());
    var valorB = parseInt($(b).children('td').eq(indice).text());
    if (ordenAscendente) {
      return (valorA > valorB) ? 1 : -1;
    } else {
      return (valorA < valorB) ? 1 : -1;
    }
  });
  
  $.each(filas, function(i, fila) {
    $('#personas-table').append(fila);
  });
  
  ordenAscendente = !ordenAscendente;
});
      </script>

<div class="paginacion">
  <button id="prev-btn" class="ui-button ui-button-smoothness">Anterior</button>
  <button id="next-btn" class="ui-button ui-button-smoothness">Siguiente</button>
</div>

<script>
  const table = document.getElementById('personas');
const rowsPerPage = 15;
let currentPage = 1;

function showTableRows() {
  const startIndex = (currentPage - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const rows = table.querySelectorAll('tbody tr');
  
  rows.forEach((row, index) => {
    if (index >= startIndex && index < endIndex) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
}
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

prevBtn.addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    showTableRows();
  }
});

nextBtn.addEventListener('click', () => {
  const rows = table.querySelectorAll('tbody tr');
  const lastPage = Math.ceil(rows.length / rowsPerPage);
  
  if (currentPage < lastPage) {
    currentPage++;
    showTableRows();
  }
});

showTableRows(); 
  </script>

  <script>

//ELIMINAR!!!
$(document).on('click', '.eliminar', function() {
  var id = $(this).data('id');
  var fila = $(this).closest('tr');

  if (confirm('¿Estás seguro de que quieres eliminar esta fila?')) {
    $.ajax({
      url: 'eliminar.php',
      type: 'POST',
      data: { id: id },
      success: function() {
        fila.fadeOut(1000, function() {
          $(this).remove();
          alert('Fila eliminada correctamente.');
        });
      }
    });
  }
});

    </script>
        <script>

$(document).ready(function() {
$('form').css('background-color', '#f2f2f2');
$('label').css('display', 'block');
$('input').css('padding', '10px');
$('button').css('background-color', 'blue')
           .css('color', 'white')
           .css('padding', '10px');
});
</script>
<h2>Nuevo Registro</h2>
<div id="nuevo-registro">
  
  <form action="agregar.php" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br>
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido"required><br>
    <label for="edad">Edad:</label>
    <input type="number" id="edad" name="edad" required><br>
    <label for="telefono">Teléfono:</label>
    <input type="tel" id="telefono" name="telefono" required><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>
    <br>
    <button type="submit" class="ui-button ui-button-smoothness" id="guardar" name="submit">Guardar</button>
    <button type="reset" class="ui-button ui-button-smoothness" id="cancelar">Cancelar</button>
  </form>
</div>




<script>
  $(document).ready(function() {
    $( "#dialog" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  });
</script>

<div id="dialog" title="Bienvenido">
  <p>¡Bienvenido al registro de clientes! .</p>
</div>

  </body>
</html>