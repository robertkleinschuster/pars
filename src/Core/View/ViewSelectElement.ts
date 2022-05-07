import ViewHelper from './ViewHelper'

export default class ViewSelectElement extends HTMLSelectElement {
  helper: ViewHelper

  constructor () {
    super()
    this.helper = new ViewHelper(this)
  }
}