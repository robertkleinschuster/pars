import ViewHelper from './ViewHelper'
import ViewElementInterface from './ViewElementInterface'

export default class ViewSelectElement extends HTMLSelectElement implements ViewElementInterface {
  helper: ViewHelper

  constructor () {
    super()
    this.helper = new ViewHelper(this)
  }
}