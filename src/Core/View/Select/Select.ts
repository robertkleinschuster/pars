import './Select.scss'
import ViewSelectElement from '../ViewSelectElement'

export default class Select extends ViewSelectElement {

}

customElements.define('core-select', Select, { extends: 'select' })