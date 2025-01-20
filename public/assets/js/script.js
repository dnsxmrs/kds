const startButtons = document.querySelectorAll(".startButton");
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

window.addEventListener("load", () => {
    console.log('Loading...');

    updateHeader();
});

function updateHeader() {
    // pending, preparing, ready, completed
    // newOrders, processed, ready, served

    // get the div that has a class of newOrders, processed, ready, served
    const newOrders = document.querySelector('.newOrders');
    const processed = document.querySelector('.processed');
    const ready = document.querySelector('.ready');
    const served = document.querySelector('.served');

    fetch('/header', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
        .then(response => response.json())
        .then(data => {
            newOrders.textContent = data.newOrders;
            processed.textContent = data.processed;
            ready.textContent = data.ready;
            served.textContent = data.served;
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
}

window.showTab = function (tab, clickedButton) {
    const allDivs = document.querySelectorAll(".tab-content");

    const bgActive = 'bg-white';
    const textActive = 'text-black';
    const bgInactive = 'bg-[#9D9D9D]';
    const textInactive = 'text-[#555555]';

    console.log("filter tab is clicked " + tab);

    allDivs.forEach((div) => {
        if (div.getAttribute("data-tab") === tab) {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
    });

    // Reset all buttons to inactive style
    const allButtons = document.querySelectorAll('.tab-button');
    allButtons.forEach((button) => {
        button.classList.remove(bgActive, textActive);
        button.classList.add(bgInactive, textInactive);
    });

    // Set the clicked button as active
    clickedButton.classList.remove(bgInactive, textInactive);
    clickedButton.classList.add(bgActive, textActive);
};

window.updateOrderStatus = function (orderId, button, status) {
    fetch('/orders/update-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            order_id: orderId,
            status: status,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (status === 'preparing') {
                button.textContent = 'Preparing...';
            } else if (status === 'ready') {
                button.textContent = 'Ready...';
            } else if (status === 'completed') {
                button.textContent = 'Completed...';
            }
            button.disabled = true;
            button.classList.add('bg-gray-500', 'cursor-not-allowed');

            location.reload();
        })
        .catch(error => {
            console.error(error);
            alert('An error occurred. Please try again.');
        });
}
