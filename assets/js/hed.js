const profileImage = document.getElementById('profileImage');
const dropdownContent = document.getElementById('dropdownContent');

profileImage.addEventListener('click', function() {
  dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
});

// Close dropdown when clicking outside of it
document.addEventListener('click', function(event) {
  if (!profileImage.contains(event.target)) {
    dropdownContent.style.display = 'none';
  }
});