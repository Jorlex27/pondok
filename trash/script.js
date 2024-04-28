const toastContainer = document.getElementById('toastContainer');

// Function to get URL parameter by name
function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  const results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Get the "message" and "type" parameters from the URL
const messageParam = getUrlParameter('message');
const typeParam = getUrlParameter('type');

if (messageParam && typeParam) {
  // Show the message as a toast notification
  showToast(typeParam, messageParam);
}

function showToast(type, message) {
  const newToast = document.createElement('div');
  newToast.classList.add('toast');
  newToast.classList.add(type);
  
  const icon = document.createElement('i');
  icon.classList.add('icon');
  if (type === 'success') {
    icon.classList.add('fas', 'fa-check-circle');
  } else if (type === 'error') {
    icon.classList.add('fas', 'fa-times-circle');
  } else if (type === 'warning') {
    icon.classList.add('fas', 'fa-exclamation-triangle');
  }

  const messageSpan = document.createElement('span');
  messageSpan.classList.add('message');
  messageSpan.textContent = message;

  newToast.appendChild(icon);
  newToast.appendChild(messageSpan);

  toastContainer.appendChild(newToast);

  setTimeout(() => {
    newToast.classList.add('show');
    setTimeout(() => {
      newToast.classList.remove('show');
      newToast.addEventListener('transitionend', () => {
        toastContainer.removeChild(newToast);
      });
    }, 3000); // Hapus pesan setelah 3 detik
  }, 100);
}
