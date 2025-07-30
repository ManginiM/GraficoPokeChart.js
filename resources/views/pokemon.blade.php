<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gráfico de Pokémon</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h2>Selecciona un Pokémon</h2>

  <select id="pokemonSelect">
    <option value="">-- Elegir --</option>
    <option value="pikachu">Pikachu</option>
    <option value="bulbasaur">Bulbasaur</option>
    <option value="charmander">Charmander</option>
    <option value="squirtle">Squirtle</option>
    <option value="mew">Mew</option>
    <!-- Podés agregar más -->
  </select>

  <canvas id="pokemonChart" width="400" height="200"></canvas>

  <script>
    let chart; // lo declaramos afuera para poder actualizarlo

    document.getElementById('pokemonSelect').addEventListener('change', function () {
      const selectedPokemon = this.value;
      if (!selectedPokemon) return;

      fetch(`https://pokeapi.co/api/v2/pokemon/${selectedPokemon}`)
        .then(response => response.json())
        .then(data => {
          const labels = data.stats.map(stat => stat.stat.name);
          const values = data.stats.map(stat => stat.base_stat);

          const ctx = document.getElementById('pokemonChart').getContext('2d');

          // Si ya hay un gráfico, lo destruimos
          if (chart) chart.destroy();

          chart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                label: `Stats de ${selectedPokemon}`,
                data: values,
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        })
        .catch(err => {
          alert("Error al obtener datos de la API");
          console.error(err);
        });
    });
  </script>
</body>
</html>
