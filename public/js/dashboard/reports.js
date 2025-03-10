let iniClientsRatingChart = () => {


    let clientsRate = document.getElementById('clients_rate_chart');
    let height = parseInt(KTUtil.css(clientsRate, "height"));

    let a = clientsRate.getAttribute("data-kt-chart-color"), o = KTUtil.getCssVariableValue("--bs-gray-800"),
        s = KTUtil.getCssVariableValue("--bs-" + a), r = KTUtil.getCssVariableValue("--bs-light-" + a);
    new ApexCharts(clientsRate, {
        series: [
            {
                name: " " + translate('Clients'),
                data: clientsMonthlyRate['data']
            }
        ],
        chart: {
            fontFamily: "inherit",
            type: "area",
            height,
            toolbar: {show: false},
            zoom: {enabled: false},
            sparkline: {enabled: true}
        },
        plotOptions: {},
        legend: {show: false},
        dataLabels: {enabled: false},
        fill: {type: "solid", opacity: .3},
        stroke: {curve: "smooth", show: true, width: 3, colors: [s]},
        xaxis: {
            categories: [ translate('Jan'),  translate('Feb'),  translate('Mar'),  translate('Apr'),  translate('May'),  translate('June'),  translate('July'),  translate('Aug'),  translate('Sep'),  translate('Oct'),  translate('Nov'),  translate("Dec")],
            axisBorder: {show: false},
            axisTicks: {show: false},
            labels: {show: false, style: {colors: o, fontSize: "12px"}},
            crosshairs: {show: false, position: "front", stroke: {color: "#E4E6EF", width: 1, dashArray: 3}},
            tooltip: {enabled: true, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
        },
        yaxis: {
            min: clientsMonthlyRate['min'],
            max: clientsMonthlyRate['max'],
            labels: {show: false, style: {colors: o, fontSize: "12px"}}},
        states: {
            normal: {filter: {type: "none", value: 0}},
            hover: {filter: {type: "none", value: 0}},
            active: {allowMultipleDataPointsSelection: false, filter: {type: "none", value: 0}}
        },
        tooltip: {
            style: {fontSize: "12px"}, y: {
                formatter: e => e
            }
        },
        colors: [s],
        markers: {colors: [s], strokeColor: [r], strokeWidth: 3}
    }).render()

}

let initOrdersRatingChart = () => {


    let ordersRate = document.getElementById('orders_rate_chart');
    let height = parseInt(KTUtil.css(ordersRate, "height"));

    let a = ordersRate.getAttribute("data-kt-chart-color"), o = KTUtil.getCssVariableValue("--bs-gray-800"),
        s = KTUtil.getCssVariableValue("--bs-" + a), r = KTUtil.getCssVariableValue("--bs-light-" + a);
    new ApexCharts(ordersRate, {
        series: [
            {
                name: translate('Orders'),
                data: ordersMonthlyRate['data']
            }
        ],
        chart: {
            fontFamily: "inherit",
            type: "area",
            height,
            toolbar: {show: false},
            zoom: {enabled: false},
            sparkline: {enabled: true}
        },
        plotOptions: {},
        legend: {show: false},
        dataLabels: {enabled: false},
        fill: {type: "solid", opacity: .3},
        stroke: {curve: "smooth", show: true, width: 3, colors: [s]},
        xaxis: {
            categories: [ translate('Jan'),  translate('Feb'),  translate('Mar'),  translate('Apr'),  translate('May'),  translate('June'),  translate('July'),  translate('Aug'),  translate('Sep'),  translate('Oct'),  translate('Nov'),  translate("Dec")],
            axisBorder: {show: false},
            axisTicks: {show: false},
            labels: {show: false, style: {colors: o, fontSize: "12px"}},
            crosshairs: {show: false, position: "front", stroke: {color: "#E4E6EF", width: 1, dashArray: 3}},
            tooltip: {enabled: true, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
        },
        yaxis: {
            min: ordersMonthlyRate['min'],
            max: ordersMonthlyRate['max'],
            labels: {show: false, style: {colors: o, fontSize: "12px"}}},
        states: {
            normal: {filter: {type: "none", value: 0}},
            hover: {filter: {type: "none", value: 0}},
            active: {allowMultipleDataPointsSelection: false, filter: {type: "none", value: 0}}
        },
        tooltip: {
            style: {fontSize: "12px"}, y: {
                formatter: e => e
            }
        },
        colors: [s],
        markers: {colors: [s], strokeColor: [r], strokeWidth: 3}
    }).render()

}
