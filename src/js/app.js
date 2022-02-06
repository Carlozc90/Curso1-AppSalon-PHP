let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

// DOMContentLoaded --> cuando todo el DOM esta listo o cargado ejecula la funcion
document.addEventListener('DOMContentLoaded', function () {
  iniciarApp();
});

function iniciarApp() {
  // Muestra y oculta las secciones
  mostrarSeccion();

  // Cambia la seccion cuando se presionen los tabs
  tabs();

  //   Agrega o quita los botones
  botonesPaginador();

  //   navegacion de los botones siguiente anterior
  paginaAnterior();
  paginaSiguiente();
}

function mostrarSeccion() {
  // oculatar las seccion que tenga la clase de mostrar
  const seccionAnterior = document.querySelector('.mostrar');
  if (seccionAnterior) {
    seccionAnterior.classList.remove('mostrar');
  }

  // Seleccionar la seccion con el paso...
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add('mostrar');

  // remueve la clase de actual al tab anterior
  const tabAnterior = document.querySelector('.actual');
  if (tabAnterior) {
    tabAnterior.classList.remove('actual');
  }

  // resalta el tab actual
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add('actual');
}

function tabs() {
  const botones = document.querySelectorAll('.tabs button');

  botones.forEach((boton) => {
    boton.addEventListener('click', function (e) {
      paso = parseInt(e.target.dataset.paso);
      mostrarSeccion();
      botonesPaginador();
    });
  });
}

function botonesPaginador() {
  const paginaSiguiente = document.querySelector('#siguiente');
  const paginaAnterior = document.querySelector('#anterior');

  if (paso === 1) {
    paginaAnterior.classList.add('ocultar');
    paginaSiguiente.classList.remove('ocultar');
  } else if (paso === 3) {
    paginaAnterior.classList.remove('ocultar');
    paginaSiguiente.classList.add('ocultar');
  } else {
    paginaAnterior.classList.remove('ocultar');
    paginaSiguiente.classList.remove('ocultar');
  }

  mostrarSeccion();
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector('#anterior');
  paginaAnterior.addEventListener('click', function () {
    if (paso <= pasoInicial) return;
    paso--;
    botonesPaginador();
  });
}

function paginaSiguiente() {
  const paginaSiguiente = document.querySelector('#siguiente');
  paginaSiguiente.addEventListener('click', function () {
    if (paso >= pasoFinal) return;
    paso++;
    botonesPaginador();
  });
}
