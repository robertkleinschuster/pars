import './Sidebar.scss'
import ViewDivElement from '../ViewDivElement'

class SidebarElement extends ViewDivElement {

}

customElements.define('core-sidebar', SidebarElement, { extends: 'div' })
