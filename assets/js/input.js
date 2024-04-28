document.addEventListener('DOMContentLoaded', function() {
    const inputElement = document.getElementById('dynamic-input');
    const inputElement2 = document.getElementById('dynamic-input2');
    const inputElement3 = document.getElementById('dynamic-input2');
  
    inputElement.addEventListener('input', function() {
      const inputValue = inputElement.value;
      const charCount = inputValue.length;
      const minWidth = 50;
      const maxWidth = 300;
      const width = Math.min(maxWidth, Math.max(minWidth, charCount * 10));
      
      inputElement.style.width = `${width}px`;
    });
    inputElement2.addEventListener('input', function() {
      const inputValue2 = inputElement2.value;
      const charCount2 = inputValue2.length;
      const minWidth2 = 100;
      const maxWidth2 = 800;
      const width2 = Math.min(maxWidth2, Math.max(minWidth2, charCount2 * 10));
      
      inputElement2.style.width = `${width2}px`;
    });
    inputElement3.addEventListener('input', function() {
      const inputValue2 = inputElement2.value;
      const charCount2 = inputValue2.length;
      const minWidth2 = 150;
      const maxWidth2 = 800;
      const width2 = Math.min(maxWidth2, Math.max(minWidth2, charCount2 * 10));
      
      inputElement2.style.width = `${width2}px`;
    });
  });