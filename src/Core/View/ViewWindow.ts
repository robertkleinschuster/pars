import 'winbox'
import 'winbox/dist/css/themes/modern.min.css'
import ViewEvent from './ViewEvent'

export default class ViewWindow extends window.WinBox {

  constructor (url: string, window: WindowProxy) {
    super({
      title: 'window', url: url, x: 'center', y: 'center', class: 'modern',
    })
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
    window.addEventListener('viewEvent', async (event: CustomEvent) => {
      const viewEvent = event.detail as ViewEvent
      if (viewEvent.target === ViewEvent.TARGET_WINDOW) {
        ViewWindow.open(viewEvent, window)
      }
    })
  }

  public static open (viewEvent: ViewEvent, window: WindowProxy) {
    return new ViewWindow(viewEvent.getUrl().toString(), window)
  }
}
