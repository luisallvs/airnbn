document.addEventListener('DOMContentLoaded', function () {
	const buttons = document.querySelectorAll('.btn-group button');

	buttons.forEach(button => {
		button.addEventListener('click', function () {
			const reservationId = this.dataset.id;
			const newStatus = this.dataset.status;

			const xhr = new XMLHttpRequest();
			xhr.open('POST', '/admin/reservations/updateStatus');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xhr.onload = function () {
				if (xhr.status === 200) {
					buttons.forEach(btn => {
						if (btn.dataset.id === reservationId) {
							btn.classList.remove('btn-success', 'btn-warning', 'btn-danger', 'btn-outline-success', 'btn-outline-warning', 'btn-outline-danger');
							btn.classList.add(
								btn.dataset.status === newStatus
									? `btn-${newStatus === 'confirmed' ? 'success' : newStatus === 'pending' ? 'warning' : 'danger'}`
									: `btn-outline-${btn.dataset.status === 'confirmed' ? 'success' : btn.dataset.status === 'pending' ? 'warning' : 'danger'}`,
							);
						}
					});
				} else {
					console.error('Failed to update reservation status.');
				}
			};

			xhr.send(`reservation_id=${reservationId}&status=${newStatus}`);
		});
	});
});
