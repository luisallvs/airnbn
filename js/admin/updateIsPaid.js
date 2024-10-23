document.addEventListener('DOMContentLoaded', function () {
	const paidButtons = document.querySelectorAll('.toggle-paid-status');

	paidButtons.forEach(button => {
		button.addEventListener('click', function () {
			const reservationId = this.dataset.id;
			const isPaid = this.dataset.paid === '1' ? '0' : '1';

			const xhr = new XMLHttpRequest();
			xhr.open('POST', '/admin/reservations/updateIsPaid');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xhr.onload = function () {
				if (xhr.status === 200) {
					button.textContent = isPaid === '1' ? 'Paid' : 'Not Paid';
					button.classList.toggle('btn-success', isPaid === '1');
					button.classList.toggle('btn-danger', isPaid === '0');
					button.dataset.paid = isPaid;
				} else {
					console.error('Failed to update reservation payment status.');
				}
			};

			xhr.send(`reservation_id=${reservationId}&is_paid=${isPaid}`);
		});
	});
});
