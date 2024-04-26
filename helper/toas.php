<style>
.messegeku {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f0f0;
}

.messegeku .pesan-container {
  position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 9999;
}

.pesan {
  position: relative;
  padding: 10px 20px;
  background-color: #333;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.3s, transform 0.3s;
  display: flex;
  align-items: center;
  font-family: Arial, sans-serif;
  width: auto;
  max-width: 100%;
}

.pesan.show {
  opacity: 1;
  transform: translateY(0);
}

.icon {
  margin-right: 10px;
  font-size: 20px;
}

.success {
  background-color: #1abc9c;
}

.error {
  background-color: #e74c3c;
}
.warning {
  background-color: #777a1c;
}
</style>
<div class="messegeku">
<div id="pesanContainer" class="pesan-container">
</div>
</div>
<script>
const pesanContainer = document.getElementById('pesanContainer');
const item = <?php echo json_encode($item); ?>;
const messages = [
  { type: 'success', content: 'Pesan berhasil ditampilkan!', condition: 'ok' }, //1
  { type: 'error', content: 'Terjadi kesalahan saat memproses.', condition: 'error' }, //2
  { type: 'warning', content: 'Ini adalah peringatan.', condition: 'warning' }, //3
  { type: 'success', content: 'Data berhasil di import', condition: 'import' },
  { type: 'success', content: item + ' Data berhasil dihapus', condition: 'delete' },
  { type: 'success', content: item + ' Data berhasil diupdate', condition: 'update' },
  { type: 'error', content: 'Terjadi kesalahan saat memproses data.', condition: 'noimport1' },
  { type: 'error', content: 'Terjadi kesalahan saat memproses Import.', condition: 'noimport' },
  { type: 'error', content: 'Terjadi kesalahan saat memproses delete.', condition: 'nodelete' },
  { type: 'error', content: 'Terjadi kesalahan saat memproses update.', condition: 'noupdate' },
];

function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  const results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

messages.forEach(message => {
  const messageParam = getUrlParameter('message');
  const typeParam = message.type;
  const conditionParam = message.condition;

  if (messageParam === conditionParam && typeParam) {
    showpesan(typeParam, message.content);
  }
});

function showpesan(type, message) {
  const newpesan = document.createElement('div');
  newpesan.classList.add('pesan');
  newpesan.classList.add(type);
  
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

  newpesan.appendChild(icon);
  newpesan.appendChild(messageSpan);

  pesanContainer.appendChild(newpesan);

  setTimeout(() => {
    newpesan.classList.add('show');
    setTimeout(() => {
      newpesan.classList.remove('show');
      newpesan.addEventListener('transitionend', () => {
        pesanContainer.removeChild(newpesan);
      });
    }, 5000);
  }, 100);
}
</script>