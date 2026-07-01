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

// Simulateur "Votre banque, ou nous" de la home : recalcule en live les deux
// mensualités (taux banque vs taux MatchCrédit) et l'économie totale en
// appelant le moteur RÉEL du plugin matchcredit-tools (endpoint REST public
// /compute, le même que les pages calculette dédiées) — deux calculettes
// mc_tool "simu-comparatif-banque" / "simu-comparatif-matchcredit", mêmes
// champs (capital, duree_mois, taux_annuel), preset pret_amortissable,
// seul le taux fixe diffère entre les deux. Repli local (même formule,
// recopiée à l'identique du preset PHP) uniquement si l'API ne répond pas,
// pour que le widget ne tombe jamais en panne — jamais la source de vérité.
const compareGrid = document.querySelector('[data-compare]');

if (compareGrid) {
	const montantInput = compareGrid.querySelector('[data-compare-montant]');
	const dureeInput = compareGrid.querySelector('[data-compare-duree]');
	const montantOut = compareGrid.querySelector('[data-compare-montant-out]');
	const dureeOut = compareGrid.querySelector('[data-compare-duree-out]');
	const bar1 = compareGrid.querySelector('[data-compare-bar="1"]');
	const bar2 = compareGrid.querySelector('[data-compare-bar="2"]');
	const val1 = compareGrid.querySelector('[data-compare-val="1"]');
	const val2 = compareGrid.querySelector('[data-compare-val="2"]');
	const economieOut = compareGrid.querySelector('[data-compare-economie]');

	const restUrl = compareGrid.dataset.restUrl;
	const slug1 = compareGrid.dataset.slug1;
	const slug2 = compareGrid.dataset.slug2;
	const taux1 = parseFloat(compareGrid.dataset.taux1);
	const taux2 = parseFloat(compareGrid.dataset.taux2);

	const formatEuros = (value) => Math.round(value).toLocaleString('fr-FR') + ' €';

	// Repli local : copie fidèle de MC_Tools_Preset_Pret_Amortissable::mensualite()
	// (includes/class-presets.php), utilisée seulement si l'appel REST échoue.
	const mensualiteFallback = (capital, tauxAnnuel, dureeMois) => {
		const t = (tauxAnnuel / 100) / 12;
		if (t === 0) {
			return capital / dureeMois;
		}
		return (capital * t) / (1 - (1 + t) ** -dureeMois);
	};

	const computeViaApi = async (slug, capital, dureeMois, tauxAnnuel) => {
		const response = await fetch(restUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json' },
			body: JSON.stringify({
				slug,
				values: { capital, duree_mois: dureeMois, taux_annuel: tauxAnnuel },
			}),
		});
		if (!response.ok) {
			throw new Error('mc_tools compute failed');
		}
		const data = await response.json();
		return data.results.mensualite;
	};

	let debounceTimer = null;

	const render = (capital, dureeAns, m1, m2) => {
		const dureeMois = dureeAns * 12;
		const economie = (m1 - m2) * dureeMois;

		montantOut.textContent = formatEuros(capital);
		dureeOut.textContent = `${dureeAns} ans`;

		val1.innerHTML = `${formatEuros(m1)}<span class="bar-unit">/mois</span>`;
		val2.innerHTML = `${formatEuros(m2)}<span class="bar-unit">/mois</span>`;

		bar1.style.setProperty('--fill', '100%');
		bar2.style.setProperty('--fill', `${Math.max(0, Math.min(100, (m2 / m1) * 100))}%`);

		economieOut.textContent = formatEuros(Math.max(0, economie));
	};

	const recompute = async () => {
		const capital = parseFloat(montantInput.value);
		const dureeAns = parseFloat(dureeInput.value);
		const dureeMois = dureeAns * 12;

		try {
			const [m1, m2] = await Promise.all([
				computeViaApi(slug1, capital, dureeMois, taux1),
				computeViaApi(slug2, capital, dureeMois, taux2),
			]);
			render(capital, dureeAns, m1, m2);
		} catch (error) {
			// Calculette pas encore créée côté admin, ou API injoignable : repli local.
			const m1 = mensualiteFallback(capital, taux1, dureeMois);
			const m2 = mensualiteFallback(capital, taux2, dureeMois);
			render(capital, dureeAns, m1, m2);
		}
	};

	const recomputeDebounced = () => {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(recompute, 150);
	};

	montantInput.addEventListener('input', recomputeDebounced);
	dureeInput.addEventListener('input', recomputeDebounced);
	recompute();
}
