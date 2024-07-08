document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("donationBarChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: months,
            datasets: [
                {
                    label: "Jumlah Pemasukan Uang Donasi",
                    data: donationData,
                    backgroundColor: "#6777EF",
                    borderColor: "#2E3192",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    min: 1000000, // Minimum 1 juta
                    max: 10000000, // Maksimum 10 juta
                    ticks: {
                        // Format nilai dengan titik sebagai pemisah ribuan
                        callback: function (value, index, values) {
                            return "Rp" + value.toLocaleString("id-ID");
                        },
                    },
                },
            },
        },
    });
});

// Inisialisasi Chart.js
const ctx = document.getElementById("totalDonasiAdminChart").getContext("2d");
const totalDonasiAdminChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: months,
        datasets: [
            {
                label: "Total Donasi Admin",
                data: [totalDonasiAdmin],
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
            },
        },
    },
});
