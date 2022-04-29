import ViewHelper from './ViewHelper'
import ViewElementInterface from './ViewElementInterface'

export default class ViewDivElement extends HTMLDivElement implements ViewElementInterface {
   helper: ViewHelper;
  constructor () {
    super()
    this.helper = new ViewHelper(this)
  }
}