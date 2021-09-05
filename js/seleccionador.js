 var Raiz;
 var Siguiente;
 var Actual;

function SiNo(hacer)
{
 switch (hacer)
 {
  case 'M_Rut': //Mostar Busqueda Am por Rut
   document.getElementById("tabla4").style.display='block';
   document.getElementById("tabla2").style.display='none';
   document.getElementById("alertaBD").style.display='none';
   document.getElementById("tabla").style.display='none';
  break;
  case 'M_ApPat': //Mostar Busqueda Am por Apellido Paterno
   document.getElementById("tabla2").style.display='block';
   document.getElementById("tabla4").style.display='none';
   document.getElementById("alertaBD").style.display='none';
  document.getElementById("tabla").style.display='none';
  break;
  
  }
}
