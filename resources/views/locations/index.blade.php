<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Lokasi</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 600px; }
    </style>
</head>
<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        const map = L.map('map').setView([-6.984072660831396, 110.40926002179977], 10); // Koordinat pusat

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWRpZ3VuYXdhbnhkIiwiYSI6ImNrcWp2Yjg2cDA0ZjAydnJ1YjN0aDNnbm4ifQ.htvHCgSgN0UuV8hhZBfBfQ', {
                maxZoom: 50,
                id: 'mapbox/satellite-streets-v11',
                accessToken: 'pk.eyJ1IjoiYWRpZ3VuYXdhbnhkIiwiYSI6ImNrcWp2Yjg2cDA0ZjAydnJ1YjN0aDNnbm4ifQ.htvHCgSgN0UuV8hhZBfBfQ'
            }).addTo(map);


        const locations = @json($locations);

        locations.forEach(location => {
            const marker = L.marker([location.latitude, location.longitude]).addTo(map)
                .bindPopup(`<b>${location.nama_petani}</b><br>No Lahan: ${location.no_lahan}`)
                .on('mouseover', function () {
                    this.openPopup();
                })
                .on('mouseout', function () {
                    this.closePopup();
                })
                .on('dblclick', function () {
                    // Ambil detail dan gambar polygon
                    const polygon = location.polygon; // bisa diubah untuk mendukung format GeoJSON
                    const coords = polygon.replace('POLYGON((', '').replace('))', '').split(',').map(coord => {
                        const [lng, lat] = coord.trim().split(' ');
                        return [parseFloat(lat), parseFloat(lng)];
                    });

                    const poly = L.polygon(coords).addTo(map).bindPopup('Detail titik terkait').openPopup();
                    map.fitBounds(poly.getBounds()); // Zoom ke polygon
                });
        });
    </script>
</body>
</html>
