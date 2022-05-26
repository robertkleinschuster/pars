import ViewHelper from './ViewHelper'
import ViewElementInterface from './ViewElementInterface'

export default class ViewButtonElement extends HTMLButtonElement implements ViewElementInterface {
  helper: ViewHelper

  constructor () {
    super()
    this.helper = new ViewHelper(this)
  }
}