<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Kondisi Perangkat Komputer</title>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
</head>
<body>
<div class="container mt-3">
    <h3 class="text-center">Grafik Kondisi Perangkat Komputer</h3>
    <h6 class="text-center">Jumlah kondisi perangkat yang berumur ≥ 3 tahun</h6>
    <div id="device-umur-chart" style="width: 100%; height: 250px;"></div>
</div>

<script>
    const chart = echarts.init(document.getElementById('device-umur-chart'));

    const chartOptions = {
        title: { show: false },
        xAxis: {
            type: 'value',
            axisLabel: { fontSize: 13, color: '#6c757d' },
            axisLine: { show: false },
            axisTick: { show: false },
            splitLine: { lineStyle: { color: '#dee2e6' } },
            name: 'Jumlah',
            nameLocation: 'middle',
            nameTextStyle: { fontSize: 14, color: '#6c757d' },
            nameGap: 30,
        },
        yAxis: {
            type: 'category',
            data: ['Device Baik', 'Device Rusak'], 
            axisLabel: { fontSize: 13, color: '#6c757d' },
            axisLine: { show: false },
            axisTick: { show: false },
        },
        grid: {
            left: '5%',
            top: '15%',
            right: '5%',
            bottom: '15%',
            containLabel: true,
        },
        tooltip: {
            trigger: 'item',
            formatter: '{b}: {c}',
            backgroundColor: '#343a40',
            textStyle: { color: '#f8f9fa' },
            borderWidth: 0,
            padding: 10,
        },
        series: [
    {
        type: 'bar',
        data: [], // Data diisi dari API
        barWidth: 50,
        itemStyle: { 
            borderRadius: 10, 
            color: new echarts.graphic.LinearGradient(1, 0, 0, 0, [
                { offset: 0, color: '#0d6efd' }, // Warna awal (transparan)
                { offset: 1, color: 'rgba(13, 110, 253, 0.6)' } // Warna akhir (biru)
            ])
        },
        emphasis: { 
            itemStyle: { 
                color: new echarts.graphic.LinearGradient(1, 0, 0, 0, [
                    { offset: 0, color: '#0b5ed7' }, // Hover warna awal
                    { offset: 1, color: 'rgba(11, 94, 215, 0.6)' } // Hover warna akhir
                ])
            } 
        },
    },
],
    };

    chart.setOption(chartOptions);

    fetch('/devices/data')
        .then(response => response.json())
        .then(seriesData => {
            console.log('Series Data:', seriesData);

            const deviceBaik = seriesData.reduce((total, item) => total + item.baik, 0);
            const deviceRusak = seriesData.reduce((total, item) => total + item.rusak, 0);

            console.log('Device Baik:', deviceBaik);
            console.log('Device Rusak:', deviceRusak);

            chart.setOption({
                series: [
                    {
                        ...chartOptions.series[0],
                        data: [deviceBaik, deviceRusak], 
                    },
                ],
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>
</body>
</html>

