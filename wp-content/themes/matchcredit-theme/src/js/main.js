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

const cookieBanner = document.getElementById('cookie-banner');
const COOKIE_CONSENT_KEY = 'matchcredit_cookie_consent';

if (cookieBanner) {
	const consent = localStorage.getItem(COOKIE_CONSENT_KEY);

	if (!consent) {
		cookieBanner.hidden = false;
	}

	const setConsent = (value) => {
		localStorage.setItem(COOKIE_CONSENT_KEY, value);
		cookieBanner.hidden = true;
	};

	document.getElementById('cookie-accept')?.addEventListener('click', () => setConsent('accepted'));
	document.getElementById('cookie-refuse')?.addEventListener('click', () => setConsent('refused'));
}

const lexiqueContent = document.querySelector('.lexique-content');

if (lexiqueContent) {
	const nav = document.querySelector('.nav');
	const stickyLetter = document.querySelector('.lexique-sticky-letter');
	const azLinks = document.querySelectorAll('.lexique-az-list a');
	const azSelect = document.querySelector('.lexique-az-select');
	const groups = Array.from(document.querySelectorAll('.lexique-group'));

	const setHeaderHeight = () => {
		document.documentElement.style.setProperty('--header-h', `${nav ? nav.offsetHeight : 0}px`);
	};
	setHeaderHeight();
	window.addEventListener('resize', setHeaderHeight);

	azSelect?.addEventListener('change', () => {
		const target = document.getElementById(azSelect.value);
		target?.scrollIntoView({ behavior: 'smooth' });
	});

	const setActiveLetter = (letter) => {
		if (stickyLetter) {
			stickyLetter.textContent = letter;
			stickyLetter.classList.toggle('is-visible', Boolean(letter));
		}
		azLinks.forEach((link) => {
			link.classList.toggle('is-active', link.dataset.letter === letter);
		});
	};

	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					setActiveLetter(entry.target.dataset.letter);
				}
			});
		},
		{ rootMargin: '-45% 0px -50% 0px', threshold: 0 }
	);

	groups.forEach((group) => observer.observe(group));
}
