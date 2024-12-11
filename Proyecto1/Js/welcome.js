const tipoSelect = document.getElementById('tipo');
  const camposAdicionales = document.getElementById('campos-adicionales');
  const contenedorVideo = document.getElementById('contenedor-video');
  const contenedorImagen = document.getElementById('contenedor-imagen');
  const contenedorTextoBanner = document.getElementById('contenedor-texto-banner');
  const contenedorDuracion = document.getElementById('contenedor-duracion');
  const infoPresentacion = document.getElementById('info-presentacion');
  const programacion = document.getElementById('programacion');

  // Oculta campos adicionales al inicio
  camposAdicionales.style.display = 'none';

  tipoSelect.addEventListener('change', function() {
    const tipo = this.value;

    // Oculta todos los contenedores
    contenedorVideo.style.display = 'none';
    contenedorImagen.style.display = 'none';
    contenedorTextoBanner.style.display = 'none';
    contenedorDuracion.style.display = 'none';
    infoPresentacion.style.display = 'none';
    programacion.style.display = 'none';

    // Muestra los contenedores según el tipo de presentación
    if (tipo) { 
      camposAdicionales.style.display = 'block';
      infoPresentacion.style.display = 'block';
      programacion.style.display = 'block';

      if (tipo === 'VT') {
        contenedorVideo.style.display = 'block';
      } else if (tipo === 'VBL') {
        contenedorVideo.style.display = 'block';
        contenedorImagen.style.display = 'block';
        contenedorTextoBanner.style.display = 'block';
      } else if (tipo === 'BT') {
        contenedorImagen.style.display = 'block';
        contenedorDuracion.style.display = 'block';
      }
    } else {
      camposAdicionales.style.display = 'none';
    }
  });
  document.getElementById('presentacionForm').addEventListener('submit', function(event) {
    var tipo = document.getElementById('tipo').value;
  
    if (tipo === 'VT') {
      if (!document.getElementById('titulo').value || !document.getElementById('video').files[0]) {
        alert('Por favor, completa todos los campos requeridos para este tipo de presentación (VT).');
        event.preventDefault(); 
      }
    } else if (tipo === 'VBL') {
      if (!document.getElementById('titulo').value || !document.getElementById('video').files[0] || !document.getElementById('imagen').files[0] || !document.getElementById('texto_banner').value) {
        alert('Por favor, completa todos los campos requeridos para este tipo de presentación (VBL).');
        event.preventDefault();
      }
    } else if (tipo === 'BT') {
      if (!document.getElementById('titulo').value || !document.getElementById('imagen').files[0] || !document.getElementById('duracion').value) {
        alert('Por favor, completa todos los campos requeridos para este tipo de presentación (BT).');
        event.preventDefault();
      }
    }
  });