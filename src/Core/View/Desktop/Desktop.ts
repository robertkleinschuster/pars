import './Desktop.scss'
import ViewComponent from '../ViewComponent'
import WebComponent from '../WebComponent'

class Desktop extends ViewComponent {

  protected init () {
    super.init();
  }
}

WebComponent.define(Desktop, 'div')