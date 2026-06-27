const navBurger = document.querySelector('.nav-burger');
const navCollapse = document.querySelector('.nav-collapse');

if (navBurger && navCollapse) {
	navBurger.addEventListener('click', () => {
		const isOpen = navCollapse.classList.toggle('is-open');
		navBurger.classList.toggle('is-open', isOpen);
		navBurger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		document.body.classList.toggle('nav-open', isOpen);
	});

	// Sur mobile, un parent avec sous-menu s'ouvre au clic au lieu de naviguer.
	navCollapse.querySelectorAll('.menu-item-has-children > a').forEach((link) => {
		link.addEventListener('click', (event) => {
			if (window.innerWidth > 800) {
				return;
			}
			event.preventDefault();
			link.parentElement.classList.toggle('is-open');
		});
	});

	navCollapse.querySelectorAll('a').forEach((link) => {
		link.addEventListener('click', () => {
			if (link.parentElement.classList.contains('menu-item-has-children') && window.innerWidth <= 800) {
				return;
			}
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

const lexiqueLayout = document.querySelector('.lexique-layout');

if (lexiqueLayout) {
	const nav = document.querySelector('.nav');
	const azBar = document.querySelector('.lexique-az-bar');
	const azList = document.querySelector('.lexique-az-bar-list');
	const azLinks = document.querySelectorAll('.lexique-az-bar-list a');
	const rows = Array.from(document.querySelectorAll('.lexique-row-letter'));

	const setHeaderHeight = () => {
		document.documentElement.style.setProperty('--header-h', `${nav ? nav.offsetHeight : 0}px`);
		document.documentElement.style.setProperty('--lexique-bar-h', `${azBar ? azBar.offsetHeight : 0}px`);
	};
	setHeaderHeight();
	window.addEventListener('resize', setHeaderHeight);
	window.addEventListener('load', setHeaderHeight);
	document.fonts?.ready.then(setHeaderHeight);

	// Lettre active dans la barre A-Z, déterminée par la ligne sticky actuellement visible.
	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					azLinks.forEach((link) => {
						link.classList.toggle('is-active', link.dataset.letter === entry.target.dataset.letter);
					});
				}
			});
		},
		{ rootMargin: '-45% 0px -50% 0px', threshold: 0 }
	);

	rows.forEach((row) => observer.observe(row));

	// Position réelle dans le document, en remontant la chaîne offsetParent.
	// Mesurée sur .lexique-row-content (jamais sticky) plutôt que sur la lettre
	// elle-même : un élément position: sticky actuellement "collé" peut faire
	// remonter un offsetTop/getBoundingClientRect faux selon le navigateur,
	// alors que son contenu voisin (non sticky) reste fiable dans tous les cas.
	const getDocumentTop = (el) => {
		let top = 0;
		while (el) {
			top += el.offsetTop;
			el = el.offsetParent;
		}
		return top;
	};

	// Scroll animé vers la lettre cliquée, en tenant compte des barres sticky empilées.
	azLinks.forEach((link) => {
		link.addEventListener('click', (event) => {
			const target = document.getElementById(link.getAttribute('href').slice(1));
			if (!target) {
				return;
			}
			event.preventDefault();
			const reference = target.nextElementSibling || target;
			const headerH = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--header-h')) || 0;
			const barH = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--lexique-bar-h')) || 0;
			const top = getDocumentTop(reference) - headerH - barH + 18;
			window.scrollTo({ top, behavior: 'smooth' });
		});
	});

	// Masques de bord signalant qu'on peut encore défiler la barre A-Z horizontalement.
	const updateScrollMasks = () => {
		if (!azList || !azBar) {
			return;
		}
		const { scrollLeft, scrollWidth, clientWidth } = azList;
		azBar.classList.toggle('has-scroll-left', scrollLeft > 4);
		azBar.classList.toggle('has-scroll-right', scrollLeft + clientWidth < scrollWidth - 4);
	};
	updateScrollMasks();
	azList?.addEventListener('scroll', updateScrollMasks);
	window.addEventListener('resize', updateScrollMasks);
}
