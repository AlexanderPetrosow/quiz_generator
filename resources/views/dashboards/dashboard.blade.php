
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div style="width: 75%;">
    <canvas id="answersChart"></canvas>
</div>

<script>
    // Используйте fetch или Axios для получения данных из сервера
    fetch("/questions/{{ $question->id }}/answers-data")
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('answersChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.answer_text),
                    datasets: [{
                        label: '# of Votes',
                        data: data.map(item => item.count),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
</script>
