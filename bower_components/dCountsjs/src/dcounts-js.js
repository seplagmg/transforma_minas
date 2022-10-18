(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define('dCounts', factory)
  } else if (typeof exports === 'object' && module.exports) {
    module.exports = factory
  } else {
    root.dCounts = factory
  }
}(this, function dCounts(selector, limit=150) {
  if (typeof selector !== 'string' && typeof limit !== 'number') {
    return
  }
  const el = document.getElementById(selector)

  const div = `<div id="counters-${selector}" class="text-right">0 de ${limit} caracteres</div>`

  const init = () => {
    if (el === null) {
      throw new Error(`Algo está errado com o seu seletor`)
    }
    createDiv()
    el.addEventListener('keyup', counters, false)
  }

  const createDiv = () => el.insertAdjacentHTML('afterend', div)

  const counters = () => {
    let total = limit
    let typedCharacters = el.value.length
    let count = document.getElementById(`counters-${selector}`)
    count.innerHTML = `${typedCharacters} de ${total} caracteres`

    if (typedCharacters >= total) {
      el.focus()
      el.value = el.value.substring(0, total)
      count.innerHTML = `Você atingiu o máximo de caracteres`
      count.classList.add("badge")
      count.classList.add("bg-danger")
      count.classList.add("mt-2")
      count.classList.add("text-white")
      count.classList.add("float-right")
    }
  }
  init()
}))
