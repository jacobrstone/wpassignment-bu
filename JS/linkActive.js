let links = document.querySelectorAll('li');

links.forEach(link => {
    link.addEventListener('click', function () {
        links.forEach(lnk => lnk.classList.remove('active'));
        this.classList.add('active');        
    });
});