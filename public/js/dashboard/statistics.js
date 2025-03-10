let categoriesSalesCtx = document.getElementById('categories_sales_chart');

if ( categoriesSalesCtx )
{
    categoriesSalesCtx.height = 140;
    categoriesSalesCtx.width  = 280;
}

let productsCategoriesCtx = document.getElementById('products_categories_chart');

if ( productsCategoriesCtx )
{
    productsCategoriesCtx.height = 140;
    productsCategoriesCtx.width  = 280;
}
// Chart labels
const categoriesSalesLabels    = categoriesSales.map( ( category ) => category['category'] );
const productsCategoriesLabels = productsCategories.map( ( category ) => category['name'] );

// Chart data
const categoriesSalesData = {
    labels: categoriesSalesLabels,
    datasets: [{
        data: categoriesSales.map( ( category ) => parseInt( category['total_price'] ) ),
        backgroundColor: [
            'rgb(54, 162, 235)',
            '#F64E60',
            'rgb(154,0,0)',
            'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
    }]
};

const productsCategoriesData = {
    labels: productsCategoriesLabels,
    datasets: [{
        data: productsCategories.map( ( category ) => parseInt( category['products_count'] ) ),
        backgroundColor: [
            'rgb(54, 162, 235)',
            '#F64E60',
            'rgb(154,0,0)',
            'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
    }]
};

// Chart config
const categoriesSalesConfig = {
    type: 'doughnut',
    options: {
        plugins: {
            title: {
                display: true,
            }
        },
        responsive: true,
        maintainAspectRatio: false,
    },
    defaults:{
        global: {
            defaultFont: "Cairo"
        }
    }
};

const productsCategoryConfig = {
    type: 'doughnut',
    options: {
        plugins: {
            title: {
                display: true,
            }
        },
        responsive: true,
        maintainAspectRatio: false,
    },
    defaults:{
        global: {
            defaultFont: "Cairo"
        }
    }
};

// Init categories sales chart
categoriesSalesConfig.data = categoriesSalesData;

if ( categoriesSalesCtx )
    new Chart(categoriesSalesCtx, categoriesSalesConfig);

// Init products categories chart
productsCategoryConfig.data = productsCategoriesData;

if ( productsCategoriesCtx )
    new Chart(productsCategoriesCtx, productsCategoryConfig);


// monthly sales chart


let monthlyChart  = document.getElementById("monthly_sales_chart");

if ( monthlyChart )
{
    let t = parseInt(KTUtil.css(monthlyChart, "height")), a = KTUtil.getCssVariableValue("--bs-gray-500"),
        r = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
        o = KTUtil.getCssVariableValue("--bs-primary"), i = KTUtil.getCssVariableValue("--bs-primary"),
        s = new ApexCharts(monthlyChart, {
            series: [{
                name: translate("Sales"),
                data: dailySales.map( day => day['sales'] ),
            }],
            chart: {fontFamily: "inherit", type: "area", height: t, toolbar: {show: !1}},
            plotOptions: {},
            legend: {show: !1},
            dataLabels: {enabled: !1},
            fill: {
                type: "gradient",
                gradient: {shadeIntensity: 1, opacityFrom: .3, opacityTo: .7, stops: [0, 90, 100]}
            },
            stroke: {curve: "smooth", show: !0, width: 3, colors: [o]},
            xaxis: {
                categories: dailySales.map( day => day['date'] ),
                axisBorder: {show: !1},
                axisTicks: {show: !1},
                tickAmount: 6,
                labels: {rotate: 0, rotateAlways: !0, style: {colors: a, fontSize: "12px"}},
                crosshairs: {position: "front", stroke: {color: o, width: 1, dashArray: 3}},
                tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}}
            },
            yaxis: {
                tickAmount: 4,
                labels: {
                    style: {colors: a, fontSize: "12px"}, formatter: function (e) {
                        return Number(e / 10).toFixed(1) + " " + translate('QAR')
                    }
                }
            },
            states: {
                normal: {filter: {type: "none", value: 0}},
                hover: {filter: {type: "none", value: 0}},
                active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
            },
            tooltip: {
                style: {fontSize: "12px"}, y: {
                    formatter: function (e) {
                        return e + " " + translate('QAR')
                    }
                }
            },
            colors: [i],
            grid: {borderColor: r, strokeDashArray: 4, yaxis: {lines: {show: !0}}},
            markers: {strokeColor: o, strokeWidth: 3}
        });
    setTimeout((function () {
        s.render()
    }), 300)
}

// monthly sales chart

