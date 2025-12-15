/**
 * Gráfico de Meta Mensal - ApexCharts Radial
 * Exibe progresso da meta em formato circular
 */

export const initGoalChart = () => {
    const elementoGrafico = document.querySelector('#goalChart');

    if (!elementoGrafico) {
        return;
    }

    // Verificar se ApexCharts está carregado
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts não está carregado!');
        return;
    }

    // Pegar porcentagem do data attribute
    let goalPercentage = 75.55; // Valor padrão
    
    if (elementoGrafico.dataset.percentage) {
        goalPercentage = parseFloat(elementoGrafico.dataset.percentage);
    }

    const opcoesGrafico = {
        series: [goalPercentage],
        colors: ["#5b68f0"], // Azul/roxo
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "radialBar",
            height: 230,
            sparkline: {
                enabled: true,
            },
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                hollow: {
                    size: "70%",
                    image: undefined,
                },
                track: {
                    background: "#e5e7eb", // Cinza claro
                    strokeWidth: "100%",
                    margin: 5,
                },
                dataLabels: {
                    show: true,
                    name: {
                        show: false, // Ocultar label separada
                    },
                    value: {
                        show: true,
                        fontSize: "40px",
                        fontFamily: "Outfit, sans-serif",
                        fontWeight: "700",
                        color: "#1f2937",
                        offsetY: -10, // Subir texto para dar espaço ao badge
                        formatter: function (val) {
                            return val + "%"; // % junto do número
                        },
                    },
                },
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "light",
                type: "horizontal",
                shadeIntensity: 0.5,
                gradientToColors: ["#7c3aed"], // Roxo mais escuro
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 100],
            },
        },
        stroke: {
            lineCap: "round",
        },
        labels: ["%"], // Label que aparece embaixo do número
    };

    // Destruir gráfico existente se houver
    if (elementoGrafico.__apexchart) {
        elementoGrafico.__apexchart.destroy();
    }

    const grafico = new ApexCharts(elementoGrafico, opcoesGrafico);
    grafico.render();
    
    // Armazenar referência
    elementoGrafico.__apexchart = grafico;
    
    return grafico;
};

// Reinicializar quando Livewire atualizar
if (typeof Livewire !== 'undefined') {
    Livewire.hook('morph.updated', () => {
        setTimeout(() => {
            if (document.querySelector('#goalChart')) {
                initGoalChart();
            }
        }, 100);
    });
}

export default initGoalChart;
