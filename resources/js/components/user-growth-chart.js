/**
 * Gráfico de Crescimento de Usuários - Inicialização ApexCharts
 * Exibe gráfico de barras com duas séries: dados de usuários e assinantes
 */

let graficoUsuarios = null;

/**
 * Inicializa o gráfico com os dados
 */
function inicializarGraficoUsuarios() {
    // Verificar se ApexCharts está carregado
    if (typeof ApexCharts === 'undefined') {
        console.error('Biblioteca ApexCharts não carregada!');
        return;
    }

    const elementoGrafico = document.querySelector('#userGrowthChart');
    if (!elementoGrafico) {
        console.error('Elemento do gráfico #userGrowthChart não encontrado!');
        return;
    }

    // Obter dados dos atributos data (definidos pelo Livewire)
    const dadosUsuarios = JSON.parse(elementoGrafico.dataset.users || '[]');
    const dadosAssinantes = JSON.parse(elementoGrafico.dataset.subscribers || '[]');
    const rotulos = JSON.parse(elementoGrafico.dataset.labels || '[]');

    const opcoes = {
        series: [
            {
                name: 'Usuários',
                data: dadosUsuarios,
                color: '#4c4ee7' // Azul escuro
            },
            {
                name: 'Assinantes',
                data: dadosAssinantes,
                color: '#0ea5e9' // Azul claro
            }
        ],
        chart: {
            type: 'bar',
            height: 260,
            toolbar: { show: false },
            fontFamily: 'inherit',
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '55%',
            }
        },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: rotulos,
            labels: {
                style: {
                    colors: '#9ca3af',
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            labels: { show: false }
        },
        grid: {
            borderColor: '#e5e7eb',
            strokeDashArray: 0,
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            markers: {
                width: 10,
                height: 10,
                radius: 2,
            }
        },
        tooltip: {
            y: {
                formatter: function (val, { seriesIndex }) {
                    return val + (seriesIndex === 0 ? ' usuários' : ' assinantes');
                }
            }
        }
    };

    // Destruir gráfico existente, se houver
    if (graficoUsuarios) {
        graficoUsuarios.destroy();
    }

    // Criar e renderizar novo gráfico
    graficoUsuarios = new ApexCharts(elementoGrafico, opcoes);
    graficoUsuarios.render();
}

// Inicializar ao carregar a página
document.addEventListener('DOMContentLoaded', function() {
    inicializarGraficoUsuarios();
});

// Reinicializar nas atualizações do Livewire
if (typeof Livewire !== 'undefined') {
    document.addEventListener('livewire:init', () => {
        Livewire.on('graficoAtualizado', () => {
            inicializarGraficoUsuarios();
        });
    });

    Livewire.hook('morph.updated', () => {
        setTimeout(() => inicializarGraficoUsuarios(), 100);
    });
}
