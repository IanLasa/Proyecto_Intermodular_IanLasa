// Array con cada carta y su imagén como objeto (0 == El loco / 1 == El mago ...)
const arcanos = [
    { nombre: "El Loco",       img: "00_el_loco.jpg" },
    { nombre: "El Mago",       img: "01_el_mago.jpg" },
    { nombre: "La Sacerdotisa",img: "02_la_sacerdotisa.jpg" },
    { nombre: "La Emperatriz", img: "03_la_emperatriz.jpg" },
    { nombre: "El Emperador",  img: "04_el_emperador.jpg" },
    { nombre: "El Hierofante", img: "05_el_hierofante.jpg" },
    { nombre: "Los Enamorados",img: "06_los_enamorados.jpg" },
    { nombre: "El Carro",      img: "07_el_carro.jpg" },
    { nombre: "La Fuerza",     img: "08_la_fuerza.jpg" },
    { nombre: "El Ermitaño",   img: "09_el_ermitano.jpg" },
    { nombre: "La Rueda",      img: "10_la_rueda.jpg" },
    { nombre: "La Justicia",   img: "11_la_justicia.jpg" },
    { nombre: "El Colgado",    img: "12_el_colgado.jpg" },
    { nombre: "La Muerte",     img: "13_la_muerte.jpg" },
    { nombre: "La Templanza",  img: "14_la_templanza.jpg" },
    { nombre: "El Diablo",     img: "15_el_diablo.jpg" },
    { nombre: "La Torre",      img: "16_la_torre.jpg" },
    { nombre: "La Estrella",   img: "17_la_estrella.jpg" },
    { nombre: "La Luna",       img: "18_la_luna.jpg" },
    { nombre: "El Sol",        img: "19_el_sol.jpg" },
    { nombre: "El Juicio",     img: "20_el_juicio.jpg" },
    { nombre: "El Mundo",      img: "21_el_mundo.jpg" }
];

// Crear 
const configuracion = {
    mystic: {
        clase: "mazo-mystic",
        nombreMazo: "🌙 Mazo Místico",
        titulo: "Elige tu carta",
        subtitulo: "Seis cartas te esperan. Solo una tiene tu mensaje.",
        lecturaTitulo: "✦ La lectura ✦",
    },
    rational: {
        clase: "mazo-rational",
        nombreMazo: "🧩 Mazo Racional",
        titulo: "Selecciona una carta",
        subtitulo: "Elige la carta que más resuene contigo.",
        lecturaTitulo: "— Análisis —",
    },
    sarcastic: {
        clase: "mazo-sarcastic",
        nombreMazo: "💀 Mazo Sarcástico",
        titulo: "Elige. Si es que puedes.",
        subtitulo: "Las cartas ya saben que vas a equivocarte.",
        lecturaTitulo: "// Veredicto //",
    }
};

let mazo_actual = 'mystic';
let cartas_actuales = [];
let lectura_en_curso = false;

// Intenta encontrar que mazo se ha escogio antes, si no lo encuentra, pone por defecto mystic 
function init() {
    const mazoGuardado = localStorage.getItem('mazoSeleccionado') || 'mystic';
    // Comprobar que existe comparandolo con configuracion
    mazo_actual = configuracion[mazoGuardado] ? mazoGuardado : 'mystic';
    aplicar_mazo();
    render_cartas();
}

function aplicar_mazo() {
    const cfg = configuracion[mazo_actual];
    // cambiar el body, para que el css fucnione dependiendo del mazo elegido
    document.body.className = cfg.clase;
    // Rellenar el html con los campos de la constante configuracion, del mazo elegido
    document.getElementById('nombre-mazo').textContent = cfg.nombreMazo;
    document.getElementById('titulo-tirada').textContent = cfg.titulo;
    document.getElementById('subtitulo-tirada').textContent = cfg.subtitulo;
    document.getElementById('lectura-titulo').textContent = cfg.lecturaTitulo;
}

