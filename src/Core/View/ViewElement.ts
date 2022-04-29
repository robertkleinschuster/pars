import ViewHelper from './ViewHelper'
import ViewElementInterface from './ViewElementInterface'

export default class ViewElement extends HTMLElement implements ViewElementInterface {
  helper: ViewHelper

  constructor () {
    super()
    this.helper = new ViewHelper(this)
  }
}