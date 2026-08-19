const runAnimaJS = {
    animElems: document.querySelectorAll('.js-anima'),
    checkRun: false,
    init({
             viewpart = 0.3
         } = {}) {

        if (this.animElems.length < 1) return;

        // Подготовка стартовых состояний анимаций, требующих JS
        this.drawRight(true);
        this.typingText(true);
        this.typingHard(true);

        // Глобальных запуск любой готовой анимации, попадающей в зону видимости
        // elem - DOM-элемент, на котором сработал observer
        this.runObserver('.js-anima', this.runAnim, viewpart);

    },
    // Универсальная функция, которая запускает смену состояния элемента.
    // Или запускает дополнительные методы анимаций, требующих JS.
    runAnim(elem, all) {
        if (elem.classList.contains('anima-done')) return;
        elem.classList.add('anima-done');
        if (elem.classList.contains('anima-drawRight')) {
            runAnimaJS.drawRight(false, elem);
        }
        if (elem.classList.contains('anima-elemByElem')) {
            runAnimaJS.elemByElem(elem);
        }
        if (elem.classList.contains('anima-typingText')) {
            runAnimaJS.typingText(false, elem);
        }
        if (elem.classList.contains('anima-typingHard')) {
            runAnimaJS.typingHard(false, elem);
        }
    },
    // Наблюдатель за элементами в зоне видимости
    runObserver(viewElements, runFunction, threshold = 1, rootMargin = '0px') {
        let elems = document.querySelectorAll(viewElements);
        let observer = new IntersectionObserver((entires, observer)=>{
            entires.forEach(entry => {
                let item = entry.target;
                if (entry.isIntersecting) {
                    runFunction(item, elems);
                }
            });
        }, {
            threshold,
            rootMargin,
        });
        for (let key of elems) {
            observer.observe(key);
        }
    },
    // Набор методов для анимаций, которым требуется JS.
    drawRight(prepare, elem) {
        if (prepare) {
            let all = document.querySelectorAll('.anima-drawRight');
            if (all.length < 1) return;
            for (let key of all) {
                key.dataset.width = key.offsetWidth;
                key.style.width = '0px';
            }
        } else {
            elem.style.width = `${elem.dataset.width}px`;
        }
    },
    elemByElem(elem) {
        let elemItems = elem.querySelectorAll('.anima-item');
        let count = 0;
        if (elemItems < 1) return;

        let interval = setInterval(()=>{
            for (let key of elemItems) {
                if (!key.classList.contains('anima-done')) {
                    key.classList.add('anima-done');
                    break;
                }
            }
            count += 1;
            if (count === elemItems.length) {
                clearInterval(interval);
            }
        }, 200);
    },
    typingText(prepare, elem) {
        if (prepare) {
            let texts = document.querySelectorAll('.anima-typingText');
            if (texts.length === 0) return;

            for (let key of texts) {
                let lettersArr = key.innerText.split('');

                let spanArr = lettersArr.map((item)=>{
                    let span = document.createElement('span');
                    span.innerText = item;
                    return span;
                })

                key.innerHTML = '';
                spanArr.forEach((item)=>{
                    key.append(item);
                })
            }
        } else {
            let letters = elem.querySelectorAll('span');
            let count = 0;
            if (letters.length === 0) return;

            let interval = setInterval(()=>{
                for (let key of letters) {
                    if (!key.classList.contains('anima-done')) {
                        key.classList.add('anima-done');
                        break;
                    }
                }
                count += 1;
                if (count === letters.length) {
                    clearInterval(interval);
                }
            }, 25);

        }
    },
    typingHard(prepare, elem) {
        if (prepare) {
            let texts = document.querySelectorAll('.anima-typingHard');
            if (texts.length === 0) return;

            for (let key of texts) {
                key.dataset.text = key.innerText;
                key.innerText = '';
            }
        } else {
            let newString = '';
            if (!elem.dataset.text) {
                console.log('Ошибка сборки строки!');
                return;
            }
            let interval = setInterval(()=>{
                newString += elem.dataset.text[newString.length];
                elem.innerText = newString;
                if (newString.length === elem.dataset.text.length) {
                    clearInterval(interval);
                }
            }, 10);
        }
    }

}