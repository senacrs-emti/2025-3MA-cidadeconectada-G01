let map = L.map('map').setView([-30.0254089, -51.2117849], 16);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'OpenStreetMap'
}).addTo(map);

// variaveis de controle do mapa
let denunciaAtiva = false;
let pinTemporario = null;
let userMarker = null;

const userLat = -30.0254089;
const userLng = -51.2117849;

const userIcon = L.icon({
    iconUrl: "https://cdn-icons-png.flaticon.com/512/64/64113.png",
    iconSize: [32, 32],
    iconAnchor: [16, 32]
});

userMarker = L.marker([userLat, userLng], { icon: userIcon}).addTo(map);

const btnDenuncia = document.getElementById("btnDenuncia");
const btnLocalizar = document.getElementById("btnLocalizar")
const filterButtons = document.querySelectorAll(".filter-btn");

// ativar/destaivar modo denúncia
btnDenuncia.addEventListener("click", () => {
    denunciaAtiva = !denunciaAtiva;
    btnDenuncia.textContent = denunciaAtiva ? "Denúncia: ON" : "Denúncia: OFF";
    btnDenuncia.className = denunciaAtiva ? "btn-toggle ativado" : "btn-toggle desativado";

    if(!denunciaAtiva && pinTemporario) {
        map.removeLayer(pinTemporario);
        pinTemporario = null;
    }
});

// pin temporario (para fins ilustrativos antes de confirmar a denuncia)
map.on("click", (e) => {
    if (!denunciaAtiva) return;

    const { lat, lng} = e.latlng;

    if(pinTemporario) map.removeLayer(pinTemporario);
    pinTemporario = L.marker([lat, lng]).addTo(map);

    pinTemporario.bindPopup(
        `
        <div class="popup">
            <p style="color: black"><b>Latitude:</b> ${lat.toFixed(6)} <br> <b>Longitude:</b> ${lng.toFixed(6)}</p>
            <button id="cancelar">Cancelar</button>
            <button id="confirmar">Denunciar</button>
        </div>
    `).openPopup();

    setTimeout(() => {
        document.getElementById("cancelar").onclick = () => {
            map.removeLayer(pinTemporario);
            pinTemporario = null;
            denunciaAtiva = false;
            btnDenuncia.className = "Denúncia: OFF";
            btnDenuncia.className = "btn-toggle desativado";

        };

        document.getElementById("confirmar").onclick = () => {
            fetch("../action/addDenuncia.php", {
                method: "POST",
                headers: {"Content-Type": "application/json" },
                body: JSON.stringify({ lat, lng})
            }).then(() => {
                alert("denuncia registrada!");
                carregarMarcadores();
                map.removeLayer(pinTemporario);
                pinTemporario = null;
                denunciaAtiva = false;
                btnDenuncia.className = "Denúncia: OFF";
                btnDenuncia.className = "btn-toggle desativado";
            });
        };
    }, 200);
});
    
// Carregar marcadores
function carregarMarcadores(tempo = 1){
    fetch(`../action/getMarcadores.php?tempo=${tempo}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(p => {
                L.marker([p.latitude, p.longitude]).addTo(map);
            });
        });
}

// Filtro
filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        filterButtons.forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
        carregarMarcadores(btn.dataset.tempo);
    });
});


// Botão centralizar
btnLocalizar.addEventListener("click", () => {
    if (userMarker) {
        map.setView(userMarker.getLatLng(), 17);
    }
});

carregarMarcadores();