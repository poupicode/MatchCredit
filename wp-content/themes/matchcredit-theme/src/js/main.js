const navBurger = document.querySelector('.nav-burger');
const navCollapse = document.querySelector('.nav-collapse');

if (navBurger && navCollapse) {
	navBurger.addEventListener('click', () => {
		const isOpen = navCollapse.classList.toggle('is-open');
		navBurger.classList.toggle('is-open', isOpen);
		navBurger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		document.body.classList.toggle('nav-open', isOpen);
	});

	navCollapse.querySelectorAll('a').forEach((link) => {
		link.addEventListener('click', () => {
			navCollapse.classList.remove('is-open');
			navBurger.classList.remove('is-open');
			navBurger.setAttribute('aria-expanded', 'false');
			document.body.classList.remove('nav-open');
		});
	});
}

document.querySelectorAll('.faq-item').forEach((item) => {
	const button = item.querySelector('.faq-q');
	button.addEventListener('click', () => {
		const wasOpen = item.classList.contains('open');
		item.closest('.faq-list').querySelectorAll('.faq-item').forEach((i) => i.classList.remove('open'));
		if (!wasOpen) item.classList.add('open');
	});
});
