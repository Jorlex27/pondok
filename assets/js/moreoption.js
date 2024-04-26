function toggleMoreOptions(name) {
    var moreButton = document.getElementById('moreButton_' + name);
    var moreOptions = document.getElementById('moreOptions_' + name);

    if (moreOptions.style.display === 'none') {
        moreOptions.style.display = 'block';
    } else {
        moreOptions.style.display = 'none';
    }
    document.addEventListener('click', function(event) {
    if (!moreButton.contains(event.target)) {
    moreOptions.style.display = 'none';
}
});
}

function moreUser(id) {
    var more = document.getElementById('moreUs' + id);
    var optionMore = document.getElementById('optionUs' + id);

    if (optionMore.style.display === 'none') {
        optionMore.style.display = 'block';
    } else {
        optionMore.style.display = 'none';
    }
    document.addEventListener('click', function(event) {
    if (!more.contains(event.target)) {
        optionMore.style.display = 'none';
}
});
}