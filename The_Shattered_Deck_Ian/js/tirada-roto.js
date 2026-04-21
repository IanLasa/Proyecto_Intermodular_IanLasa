// Array con cada carta y su imagén como objeto (0 == El loco / 1 == El mago ...)
const arcanos = [
    { nombre: "El Loco",        img: "00_el_loco.jpg" },
    { nombre: "El Mago",        img: "01_el_mago.jpg" },
    { nombre: "La Sacerdotisa", img: "02_la_sacerdotisa.jpg" },
    { nombre: "La Emperatriz",  img: "03_la_emperatriz.jpg" },
    { nombre: "El Emperador",   img: "04_el_emperador.jpg" },
    { nombre: "El Hierofante",  img: "05_el_hierofante.jpg" },
    { nombre: "Los Enamorados", img: "06_los_enamorados.jpg" },
    { nombre: "El Carro",       img: "07_el_carro.jpg" },
    { nombre: "La Fuerza",      img: "08_la_fuerza.jpg" },
    { nombre: "El Ermitaño",    img: "09_el_ermitano.jpg" },
    { nombre: "La Rueda",       img: "10_la_rueda.jpg" },
    { nombre: "La Justicia",    img: "11_la_justicia.jpg" },
    { nombre: "El Colgado",     img: "12_el_colgado.jpg" },
    { nombre: "La Muerte",      img: "13_la_muerte.jpg" },
    { nombre: "La Templanza",   img: "14_la_templanza.jpg" },
    { nombre: "El Diablo",      img: "15_el_diablo.jpg" },
    { nombre: "La Torre",       img: "16_la_torre.jpg" },
    { nombre: "La Estrella",    img: "17_la_estrella.jpg" },
    { nombre: "La Luna",        img: "18_la_luna.jpg" },
    { nombre: "El Sol",         img: "19_el_sol.jpg" },
    { nombre: "El Juicio",      img: "20_el_juicio.jpg" },
    { nombre: "El Mundo",       img: "21_el_mundo.jpg" }
];

// Caracteres glitch para corromper el texto
const glitch_chars = '!@#$%^&*░▒▓█▄▀■□▪▫◊◦∆∇≠≈∞§¶†‡';

let lectura_en_curso = false;

function shuffle(arr) {
    // Los 3 puntos, para no desordenar el array original
    const a = [...arr];
    // Empezando desde el final
    for (let i = a.length - 1; i > 0; i--) {
        // Crear un numero del 0 al 1, multiplicarlo a (i + 1), y redondearlo
        const j = Math.floor(Math.random() * (i + 1));
        // Cambiar el que se haya elegido por i, para que no se vuelva a utilizar
        let temporal = a[i];
        a[i] = a[j];
        a[j] = temporal;
    }
    return a;
}

// Sustituye algunos caracteres del texto por caracteres glitch aleatorios
function corromper_texto(texto) {
    return texto.split('').map(c => {
        // 8% de probabilidad de corromper cada caracter, excepto espacios
        if (Math.random() < 0.08 && c !== ' ') {
            return glitch_chars[Math.floor(Math.random() * glitch_chars.length)];
        }
        return c;
    }).join('');
}

