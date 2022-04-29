import 'winbox'
import 'winbox/dist/css/themes/modern.min.css'
import ViewEvent from './ViewEvent'
import ViewMessage from './ViewMessage'

export default class ViewWindow extends window.WinBox {
  private viewEvent: ViewEvent

  constructor (viewEvent: ViewEvent, window: WindowProxy) {
    super({
      title: 'window', url: viewEvent.getUrl().toString(), x: 'center', y: 'center', class: 'modern',
    })
    this.viewEvent = viewEvent
    const iframe = this.body.querySelector('iframe') as HTMLIFrameElement
    iframe.onload = this.onLoad.bind(this, iframe.contentWindow)
    this.onclose = (): boolean => {
      const popStateEvent = new PopStateEvent('popstate', {
        state: window.history.state
      })
      window.dispatchEvent(popStateEvent)
      if (window.top) {
        window.top.dispatchEvent(popStateEvent)
      }
      return false
    }
  }

  protected onLoad (window: WindowProxy) {
    this.setTitle(window.document.title ?? this.title)
    window.addEventListener(ViewEvent.name, async (event: CustomEvent) => {
      const viewEvent = event.detail as ViewEvent
      if (viewEvent.target === ViewEvent.TARGET_WINDOW) {
        ViewWindow.open(viewEvent, window)
      }
    })
    window.addEventListener(ViewMessage.name, (event: CustomEvent) => {
      this.viewEvent.element.dispatchEvent(new CustomEvent(ViewMessage.name, {
        detail: event.detail,
        bubbles: true
      }))
    })
  }

  public static open (viewEvent: ViewEvent, window: WindowProxy) {
    return new ViewWindow(viewEvent, window)
  }
}
