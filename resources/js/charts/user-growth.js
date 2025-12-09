
import ApexCharts from 'apexcharts';

export const initUserGrowthChart = () => {
    const chartSelector = document.querySelector('#userGrowthChart');

    if (chartSelector) {
        const options = {
            series: [
                {
                    name: 'Novos Usuários',
                    data: [44, 55, 41, 67, 22, 43, 21, 49, 33, 29, 44, 38],
                },
                {
                    name: 'Usuários Totais',
                    data: [100, 155, 196, 263, 285, 328, 349, 398, 431, 460, 504, 542],
                },
            ],
            chart: {
                fontFamily: 'Outfit, sans-serif',
                type: 'area',
                height: 265,
                toolbar: {
                    show: false,
                },
                locales: [{
                    "name": "pt-br",
                    "options": {
                        "months": ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
                        "shortMonths": ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
                        "days": ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
                        "shortDays": ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
                        "toolbar": {
                            "exportToSVG": "Baixar SVG",
                            "exportToPNG": "Baixar PNG",
                            "exportToCSV": "Baixar CSV",
                            "menu": "Menu",
                            "selection": "Selecionar",
                            "selectionZoom": "Selecionar Zoom",
                            "zoomIn": "Aumentar Zoom",
                            "zoomOut": "Diminuir Zoom",
                            "pan": "Mover",
                            "reset": "Resetar Zoom"
                        }
                    }
                }],
                defaultLocale: "pt-br"
            },
            colors: ['#465fff', '#9cb9ff'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.55,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            xaxis: {
                categories: [
                    'Jan',
                    'Fev',
                    'Mar',
                    'Abr',
                    'Mai',
                    'Jun',
                    'Jul',
                    'Ago',
                    'Set',
                    'Out',
                    'Nov',
                    'Dez',
                ],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px',
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#6b7280',
                        fontSize: '12px',
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                fontFamily: 'Outfit, sans-serif',
                markers: {
                    radius: 99,
                },
            },
            grid: {
                show: true,
                borderColor: '#f3f4f6',
                strokeDashArray: 0,
                position: 'back',
                yaxis: {
                    lines: {
                        show: true
                    }
                },
            },
            tooltip: {
                theme: 'light',
                x: {
                    show: true,
                },
                y: {
                    formatter: function (val) {
                        return val;
                    }
                }
            },
        };

        const chart = new ApexCharts(chartSelector, options);
        chart.render();
    }
};
