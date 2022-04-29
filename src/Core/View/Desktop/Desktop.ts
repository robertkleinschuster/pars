import './Desktop.scss'
import ViewDivElement from '../ViewDivElement'

class Desktop extends ViewDivElement {
  
  constructor () {
    super()
    this.addEventListener('click', () => {
      this.helper.trigger('desktop click')

    })
  }
}

customElements.define('core-desktop', Desktop, { extends: 'div' })