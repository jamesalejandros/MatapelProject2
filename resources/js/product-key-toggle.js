document.addEventListener('click', function (event) {

    const button = event.target.closest('.product-key-toggle');

    if (!button) {
        return;
    }


    const wrapper = button.closest('div');


    const mask = wrapper.querySelector('.product-key-mask');
    const value = wrapper.querySelector('.product-key-value');


    if (value.classList.contains('hidden')) {

        value.classList.remove('hidden');
        mask.classList.add('hidden');

        button.innerHTML = '🙈';

    } else {

        value.classList.add('hidden');
        mask.classList.remove('hidden');

        button.innerHTML = '👁';

    }

});
