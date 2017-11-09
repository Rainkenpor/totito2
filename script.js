var turno=1
$(document).ready(function() {
  // posiciones de ubicacion
  $('.table-totito td').addClass('bloqueo');
  $('#button-iniciar').click(function(){location.reload()});
    // if ($(this).attr('tipo')==1){$(this).attr({'tipo':2});$(this).html("Refrescar");}else{;$('#button-iniciar').click()}
    $('.table-totito td').removeClass('bloqueo');
    $('.table-totito').removeClass('bloqueo');
    crear_partida(function(id){
      $('.table-totito td').click(function(event) {
        if (!$(this).hasClass('bloqueo') && !$('.table-totito').hasClass('bloqueo')  ){
          $(this).attr({turno:turno});
          movimiento_partida(id,$(this).attr('posicion'),turno);
          if (turno==1){
            $(this).html('<span class=" icon-cancel" ></span>');
            turno=2;
          }else{
            $(this).html('<span class="icon-circle-empty"></span>');
            turno=1;
          }
          $(this).addClass('bloqueo');

          // validando_ganador();
        }
      });
    });

});

function crear_partida(respuesta){
  $.ajax({
    url: 'include/server.php',
    type: 'POST',
    dataType: 'json',
    data: {opcion: 'crear_partida'},
    success(data){
      console.log(data);
      respuesta(data);
    }
  });
}

function movimiento_partida(id,posicion,turno){
  $.ajax({
    url: 'include/server.php',
    type: 'POST',
    dataType: 'json',
    data: {opcion: 'movimiento_partida',id:id,posicion:posicion,turno:turno},
    success(data){
      console.log(data);
      $('#log').html('');
      if (data.ganador>0){
        $('#log').append('<div class="alert alert-success">Ganador Jugador: '+data.ganador+'</div>');
        $('.table-totito').addClass('bloqueo');
      }else{
        if (turno==1) analizador(data.contricante,data.movimientos,data.viables,data.disponibles);
      }
      // if (data.opciones)  $('#log').append('<hr><p>Opciones</p>'+data.opciones.join('<br>'));
      if (data.contricante)  $('#log').append('<hr><p>Contricante</p>'+data.contricante.join('<br>'));
      if (data.movimientos)  $('#log').append('<hr><p>Movimientos</p>'+data.movimientos.join('<br>'));
      if (data.viables)  $('#log').append('<hr><p>Viables</p>'+data.viables.join('<br>'));
      if (data.disponibles)  $('#log').append('<hr><p>Disponibles</p>'+data.disponibles.join('<br>'));



      console.log(data);
    }
  });
}

function analizador(contrincante,movimientos,viables,disponibles){
  // aleatorio
  if (movimientos){
    console.log('encontrado movimiento');
    var max=movimientos.length;var aleatorio= Math.floor(Math.random() * (max));
    $('.table-totito td[posicion="'+movimientos[aleatorio]+'"]').click();
    return false;
  }
  if (contrincante){
    console.log('encontrado contrincante');
    console.log(contrincante.length);
    var max=contrincante.length;var aleatorio= Math.floor(Math.random() * (max));
    $('.table-totito td[posicion="'+contrincante[aleatorio]+'"]').click();
    return false;
  }

  if (viables){
    console.log('encontrado viable');
    var max=viables.length;var aleatorio= Math.floor(Math.random() * (max));
    $('.table-totito td[posicion="'+viables[aleatorio]+'"]').click();
    return false;
  }
  if (disponibles){
      console.log('encontrado disponible');
      var max=disponibles.length;var aleatorio= Math.floor(Math.random() * (max));
      $('.table-totito td[posicion="'+disponibles[aleatorio]+'"]').click();
      return false;
  }
}
