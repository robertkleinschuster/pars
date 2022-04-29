import ViewHelper from './ViewHelper'
import ViewElementInterface from './ViewElementInterface'

export default class ViewHtmlElement extends HTMLHtmlElement implements ViewElementInterface {
  helper: ViewHelper

  constructor () {
    super()
    this.helper = new ViewHelper(this)
  }
}