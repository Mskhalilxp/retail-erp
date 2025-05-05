"use strict";

let initTotalEarningsChart    = () => {

        let totalEarningsChart       = document.getElementById("total_earnings_chart");
        let totalEarningsChartHeight = 150;

        if (totalEarningsChart) {
            let a = totalEarningsChart.getAttribute("data-kt-chart-color"), o = KTUtil.getCssVariableValue("--bs-gray-800"),
                s = KTUtil.getCssVariableValue("--bs-" + a), r = KTUtil.getCssVariableValue("--bs-light-" + a);
            new ApexCharts(totalEarningsChart, {
                series: [{name: translate("Total earnings"), data: totalEarningsPerMonth['data'] }],
                chart: {
                    fontFamily: "inherit",
                    type: "area",
                    height: totalEarningsChartHeight,
                    toolbar: {show: !1},
                    zoom: {enabled: !1},
                    sparkline: {enabled: !0}
                },
                plotOptions: {},
                legend: {show: !1},
                dataLabels: {enabled: !1},
                fill: {type: "solid", opacity: .3},
                stroke: {curve: "smooth", show: !0, width: 3, colors: [s]},
                xaxis: {
                    categories: [ translate('January'),  translate('February'),  translate('March'),  translate('April'),  translate('May'),  translate('June'),  translate('July'),  translate('August'),  translate('September'),  translate('October'),  translate('November'),  translate('December')],
                    axisBorder: {show: !1},
                    axisTicks: {show: !1},
                    labels: {show: !1, style: {colors: o, fontSize: "12px"}},
                    crosshairs: {show: !1, position: "front", stroke: {color: "#E4E6EF", width: 1, dashArray: 3}},
                    tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "14px"}}
                },
                yaxis: {min: totalEarningsPerMonth['min'], max: totalEarningsPerMonth['max'], labels: {show: !1, style: {colors: o, fontSize: "12px"}}},
                states: {
                    normal: {filter: {type: "none", value: 0}},
                    hover: {filter: {type: "none", value: 0}},
                    active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
                },
                colors: [s],
                markers: {colors: [s], strokeColor: [r], strokeWidth: 3}
            }).render()
        }
}

let initOrdersChart  = () => {

    let ordersChart       = document.getElementById("orders_chart");
    let ordersChartHeight = 150;

    if (ordersChart) {
        let a = ordersChart.getAttribute("data-kt-chart-color"), o = KTUtil.getCssVariableValue("--bs-gray-800"),
            s = KTUtil.getCssVariableValue("--bs-" + a), r = KTUtil.getCssVariableValue("--bs-light-" + a);
        new ApexCharts(ordersChart, {
            series: [{name: translate("Orders count"), data: ordersMonthlyRate['data'] }],
            chart: {
                fontFamily: "inherit",
                type: "area",
                height: ordersChartHeight,
                toolbar: {show: !1},
                zoom: {enabled: !1},
                sparkline: {enabled: !0}
            },
            plotOptions: {},
            legend: {show: !1},
            dataLabels: {enabled: !1},
            fill: {type: "solid", opacity: .3},
            stroke: {curve: "smooth", show: !0, width: 3, colors: [s]},
            xaxis: {
                categories: [ translate('January'),  translate('February'),  translate('March'),  translate('April'),  translate('May'),  translate('June'),  translate('July'),  translate('August'),  translate('September'),  translate('October'),  translate('November'),  translate('December')],
                axisBorder: {show: !1},
                axisTicks: {show: !1},
                labels: {show: !1, style: {colors: o, fontSize: "12px"}},
                crosshairs: {
                    show: !1,
                    position: "front",
                    stroke: {color: "#E4E6EF", width: 1, dashArray: 3}
                },
                tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "14px"}}
            },
            yaxis: {min: ordersMonthlyRate['min'], max: ordersMonthlyRate['max'], labels: {show: !1, style: {colors: o, fontSize: "12px"}}},
            states: {
                normal: {filter: {type: "none", value: 0}},
                hover: {filter: {type: "none", value: 0}},
                active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
            },
            tooltip: {
                style: {fontSize: "12px"}, y: {
                    formatter: function (e) {
                        return  e +  " ";
                    }
                }
            },
            colors: [s],
            markers: {colors: [s], strokeColor: [r], strokeWidth: 3}
        }).render()
    }

}


let initOrdersCitiesPercentagePieChart = () => {

    let attributes;

    attributes = ordersCitiesPercentage , $.plot($("#orders_cities_pie_chart"), attributes , {series: {pie: {show: 1}}, })

}

let initProductsOrdersPercentagePieChart = () => {

    let attributes;

    attributes = productsOrdersPercentage, $.plot($("#products_orders_pie_chart"), attributes , {series: {pie: {show: 1}}, })

}


"undefined" != typeof module && (module.exports = KTWidgets), KTUtil.onDOMContentLoaded((function () {
    initTotalEarningsChart();
    initOrdersChart();
    initOrdersCitiesPercentagePieChart();
    initProductsOrdersPercentagePieChart();
}));
