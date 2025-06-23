
  document.querySelector('.botao button').addEventListener('click', function(event) {
    event.preventDefault(); // Impede o envio do formulário
    document.getElementById('popup-sucesso').style.display = 'flex';
  });

  document.getElementById('fechar-popup').addEventListener('click', function() {
    document.getElementById('popup-sucesso').style.display = 'none';
  });
