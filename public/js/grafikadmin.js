document.addEventListener("DOMContentLoaded", function () {
    var ctx = document.getElementById("donationChart").getContext("2d");
    var donationChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: window.donationLabels,
            datasets: [
                {
                    label: "Total Donasi",
                    data: window.donationDataAdmin,
                    backgroundColor: "#6777EF",
                    borderColor: "#2E3192",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            // Format nilai dengan titik sebagai pemisah ribuan
                            return "Rp" + value.toLocaleString("id-ID");
                        },
                    },
                },
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            // Format tooltip dengan titik sebagai pemisah ribuan
                            let value = context.raw;
                            return "Rp" + value.toLocaleString("id-ID");
                        },
                    },
                },
            },
        },
    });
});
