import './OverviewComponent.scss'
import ViewComponent from '../ViewComponent'

class OverviewElement extends HTMLDivElement {
  protected component: ViewComponent

  constructor () {
    super()
    this.component = new ViewComponent(this)
  }
}

customElements.define('core-overview', OverviewElement, { extends: 'div' })
