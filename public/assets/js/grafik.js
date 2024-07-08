// Import Chart.js and Plugin Datalabels if needed
import Chart from "https://cdn.jsdelivr.net/npm/chart.js";
import "https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels";

// Chart.pluginService.register({
//     beforeDraw: function (chart) {
//         if (chart.config.options.elements.center) {
//             const ctx = chart.chart.ctx;
//             const centerConfig = chart.config.options.elements.center;
//             const fontStyle = centerConfig.fontStyle || "Arial";
//             const txt = centerConfig.text;
//             const color = centerConfig.color || "#000";
//             const sidePadding = centerConfig.sidePadding || 20;
//             const sidePaddingCalculated =
//                 (sidePadding / 100) * (chart.innerRadius * 2);
//             ctx.font = "30px " + fontStyle;
//             const stringWidth = ctx.measureText(txt).width;
//             const elementWidth = chart.innerRadius * 2 - sidePaddingCalculated;
//             const widthRatio = elementWidth / stringWidth;
//             const newFontSize = Math.floor(30 * widthRatio);
//             const elementHeight = chart.innerRadius * 2;
//             const fontSizeToUse = Math.min(newFontSize, elementHeight);
//             ctx.textAlign = "center";
//             ctx.textBaseline = "middle";
//             const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
//             const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
//             ctx.font = fontSizeToUse + "px " + fontStyle;
//             ctx.fillStyle = color;
//             ctx.fillText(txt, centerX, centerY);
//         }
//     },
// });

export function createPenerimaManfaatChart(canvasId, jumlah) {
    const ctx = document.getElementById(canvasId).getContext("2d");
    new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Penerima Manfaat"],
            datasets: [
                {
                    data: [jumlah],
                    backgroundColor: ["rgba(54, 162, 235, 0.2)"],
                    borderColor: ["rgba(54, 162, 235, 1)"],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    display: false,
                },
                legend: {
                    display: false,
                },
                tooltip: {
                    enabled: false,
                },
            },
            elements: {
                center: {
                    text: jumlah.toString(),
                    color: "#FF6384",
                    fontStyle: "Arial",
                    sidePadding: 20,
                },
            },
        },
    });
}

export function createJumlahBarangChart(canvasId, data, labels) {
    const ctx = document.getElementById(canvasId).getContext("2d");
    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: labels,
            datasets: [
                {
                    data: data,
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(255, 206, 86, 0.2)",
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                    ],
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    display: true,
                    color: "#fff",
                },
                legend: {
                    display: true,
                },
                tooltip: {
                    enabled: true,
                },
            },
        },
    });
}
