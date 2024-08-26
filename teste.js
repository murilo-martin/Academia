function treinoSalvo() {
    const hiddenInputs = document.querySelectorAll('#ids_exerc');
    const valores = {};
  
    hiddenInputs.forEach((input) => {
      valores[input.name] = input.value;
      
    });
  
    
  }