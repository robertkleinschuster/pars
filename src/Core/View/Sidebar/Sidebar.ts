import './Sidebar.scss'
import ViewComponent from '../ViewComponent'

class SidebarElement extends HTMLDivElement {
  protected component: ViewComponent

  constructor () {
    super()
    this.component = new ViewComponent(this)
  }
}

customElements.define('core-sidebar', SidebarElement, { extends: 'div' })
