import 'winbox'
import 'winbox/dist/css/themes/modern.min.css'
import ViewEvent from './ViewEvent'

export default class ViewWindow extends window.WinBox {

  constructor (url: string) {
    super({
      title: 'window', url: url, x: 'center', y: 'center', class: 'modern',
    })
    const iframe = this.body.querySelector('iframe') as HTMLIFrameElement
    iframe.onload = this.onLoad.bind(this, iframe.contentWindow)
  }

  protected onLoad (window: WindowProxy) {
    this.setTitle(window.document.title ?? this.title)
  }

  public static open (viewEvent: ViewEvent) {
    const viewWindow = new ViewWindow(viewEvent.getUrl().toString())
    viewWindow.onclose = (): boolean => {
      viewEvent.element.ownerDocument.documentElement.dispatchEvent(new CustomEvent('reload'))
      return false
    }
    return viewWindow
  }
}
