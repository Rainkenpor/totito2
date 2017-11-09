var turno=1
$(document).ready(function() {
  // posiciones de ubicacion
  $('.table-totito td').addClass('bloqueo');
  $('#button-iniciar').click(function(){
    $('.table-totito td').removeClass('bloqueo');
    $('.table-totito').removeClass('bloqueo');
    crear_partida(function(id){
      $('.table-totito td').click(function(event) {
        if (!$(this).hasClass('bloqueo')){
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
});

function crear_partida(respuesta){
  $.ajax({
    url: 'include/server.php',
    type: 'POST',
    dataType: 'json',
    data: {opcion: 'crear_partida'},
    success(data){
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
    }
  });

}

validar=[[1,2,3],[4,5,6],[7,8,9],[1,5,9],[3,5,7],[1,4,7],[2,5,8],[3,6,9]];
console.log(validar);

function validando_ganador(){
  console.log('----');
  var array=[];
    $('.table-totito tr').each(function(index, el) {
    $(this).children('td').each(function(index2, el2) {
      posicion=((index*3)+(index2+1));
      // console.log(posicion+'--'+ $(el2).attr('turno'));
      if ($(el2).attr('turno')>0) array.push({posicion:posicion,turno:$(el2).attr('turno')});
    });
  });
  // console.log(array);
  probabilidad(array);
}

function probabilidad(array){
  var listado=[];
  for (var y = 0; y < array.length; y++) {
    console.log(array[y].turno);
    for (var i = 0; i < validar.length; i++) {
      posiciones=validar[i];
      for (var t = 0; t < posiciones.length; t++) {
        if(posiciones[t]==array[y].posicion){
            console.log(validar[i]);
            listado.push({turno:array[y].turno,lista:i});
        }
      }
    }
  }
}
