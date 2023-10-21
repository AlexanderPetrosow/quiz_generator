
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div style="width: 50%;">
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
                labels: data.chartData.map(item => item.answer_text),
                datasets: [{
                    label: '# of Votes',
                    data: data.chartData.map(item => item.count),
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

        // Заполнение таблицы
        const tableBody = document.getElementById('respondentsTableBody');
        data.respondentsData.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.user}</td>
                <td>${row.answer}</td>
                <td>${row.time}</td>
            `;
            tableBody.appendChild(tr);
        });
    });
</script>
<a href="{{ route('questions.qrcode', $uniqueKey) }}" download="QRCode-{{ $uniqueKey }}.png">Скачать QR-код </a>

    <table class="table mt-5">
    <thead>
        <tr>
            <th>Пользователь</th>
            <th>Ответ</th>
            <th>Время ответа</th>
        </tr>
    </thead>
    <tbody id="respondentsTableBody">
    </tbody>
</table>



