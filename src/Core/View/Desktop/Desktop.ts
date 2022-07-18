import './Desktop.scss'
import ViewDivElement from '../ViewDivElement'

class Desktop extends ViewDivElement {
  
  constructor () {
    super()
    this.addEventListener('click', () => {

    })
  }
}

customElements.define('core-desktop', Desktop, { extends: 'div' })