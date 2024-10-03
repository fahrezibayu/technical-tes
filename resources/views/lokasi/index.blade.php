<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Tes</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
        }

        #form-radius {
            position: absolute;
            top: -4%;
            right: 25%;
            left: 25%;
            width: 50%;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <div id="form-radius">
        <center>
            <h2>Technical Tes</h2>
        </center>
        <label for="radius">Masukkan Radius (km) </label>
        <input type="number" id="radius" value="1" min="1" />
        <button onclick="searchLokasiByRadius()">Tampilkan lokasi dalam radius</button>
    </div>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        function hitungJarak(coords1, coords2) {
            const toRad = (x) => x * Math.PI / 180;

            const R = 6371;
            const lat1 = coords1[0];
            const lon1 = coords1[1];
            const lat2 = coords2[0];
            const long2 = coords2[1];

            const dLat = toRad(lat2 - lat1);
            const dLon = toRad(long2 - lon1);
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            return R * c;
        }

        const titikUtama = [-7.094780, 107.435846];

        const map = L.map('map').setView(titikUtama, 12);

        L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiYWRpZ3VuYXdhbnhkIiwiYSI6ImNrcWp2Yjg2cDA0ZjAydnJ1YjN0aDNnbm4ifQ.htvHCgSgN0UuV8hhZBfBfQ', {
                maxZoom: 50,
                id: 'mapbox/satellite-streets-v11',
                accessToken: 'pk.eyJ1IjoiYWRpZ3VuYXdhbnhkIiwiYSI6ImNrcWp2Yjg2cDA0ZjAydnJ1YjN0aDNnbm4ifQ.htvHCgSgN0UuV8hhZBfBfQ'
            }).addTo(map);

        const treeIcon = L.icon({
            iconUrl: 'https://static.vecteezy.com/system/resources/previews/021/563/515/original/3d-realistic-icon-style-green-glossy-location-map-pin-gps-pointer-markers-illustration-for-destination-geo-tag-isolated-transparent-background-png.png', // Ganti dengan path ke ikon yang sesuai
            iconSize: [52, 52],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        let lingkupRadius = null;
        let polygonAwal = null;
        const lokasi = @json($lokasi);
        let titikLokasi = [];

        function searchLokasiByRadius() {
            const radius = document.getElementById('radius').value;
            const konversiMeter = radius * 1000;

            if (lingkupRadius) {
                map.removeLayer(lingkupRadius);
            }

            lingkupRadius = L.circle(titikUtama, {
                color: 'blue',
                fillColor: '#99ccff',
                fillOpacity: 0.3,
                radius: konversiMeter
            }).addTo(map);

            titikLokasi.forEach(marker => map.removeLayer(marker));
            titikLokasi = [];
            if (polygonAwal) {
                map.removeLayer(polygonAwal);
            }

            const bounds = [titikUtama];

            lokasi.forEach(location => {
                const lokasiKoordinat = [location.latitude, location.longitude];
                const jarak = hitungJarak(titikUtama, lokasiKoordinat);

                if (jarak <= radius) {
                    const marker = L.marker(lokasiKoordinat, {
                            icon: treeIcon
                        }).addTo(map)
                        .bindPopup(
                            `<b>${location.nama_petani}</b><br>No Lahan: ${location.no_lahan}<br>Jarak: ${jarak.toFixed(2)} km`
                            )
                        .on('mouseover', function() {
                            this.openPopup();
                        })
                        .on('mouseout', function() {
                            this.closePopup();
                        })
                        .on('dblclick', function() {
                            const polygon = location.polygon;
                            const koordinat = polygon.replace('POLYGON((', '').replace('))', '').split(',').map(
                                coord => {
                                    const [lng, lat] = coord.trim().split(' ');
                                    return [parseFloat(lat), parseFloat(lng)];
                                });

                            polygonAwal = L.polygon(koordinat, {
                                    color: 'red'
                                }).addTo(map)
                                .bindPopup('Detail titik terkait')
                                .openPopup();
                            map.fitBounds(polygonAwal.getBounds());
                        });

                    titikLokasi.push(marker);
                    bounds.push(lokasiKoordinat);
                }
            });

            const lingkaranRadius = lingkupRadius.getBounds();
            bounds.push(lingkaranRadius.getNorthEast(), lingkaranRadius.getSouthWest());

            map.fitBounds(bounds);
        }

        searchLokasiByRadius();
    </script>
</body>

</html>
