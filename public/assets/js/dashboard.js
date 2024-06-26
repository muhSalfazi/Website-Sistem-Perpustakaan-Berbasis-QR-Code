
$(function () {

    // =====================================
    // Profit
    // =====================================

    var chartOptions = {
        series: [
            { name: "Penghasilan bulan ini:", data: [newMembersCount, borrowingBooksCount, returnBooksCount] },
            // { name: "Biaya bulan ini:", data: [overdueBooksCount, overdueMembersCount, 0] },
        ],
        chart: {
            type: "bar",
            height: 505,
            offsetX: -15,
            toolbar: { show: true },
            foreColor: "#adb0bb",
            fontFamily: 'inherit',
            sparkline: { enabled: false },
        },
        colors: ["#5D87FF", ], 
        // "#49BEFF"
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "45%",
                borderRadius: [6],
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'all'
            },
        },
        markers: { size: 0 },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },
        xaxis: {
            type: "category",
            categories: ["new member", "borrow book", "return book"],
            labels: {
                style: { cssClass: "grey--text lighten-2--text fill-color" },
            },
        },
        yaxis: {
            show: true,
            min: 0,
            max: 100,
            tickAmount: 4,
            labels: {
                style: {
                    cssClass: "grey--text lighten-2--text fill-color",
                },
            },
        },
        stroke: {
            show: true,
            width: 4,
            lineCap: "butt",
            colors: ["transparent"],
        },
        tooltip: { theme: "light" },
        responsive: [
            {
                breakpoint: 550,
                options: {
                    plotOptions: {
                        bar: {
                            borderRadius: 3,
                        }
                    },
                }
            }
        ]
    };

    var chart = new ApexCharts(document.querySelector("#chart"), chartOptions);
    chart.render();

    // =====================================
    // Breakup
    // =====================================
    var breakupOptions = {
        series: [totalDenda, lastYearTotalDenda],
        labels: ["This Month", "Last Month"],
        chart: {
            width: 180,
            type: "donut",
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
        },
        plotOptions: {
            pie: {
                startAngle: 0,
                endAngle: 360,
                donut: {
                    size: '75%',
                },
            },
        },
        stroke: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],
        responsive: [
            {
                breakpoint: 991,
                options: {
                    chart: {
                        width: 150,
                    },
                },
            },
        ],
        tooltip: {
            theme: "dark",
            fillSeriesColor: false,
        },
    };

    var breakupChart = new ApexCharts(document.querySelector("#breakup"), breakupOptions);
    breakupChart.render();

    // =====================================
    // Earning
    // =====================================
    var earningOptions = {
        chart: {
            id: "sparkline3",
            type: "area",
            height: 60,
            sparkline: {
                enabled: true,
            },
            group: "sparklines",
            fontFamily: "Plus Jakarta Sans', sans-serif",
            foreColor: "#adb0bb",
        },
        series: [
            {
                name: "Tunggakan",
                color: "#49BEFF",
                data: [totalTunggakan, lastYearTotalTunggakan],
            },
        ],
        stroke: {
            curve: "smooth",
            width: 2,
        },
        fill: {
            colors: ["#f3feff"],
            type: "solid",
            opacity: 0.05,
        },
        markers: {
            size: 0,
        },
        tooltip: {
            theme: "dark",
            fixed: {
                enabled: true,
                position: "right",
            },
            x: {
                show: false,
            },
        },
    };

    new ApexCharts(document.querySelector("#earning"), earningOptions).render();
});