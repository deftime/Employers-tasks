let questions = document.querySelectorAll('.question');

for (let key of questions) {
  key.addEventListener('click', function(){
    this.firstElementChild.classList.toggle('rotate');
    let current = this.nextElementSibling.className.slice(7, 12);
    switch (current) {
      case 'quFir':
        this.nextElementSibling.classList.toggle('openFirst');
        break;
      case 'quSec':
          this.nextElementSibling.classList.toggle('openSecond');
        break;
      case 'quThi':
          this.nextElementSibling.classList.toggle('openThird');
        break;
      default:
        console.log(`ERROR in variable: ${current}`);
    }
  })
}
