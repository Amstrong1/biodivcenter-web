<script setup>
import { onMounted, ref } from 'vue';

const markers = ref([]);
let map = null;

const props = defineProps({
    initialMarkers: {
        type: Array,
        required: true
    },
});

/* ----------------------------- Initialize Map ----------------------------- */
function initMap() {
    map = L.map('map', {
        center: {
            lat: 10.9333,
            lng: 1.11667,
        },
        zoom: 8
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    map.on('click', mapClicked);
    initMarkers();
}

/* --------------------------- Initialize Markers --------------------------- */
function initMarkers() {
    props.initialMarkers.forEach((data, index) => {
        const marker = generateMarker(data, index);
        marker.addTo(map).bindPopup(`<b>${data.position.lat},  ${data.position.lng}</b>`);
        map.panTo(data.position);
        markers.value.push(marker);
    });
}

function generateMarker(data, index) {
    return L.marker(data.position, {
        draggable: data.draggable
    })
        .on('click', (event) => markerClicked(event, index))
        .on('dragend', (event) => markerDragEnd(event, index));
}

/* ------------------------- Handle Map Click Event ------------------------- */
function mapClicked($event) {
    console.log($event.latlng.lat, $event.latlng.lng);
}

/* ------------------------ Handle Marker Click Event ----------------------- */
function markerClicked($event, index) {
    console.log($event.latlng.lat, $event.latlng.lng);
}

/* ----------------------- Handle Marker DragEnd Event ---------------------- */
function markerDragEnd($event, index) {
    console.log($event.target.getLatLng());
}

/* ---------------------- Mount the map after component loads ----------------- */
onMounted(() => {
    initMap();
});
</script>

<template>
    <div id="map"></div>
</template>

<style scoped>
#map {
    height: 80%;
    width: 100%;
}
</style>