function shuffle(arr) {
    // los 3 puntos, para no desordenar las imágenes originales
    const a = [...arr];
    // empezando desde el final para luego
    for (let i = a.length - 1; i > 0; i--) {
        // crear un numero del 0 al 1, y luego multiplicarlo a (i + 1), y luego lo redondea
        const j = Math.floor(Math.random() * (i + 1));
        // Cambiar el que se haya elegido, por i, para que ya no se vuelva a utilizar
        let temporal = a[i];
        a[i] = a[j];
        a[j] = temporal;
    }
    return a;
}

function render_cartas() {
    // Crear un array con 6 cartas aleatorias
    cartas_actuales = shuffle(arcanos).slice(0, 6);
    // Buscar donde iran las cartas
    const grid = document.getElementById('cartas-grid');
    // Borrar cartas anteriore
    grid.innerHTML = '';
    // Para no poder elegir mas tras elegir una
    lectura_en_curso = false;
    // Esconder el rectangulo de lectura
    document.getElementById('lectura-box').classList.remove('visible', 'aparecer');
    document.getElementById('lectura-box').style.display = 'none';
    
    // Esconder el boton para que no salga siga apareciendo al reiniciar
    document.getElementById('btn-nueva').classList.remove('visible');

    cartas_actuales.forEach((carta, i) => {
        // Crear un div vacio
        const wrapper = document.createElement('div');
        // Asignar clase
        wrapper.className = 'carta-wrapper';
        // classes para modificar en el css
        wrapper.innerHTML = `
            <div class="carta-inner">
                <div class="carta-back">
                    <div class="patron">
                        ${Array(9).fill('<span></span>').join('')}
                    </div>
                </div>
                <div class="carta-front">
                    <img src="../../Imagenes/cartas/normales/${carta.img}" alt="${carta.nombre}">
                    <div class="nombre-carta">${carta.nombre}</div>
                </div>
            </div>`;
        // Si se clica una carta, se ejecuta elegir_carta
        wrapper.addEventListener('click', () => elegir_carta(wrapper, carta, i));
        // Insertar el div en el html
        grid.appendChild(wrapper);
    });
}

function elegir_carta(wrapper, carta, idx) {
    // Si ya se ha elegido una carta, para
    if (lectura_en_curso) return;
    // Si no, continua, y se cambia a true, para que no se pueda elegir otra
    lectura_en_curso = true;

    // Añadir la clase flipped a la carta 
    wrapper.classList.add('flipped');

    // Estética, para que las cartas que no se han escogido, se vuelvan mas oscuras, y no se les pueda hacer clic.
    document.querySelectorAll('.carta-wrapper').forEach((w, i) => {
        if (i !== idx) w.classList.add('no-click', 'descartada');
    });
    // Esperar un poco, para que no salga directamente la lectura
    setTimeout(() => mostrar_lectura(carta), 600);
}

function mostrar_lectura(carta) {
    // html a rellenar, se guarda en variables
    const box = document.getElementById('lectura-box');
    const texto = document.getElementById('lectura-texto');
    const separador = document.getElementById('separador');

    // Mostrar la cajita de lectura
    box.classList.add('visible');
    box.style.display = 'block';

    // lOS TRES PUNTITOS
    texto.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div>';

    // Esperar un poco para la animación
    setTimeout(() => box.classList.add('aparecer'), 50);

    // Crear un formulario con el nombre de la carta, y el mazo actual, luego se envía al PHP
    const form_data = new FormData();
    form_data.append('carta', carta.nombre);
    form_data.append('mazo', mazo_actual);

    // Petición POST al php
    fetch('reading.php', {
        method: 'POST',
        body: form_data
    })

    // Convertir lo que devuelve el php
    .then(res => res.json())
    
    // Meter el resultado en el html para que se vea, si está vacio pone el mensaje alternativo
    .then(data => {
        texto.textContent = data.lectura || 'Las cartas guardan silencio esta vez...';
        document.getElementById('btn-nueva').classList.add('visible');
    })

    // Si algo falla pone lo siguiente
    .catch(() => {
        texto.textContent = 'El oráculo no responde. Comprueba que la IA está activa.';
        document.getElementById('btn-nueva').classList.add('visible');
    });
}

function nueva_tirada() {
    render_cartas();
}

init();