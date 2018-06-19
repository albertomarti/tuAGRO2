    $(document).ready(function(){

               var datos=[];
                  datos.push({
                    "operacion": "obtenerSesion"
                  }); 
              var usuario = {"datos": datos};   
              var json = JSON.stringify(usuario);

              ajax("../servidor/usuario.php", {"json": json}).done(function(info) {
                   var obj = jQuery.parseJSON(info);

                   if(obj.length == 0){
                     window.location="../index.html";
                   }else{
                     if(obj.tipo == "administrador"){
                        window.location="../WebContent/administrador/inicio.html";
                     }else{
                        window.location="../WebContent/usuario/inicio.html";
                     }
                   }


              });
  });

         function ajax(url, data){

            var ajax = $.ajax({
                "url": url,
                "data": data,
                "type": "POST",

              
              });
               return ajax;

          }