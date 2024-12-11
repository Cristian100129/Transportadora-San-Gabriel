function ajustarBuscador() {
  const buscador = document.querySelector('.d-flex[role="search"]');
  const offcanvasBody = document.querySelector('.offcanvas-body');
  const breakpoint = 993; // Defino el breakpoint para pantallas de tamaño 993 

  if (window.innerWidth < breakpoint) {
    // Muevo el buscador al offcanvas 
    offcanvasBody.insertBefore(buscador, offcanvasBody.firstChild); 
  } else {
    // Muevo el buscador de vuelta al navbar
    const navbar = document.querySelector('.navbar .container-fluid');
    navbar.insertBefore(buscador, navbar.querySelector('.navbar-toggler')); 
  }
}
//  Esto es un evento de escucha 
// Llama a la función al cargar la página y al cambiar el tamaño de la ventana
window.addEventListener('load', ajustarBuscador);
window.addEventListener('resize', ajustarBuscador);

const selectorPaginas = document.getElementById('selector-paginas');

selectorPaginas.addEventListener('change', function() {
  const paginaSeleccionada = this.value;
  window.location.href = paginaSeleccionada; 
});
function filtrarPresentaciones() {
  // Obtener el término de búsqueda
  var terminoBusqueda = document.getElementById("busqueda").value.toLowerCase();

  // Obtener todas las presentaciones
  var presentaciones = document.querySelectorAll(".col__video");
  presentaciones.forEach(function(presentacion) {
    var titulo = presentacion.querySelector(".col__titulo").textContent.toLowerCase();
    if (titulo.includes(terminoBusqueda)) {
      presentacion.style.display = "block";
    } else {
      presentacion.style.display = "none";
    }
  });
}