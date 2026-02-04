document.addEventListener('DOMContentLoaded', () => {
	const links = document.querySelectorAll('[data-section]');
	const sections = document.querySelectorAll('.section');
	const toggleFanBtn = document.getElementById('toggleFan');
	const fanStatusEl = document.getElementById('fanStatus');

	const co2El = document.getElementById('co2');
	const pm25El = document.getElementById('pm25');
	const tempEl = document.getElementById('temp');
	const humEl = document.getElementById('hum');

	let fanOn = false;

	// Show selected section
	function showSection(id) {
		sections.forEach(s => s.classList.toggle('active', s.id === id));
		links.forEach(l => l.classList.toggle('active', l.dataset.section === id));
	}
	links.forEach(link => {
		link.addEventListener('click', e => {
			e.preventDefault();
			showSection(link.dataset.section);
		});
	});

	// Update fan UI
	function updateFanUI() {
		fanStatusEl.textContent = fanOn ? 'On' : 'Off';
		toggleFanBtn.textContent = fanOn ? 'Turn Fan Off' : 'Turn Fan On';
	}
	toggleFanBtn.addEventListener('click', () => {
		fanOn = !fanOn;
		updateFanUI();
	});
	updateFanUI();

	// Simulate sensor readings
	function getRandom(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	function setAlertLevel(el, value, type) {
		if (!el) return;
		el.parentElement.classList.remove('good', 'warning', 'danger');

		switch(type) {
			case 'co2':
				if (value <= 600) el.parentElement.classList.add('good');
				else if (value <= 1000) el.parentElement.classList.add('warning');
				else el.parentElement.classList.add('danger');
				break;
			case 'pm25':
				if (value <= 12) el.parentElement.classList.add('good');
				else if (value <= 35) el.parentElement.classList.add('warning');
				else el.parentElement.classList.add('danger');
				break;
			case 'temp':
				if (value >= 20 && value <= 25) el.parentElement.classList.add('good');
				else if (value >= 18 && value < 20 || value > 25 && value <= 27) el.parentElement.classList.add('warning');
				else el.parentElement.classList.add('danger');
				break;
			case 'hum':
				if (value >= 40 && value <= 55) el.parentElement.classList.add('good');
				else if (value >= 30 && value < 40 || value > 55 && value <= 60) el.parentElement.classList.add('warning');
				else el.parentElement.classList.add('danger');
				break;
		}
	}

	function updateSensors() {
		const co2 = getRandom(400, 1200); // ppm
		const pm25 = getRandom(5, 80);    // µg/m³
		const temp = getRandom(18, 28);  // °C
		const hum = getRandom(30, 60);   // %

		co2El.textContent = `${co2} ppm`;
		pm25El.textContent = `${pm25} µg/m³`;
		tempEl.textContent = `${temp} °C`;
		humEl.textContent = `${hum} %`;

		setAlertLevel(co2El, co2, 'co2');
		setAlertLevel(pm25El, pm25, 'pm25');
		setAlertLevel(tempEl, temp, 'temp');
		setAlertLevel(humEl, hum, 'hum');

	}

	setInterval(updateSensors, 3000);
});
