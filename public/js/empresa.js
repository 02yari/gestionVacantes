document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', () => {
        input.style.boxShadow = '0 0 8px rgba(127,127,213,0.5)';
    });

    input.addEventListener('blur', () => {
        input.style.boxShadow = 'none';
    });
});