function render_cartas() {
    // Buscar donde irán las cartas
    const grid = document.getElementById('cartas-grid');
    // Borrar cartas anteriores
    grid.innerHTML = '';
    // Para no poder elegir más tras elegir una
    lectura_en_curso = false;

    // Esconder el rectángulo de lectura
    document.getElementById('lectura-box').classList.remove('visible', 'aparecer');
    document.getElementById('lectura-box').style.display = 'none';
    document.getElementById('separador').classList.remove('visible');

    // Esconder el botón para que no siga apareciendo al reiniciar
    document.getElementById('btn-nueva').classList.remove('visible');

    // Crear un array con 6 cartas aleatorias
    const cartas_actuales = shuffle(arcanos).slice(0, 6);

    cartas_actuales.forEach((carta, i) => {
        // Crear un div vacío
        const wrapper = document.createElement('div');
        // Asignar clase
        wrapper.className = 'carta-wrapper';
        // Clases para modificar en el css, el nombre se corrompe con glitch
        wrapper.innerHTML = `
            <div class="carta-inner">
                <div class="carta-back">
                    <div class="patron-roto">
                        ${Array(9).fill('<span></span>').join('')}
                    </div>
                </div>
                <div class="carta-front">
                    <img src="../../Imagenes/cartas/normales/${carta.img}" alt="${carta.nombre}">
                    <div class="nombre-carta">${corromper_texto(carta.nombre)}</div>
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
    // Si no, continua, y se cambia a true para que no se pueda elegir otra
    lectura_en_curso = true;

    // Añadir la clase flipped a la carta elegida
    wrapper.classList.add('flipped');

    // Las cartas no elegidas se oscurecen y no se puede hacer clic en ellas
    document.querySelectorAll('.carta-wrapper').forEach((w, i) => {
        if (i !== idx) w.classList.add('no-click', 'descartada');
    });

    // Esperar un poco para que el flip termine antes de mostrar la lectura
    setTimeout(() => mostrar_lectura(carta), 800);
}

function mostrar_lectura(carta) {
    // HTML a rellenar, se guarda en variables
    const box       = document.getElementById('lectura-box');
    const texto     = document.getElementById('lectura-texto');
    const separador = document.getElementById('separador');

    // Hacer visible la cajita de lectura
    separador.classList.add('visible');
    box.classList.add('visible');
    box.style.display = 'block';

    // Mensaje de carga con estética rota
    texto.innerHTML = '<span class="loading-roto">█ ACCEDIENDO AL ORÁCULO...</span>';

    // Esperar un poco para la animación
    setTimeout(() => box.classList.add('aparecer'), 50);

    // Crear un formulario con el nombre de la carta y el mazo, luego se envía al PHP
    const form_data = new FormData();
    form_data.append('carta', carta.nombre);
    form_data.append('mazo', 'roto');

    // Petición POST al php
    fetch('reading.php', { method: 'POST', body: form_data })

        // Convertir lo que devuelve el php
        .then(res => res.json())

        // Meter el resultado en el html con efecto typewriter glitch
        .then(data => {
            const lectura = data.lectura || '...';
            typewriter_glitch(texto, lectura);
            document.getElementById('btn-nueva').classList.add('visible');
        })

        // Si algo falla muestra el mensaje de señal perdida
        .catch(() => {
            texto.textContent = 'S̷E̶Ñ̵A̴L̷ ̸P̸E̷R̴D̵I̷D̶A̴';
            document.getElementById('btn-nueva').classList.add('visible');
        });
}

// Efecto typewriter: escribe el texto letra a letra con glitches aleatorios
function typewriter_glitch(el, texto_final) {
    el.innerHTML = '';
    let i = 0;

    // Cursor parpadeante al final del texto
    const cursor = document.createElement('span');
    cursor.className = 'cursor';
    el.appendChild(cursor);

    function escribir() {
        // Si ya se han escrito todas las letras, eliminar el cursor y parar
        if (i >= texto_final.length) {
            cursor.remove();
            return;
        }

        // 6% de probabilidad de mostrar un carácter corrupto antes del real
        if (Math.random() < 0.06) {
            const char_glitch = glitch_chars[Math.floor(Math.random() * glitch_chars.length)];
            // Insertar el carácter corrupto antes del cursor
            cursor.insertAdjacentText('beforebegin', char_glitch);
            setTimeout(() => {
                // Buscar el nodo de texto que contiene el carácter corrupto y reemplazarlo
                const nodos = el.childNodes;
                for (let n of nodos) {
                    if (n.nodeType === 3 && n.textContent.includes(char_glitch)) {
                        n.textContent = n.textContent.replace(char_glitch, texto_final[i]);
                        break;
                    }
                }
                i++;
                setTimeout(escribir, 35);
            }, 80);
        } else {
            // Insertar el carácter real directamente
            cursor.insertAdjacentText('beforebegin', texto_final[i]);
            i++;
            // 5% de probabilidad de hacer una pausa larga, simulando interferencia
            setTimeout(escribir, Math.random() < 0.05 ? 150 : 30);
        }
    }

    escribir();
}

function nueva_tirada() {
    render_cartas();
}

render_cartas();