function App() {}

window.onload = function (event) {
  var app = new App()
  window.app = app
}

const btnToggle = document.querySelector('.btn-toggle')

btnToggle.addEventListener('click', function () {
  document.getElementById('aside').classList.toggle('activo')
  //console.log(document.getElementById('aside'))
  //document.body.style.overflow = 'auto'
})
const liToggle = document.querySelector('.menu')

liToggle.addEventListener('click', function () {
  document.getElementById('aside').classList.toggle('activo')
})
