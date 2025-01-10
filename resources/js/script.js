//
// inactive font - 555555
// inactive button - 9D9D9D

// active font - black
// active button - white

// document.getElementById('startButton').addEventListener('click', function() {
//     // Assuming orderId is available or can be retrieved dynamically
//     const orderId = document.getElementById('startButton').getAttribute('data-id');
//     // Get CSRF token from meta tag
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//     fetch('http://127.0.0.1:8002/update-order-status', {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken,
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({
//                 orderId: orderId,
//                 status: 'preparing',
//             })
//         })
//         .then(response => {
//             if (!response.ok) {
//                 // Handle HTTP errors
//                 throw new Error('Server error, status code: ' + response.status);
//             }
//             return response.json();
//         })
//         .then(data => {
//             if (data.success) {
//                 // Optionally update the UI to reflect the new status
//                 console.log('Order status updated to preparing');
//             } else {
//                 console.log('Error updating status:', data.error);
//             }
//         })
//         .catch(error => {
//             console.log('Error:', error);
//         });
// });

// document.getElementById('finishButton').addEventListener('click', function() {
//     // Assuming orderId is available or can be retrieved dynamically
//     const orderId = document.getElementById('finishButton').getAttribute('data-id');
//     // Get CSRF token from meta tag
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//     fetch('http://127.0.0.1:8002/update-order-status', {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken,
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({
//                 orderId: orderId,
//                 status: 'ready',
//             })
//         })
//         .then(response => {
//             if (!response.ok) {
//                 // Handle HTTP errors
//                 throw new Error('Server error, status code: ' + response.status);
//             }
//             return response.json();
//         })
//         .then(data => {
//             if (data.success) {
//                 // Optionally update the UI to reflect the new status
//                 console.log('Order status updated to preparing');
//             } else {
//                 console.log('Error updating status:', data.error);
//             }
//         })
//         .catch(error => {
//             console.log('Error:', error);
//         });
// });

// document.getElementById('printButton').addEventListener('click', function() {
//     // Assuming orderId is available or can be retrieved dynamically
//     const orderId = document.getElementById('printButton').getAttribute('data-id');
//     // Get CSRF token from meta tag
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//     fetch('http://127.0.0.1:8002/update-order-status', {
//             method: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken,
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({
//                 orderId: orderId,
//                 status: 'completed',
//             })
//         })
//         .then(response => {
//             if (!response.ok) {
//                 // Handle HTTP errors
//                 throw new Error('Server error, status code: ' + response.status);
//             }
//             return response.json();
//         })
//         .then(data => {
//             if (data.success) {
//                 // Optionally update the UI to reflect the new status
//                 console.log('Order status updated to preparing');
//             } else {
//                 console.log('Error updating status:', data.error);
//             }
//         })
//         .catch(error => {
//             console.log('Error:', error);
//         });
// });

document.addEventListener("DOMContentLoaded", function () {
    function showTab(tabId, clickedButton) {
        // Hide all tab content
        document.querySelectorAll(".tab-content").forEach((content) => {
            content.style.display = "none";
        });

        // Show the selected tab
        document.getElementById(tabId).style.display = "block";

        // Reset all buttons to inactive state
        document.querySelectorAll(".tab-button").forEach((button) => {
            button.classList.remove("active");
            button.style.backgroundColor = "#9D9D9D"; // Inactive button color
            button.style.color = "#555555"; // Inactive font color
        });

        // Set the clicked button to active state
        clickedButton.classList.add("active");
        clickedButton.style.backgroundColor = "white"; // Active button color
        clickedButton.style.color = "black"; // Active font color
    }

        // Add event listeners to tab buttons
        document.querySelectorAll(".tab-button").forEach((button) => {
            button.addEventListener("click", function () {
                const tabId = button.getAttribute("data-tab"); // Assume each button has a data-tab attribute with the target tabId
                showTab(tabId, button); // Call showTab with the tab ID and clicked button
            });
        }); 

    document.addEventListener("DOMContentLoaded", function () {
        const startButtons = document.querySelectorAll(".startButton");
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        // Check if buttons are being selected correctly
        console.log(startButtons);

        startButtons.forEach((button) => {
            button.addEventListener("click", function (event) {
                // Ensure you are getting the right 'data-id' from the clicked button
                const orderId = event.target.getAttribute("data-id");
                console.log("Order ID:", orderId); // Debugging: log the order ID

                if (!orderId) {
                    console.error("Order ID is missing from the button.");
                    return;
                }

                fetch("http://127.0.0.1:8002/update-order-status", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        orderId: orderId,
                        status: "preparing",
                    }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                "Server error, status code: " + response.status
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.success) {
                            console.log("Order status updated to preparing");
                        } else {
                            console.log("Error updating status:", data.error);
                        }
                    })
                    .catch((error) => {
                        console.log("Error:", error);
                    });
            });
        });

        // document
        //     .getElementById("startButton")
        //     .addEventListener("click", function () {
        //         const orderId = document
        //             .getElementById("startButton")
        //             .getAttribute("data-id");
        //     });

        document
            .getElementById("finishButton")
            .addEventListener("click", function () {
                const orderId = document
                    .getElementById("finishButton")
                    .getAttribute("data-id");
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                fetch("http://127.0.0.1:8002/update-order-status", {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        orderId: orderId,
                        status: "ready",
                    }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                "Server error, status code: " + response.status
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.success) {
                            console.log("Order status updated to ready");
                        } else {
                            console.log("Error updating status:", data.error);
                        }
                    })
                    .catch((error) => {
                        console.log("Error:", error);
                    });
            });

        document
            .getElementById("printButton")
            .addEventListener("click", function () {
                const orderId = document
                    .getElementById("printButton")
                    .getAttribute("data-id");
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                fetch("http://127.0.0.1:8002/update-order-status", {
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        orderId: orderId,
                        status: "completed",
                    }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                "Server error, status code: " + response.status
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        if (data.success) {
                            console.log("Order status updated to completed");
                        } else {
                            console.log("Error updating status:", data.error);
                        }
                    })
                    .catch((error) => {
                        console.log("Error:", error);
                    });
            });
    });
});
