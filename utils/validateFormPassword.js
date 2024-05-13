function validateForm() {
  var password = document.getElementById('password').value;
  var password2 = document.getElementById('password2').value;

  if (password !== password2) {
    alert('As senhas não são iguais. Por favor, verifique e tente novamente.');
    return false; // Impede o envio do formulário
  }
  return true; // Permite o envio do formulário se as senhas forem iguais
}
