  const formulario = document.getElementById('usuarioForm');
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirm_password');

  formulario.addEventListener('submit', function(event) {
    if (passwordInput.value !== confirmPasswordInput.value) {
      alert("Las contraseñas no coinciden.");
      event.preventDefault(); // Evita que se envíe el formulario
    }
  });