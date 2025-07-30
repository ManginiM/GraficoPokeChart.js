<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráfico de Pokémon</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .chart-container {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
    }
    .chart-box {
      width: 45%;
      min-width: 400px;
    }
    h2, h3 {
      color: #333;
    }
    select {
      padding: 8px 12px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <h2>Selecciona un Pokémon</h2>

  <select id="pokemonSelect">
    <option value="">-- Elegir --</option>
    <option value="pikachu">Pikachu</option>
    <option value="bulbasaur">Bulbasaur</option>
    <option value="charmander">Charmander</option>
    <option value="squirtle">Squirtle</option>
    <option value="eevee">Eevee</option>
    <option value="gengar">Gengar</option>
    <option value="dragonite">Dragonite</option>
    <option value="snorlax">Snorlax</option>
    <option value="mew">Mew</option>
    <option value="mewtwo">Mewtwo</option>
    
  </select>

  <div class="chart-container">
    <div class="chart-box">
      <h3>Estadísticas Base</h3>
      <canvas id="pokemonChart" width="400" height="300"></canvas>
    </div>
    <div class="chart-box">
      <h3>Progreso de Evoluciones</h3>
      <canvas id="evolutionChart" width="400" height="300"></canvas>
    </div>
  </div>

  <script>
    let statsChart; // Gráfico de estadísticas
    let evolutionChart; // Gráfico de evoluciones

    // Función para generar colores basados en el nombre del Pokémon
    function getColorFromName(name) {
      let hash = 0;
      for (let i = 0; i < name.length; i++) {
        hash = name.charCodeAt(i) + ((hash << 5) - hash);
      }
      
      // Usamos HSL para mejor control del color
      const h = Math.abs(hash) % 360;
      const s = 70 + Math.abs(hash) % 15; // Saturación entre 70-85%
      const l = 50 + Math.abs(hash) % 15; // Luminosidad entre 50-65%
      
      return `hsl(${h}, ${s}%, ${l}%)`;
    }

    // Función para generar variaciones de color para las barras
    function generateColorVariations(baseColor, count) {
      const hslRegex = /hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/;
      const match = baseColor.match(hslRegex);
      
      if (!match) return Array(count).fill(baseColor);
      
      const h = parseInt(match[1]);
      const s = parseInt(match[2]);
      const l = parseInt(match[3]);
      
      return Array(count).fill(0).map((_, i) => {
        // Variamos ligeramente el tono para cada barra
        const hueVariation = (i * 15) % 60; // Máximo 60 grados de variación
        const newH = (h + hueVariation) % 360;
        return `hsl(${newH}, ${s}%, ${l}%)`;
      });
    }

    // Función para oscurecer un color (para los bordes)
    function darkenColor(color, percent) {
      const hslRegex = /hsl\((\d+),\s*([\d.]+)%,\s*([\d.]+)%\)/;
      const match = color.match(hslRegex);
      
      if (!match) return color;
      
      const h = match[1];
      const s = match[2];
      let l = parseFloat(match[3]);
      l = Math.max(0, l - percent);
      
      return `hsl(${h}, ${s}%, ${l}%)`;
    }

    document.getElementById('pokemonSelect').addEventListener('change', async function () {
      const selectedPokemon = this.value;
      if (!selectedPokemon) return;

      try {
        // Obtener datos básicos del Pokémon
        const pokemonResponse = await fetch(`https://pokeapi.co/api/v2/pokemon/${selectedPokemon}`);
        const pokemonData = await pokemonResponse.json();

        // Mostrar gráfico de estadísticas base
        updateStatsChart(pokemonData, selectedPokemon);

        // Obtener cadena de evolución
        const speciesResponse = await fetch(pokemonData.species.url);
        const speciesData = await speciesResponse.json();
        
        const evolutionResponse = await fetch(speciesData.evolution_chain.url);
        const evolutionData = await evolutionResponse.json();

        // Procesar cadena de evolución
        const evolutionChain = await processEvolutionChain(evolutionData.chain);
        
        // Mostrar gráfico de evoluciones
        updateEvolutionChart(evolutionChain, selectedPokemon);

      } catch (err) {
        alert("Error al obtener datos de la API");
        console.error(err);
      }
    });

    // Función para procesar la cadena de evolución
    async function processEvolutionChain(chain) {
      const result = [];
      
      async function traverse(evolutionNode, stage) {
        const pokemonName = evolutionNode.species.name;
        const pokemonResponse = await fetch(`https://pokeapi.co/api/v2/pokemon/${pokemonName}`);
        const pokemonData = await pokemonResponse.json();
        
        result.push({
          name: pokemonName,
          stage: stage,
          stats: pokemonData.stats.map(stat => stat.base_stat)
        });

        for (const nextEvolution of evolutionNode.evolves_to) {
          await traverse(nextEvolution, stage + 1);
        }
      }

      await traverse(chain, 1);
      return result;
    }

    // Función para actualizar el gráfico de estadísticas
    function updateStatsChart(data, pokemonName) {
      const labels = data.stats.map(stat => stat.stat.name);
      const values = data.stats.map(stat => stat.base_stat);
      
      // Generar colores para este Pokémon
      const baseColor = getColorFromName(pokemonName);
      const backgroundColors = generateColorVariations(baseColor, labels.length);
      const borderColors = backgroundColors.map(c => darkenColor(c, 15));

      const ctx = document.getElementById('pokemonChart').getContext('2d');

      if (statsChart) statsChart.destroy();

      statsChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: `Stats de ${pokemonName}`,
            data: values,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Valor de estadística'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Estadísticas'
              }
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'top',
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return `${context.dataset.label}: ${context.raw}`;
                }
              }
            }
          }
        }
      });
    }

    // Función para actualizar el gráfico de evoluciones
    function updateEvolutionChart(evolutionChain, pokemonName) {
      const ctx = document.getElementById('evolutionChart').getContext('2d');
      const statNames = ['HP', 'Ataque', 'Defensa', 'Ataque Especial', 'Defensa Especial', 'Velocidad'];
      
      if (evolutionChart) evolutionChart.destroy();

      // Si solo hay un Pokémon en la cadena (no tiene evoluciones)
      if (evolutionChain.length <= 1) {
        evolutionChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: [`${pokemonName} (Sin evoluciones)`],
            datasets: [{
              label: 'Este Pokémon no tiene evoluciones',
              data: [1],
              backgroundColor: getColorFromName(pokemonName),
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: { display: false },
              x: { display: false }
            },
            plugins: {
              legend: { display: false },
              title: {
                display: true,
                text: 'Este Pokémon no tiene evoluciones',
                position: 'top'
              },
              tooltip: { enabled: false }
            }
          }
        });
        return;
      }

      // Preparar datasets para cada estadística
      const datasets = statNames.map((statName, index) => {
        const baseColor = getColorFromName(statName.toLowerCase());
        return {
          label: statName,
          data: evolutionChain.map(pokemon => pokemon.stats[index]),
          borderColor: baseColor,
          backgroundColor: baseColor.replace(')', ', 0.2)').replace('hsl', 'hsla'),
          borderWidth: 3,
          tension: 0.3,
          fill: true
        };
      });

      evolutionChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: evolutionChain.map(pokemon => `${pokemon.name} (Etapa ${pokemon.stage})`),
          datasets: datasets
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Valor de estadística'
              }
            },
            x: {
              title: {
                display: true,
                text: 'Etapas de evolución'
              }
            }
          },
          plugins: {
            title: {
              display: true,
              text: 'Progreso de estadísticas por evolución'
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return `${context.dataset.label}: ${context.raw}`;
                }
              }
            }
          }
        }
      });
    }
  </script>
</body>
</html>