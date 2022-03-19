import { WinBoxConstructor } from 'winbox'
import 'winbox/dist/css/themes/modern.min.css'
import ViewEvent from './ViewEvent'

declare const WinBox: WinBoxConstructor

export default class ViewWindow extends WinBox {
  protected viewEvent: ViewEvent

  constructor (viewEvent: ViewEvent, body: HTMLElement) {
    super({
      title: viewEvent.title, mount: body, x: 'center', y: 'center', class: 'modern'
    })
    this.viewEvent = new ViewEvent(viewEvent)
    this.viewEvent.target = 'self'
  }
}
