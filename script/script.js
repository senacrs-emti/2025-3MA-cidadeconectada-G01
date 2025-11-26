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

// ativar/destaivar modo denúncia (exige login)
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

    const agora = new Date();
    const horarioStr = agora.toLocaleString('pt-BR');

    pinTemporario.bindPopup(
        `
        <div class="popup">
            <p style="color: black"><b>Latitude:</b> ${lat.toFixed(6)} <br> <b>Longitude:</b> ${lng.toFixed(6)}<br><b>Horário:</b> ${horarioStr}</p>
            <button id="cancelar">Cancelar</button>
            <button id="confirmar">Denunciar</button>
        </div>
    `).openPopup();

    setTimeout(() => {
        const btnCancelar = document.getElementById("cancelar");
        const btnConfirmar = document.getElementById("confirmar");

        if (btnCancelar) {
            btnCancelar.onclick = () => {
                map.removeLayer(pinTemporario);
                pinTemporario = null;
                denunciaAtiva = false;
                btnDenuncia.textContent = "Denúncia: OFF";
                btnDenuncia.className = "btn-toggle desativado";
            };
        }

        if (btnConfirmar) {
            btnConfirmar.onclick = () => {
                if (!LOGGED_IN) {
                    alert("Você precisa estar logado para confirmar a denúncia.");
                    window.location.href = "./login.php";
                    return;
                }

                const formData = new FormData();
                formData.append("lat", lat);
                formData.append("lng", lng);

                fetch("../action/addDenuncia.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.text())
                .then(resp => {
                    if (resp.trim() === "OK") {
                        alert("Denúncia registrada!");
                    } else {
                        alert(resp);
                    }
                    carregarMarcadores();
                    if (pinTemporario) {
                        map.removeLayer(pinTemporario);
                        pinTemporario = null;
                    }
                    denunciaAtiva = false;
                    btnDenuncia.textContent = "Denúncia: OFF";
                    btnDenuncia.className = "btn-toggle desativado";
                })
                .catch(err => {
                    alert("Erro na requisição: " + err);
                });
            };

        }
    }, 200);
});
    
// Carregar marcadores
function carregarMarcadores(tempo = 1) {
    fetch(`../action/getMarcadores.php?tempo=${tempo}`)
        .then(res => res.text())
        .then(texto => {
            map.eachLayer(layer => {
                if (layer instanceof L.Marker && layer !== userMarker) {
                    map.removeLayer(layer);
                }
            });

            const pontos = texto.split(";").filter(l => l.trim() !== "");

            pontos.forEach(ponto => {
                const partes = ponto.split(",");
                const lat = parseFloat(partes[0]);
                const lng = parseFloat(partes[1]);
                const dt = partes.slice(2).join(",");
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    const marker = L.marker([lat, lng]).addTo(map);
                    marker.bindPopup(
                        `<div class="popup">
                            <p style="color: black"><b>Latitude:</b> ${lat.toFixed(6)}<br><b>Longitude:</b> ${lng.toFixed(6)}<br><b>Horário:</b> ${dt}</p>
                        </div>`
                    );
                }
            });
        })
        .catch(err => console.error("Erro ao carregar marcadores:", err));
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
        map.setView(userMarker.getLatLng(), 16);
    }
});

carregarMarcadores();
