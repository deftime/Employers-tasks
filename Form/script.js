let buttOpen = document.querySelector('#startReg');
let buttClose = document.querySelector('.cross');
let dark = document.querySelector('.darker');
let formBlock = document.querySelector('.openWrap');
let rez = document.querySelector('.rezMsg');
let rezPh = document.querySelector('.phMsg');
let form = document.forms.mainForm;


buttOpen.addEventListener('click', () => {
  dark.style.display = 'block';
  formBlock.style.display = 'block';
})

buttClose.addEventListener('click', () => {
  dark.style.display = '';
  formBlock.style.display = '';
})

form.addEventListener('submit', event => {
  event.preventDefault();

  if (!/[а-яЁё]/ig.test(form.elements.passFirst.value) && form.elements.passFirst.value.length >= 8 && form.elements.passFirst.value == form.elements.passSecond.value) {
    rez.innerHTML = 'Регистрация прошла успешно.';
    rez.style.color = 'green';
  } else {
    rez.innerHTML = 'Пароли должны совпадать, состоять минимум из 8 знаков и не содержать буквы кирилицы!';
    rez.style.color = 'red';
  }
})

form.elements.phone.addEventListener('blur', function() {
  if (!/^\+38\d{3}\d{3}\d{2}\d{2}$/i.test(this.value)) {
    rezPh.innerHTML = 'Неверный формат!';
    this.style.border = '1px solid red';
  }
})

form.elements.phone.addEventListener('focus', function() {
  rezPh.innerHTML = '';
  this.style.border = '1px solid #2f4feb';
})
