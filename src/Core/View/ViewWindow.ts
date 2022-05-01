import 'winbox'
import 'winbox/dist/css/themes/modern.min.css'
import ViewEvent from './ViewEvent'
import ViewMessage from './ViewMessage'
import ViewState from './ViewState'

export default class ViewWindow extends window.WinBox {
  private viewEvent: ViewEvent

  private parentWindow: WindowProxy
  private contentWindow: WindowProxy

  constructor (viewEvent: ViewEvent, parent: WindowProxy) {
    super({
      title: 'window', x: 'center', y: 'center', class: 'modern',
    })
    this.viewEvent = viewEvent
    this.parentWindow = parent
    this.load()
  }

  onclose = (): boolean => {
    const popStateEvent = new PopStateEvent('popstate', {
      state: this.parentWindow.history.state
    })
    this.parentWindow.dispatchEvent(popStateEvent)
    return false
  }

  private async load () {
    const response = await this.viewEvent.getResponse()
    const objectElement = document.createElement('object')
    objectElement.type = 'text/html'
    objectElement.data = 'about:blank'

    objectElement.style.width = '100%'

    this.body.replaceChildren(objectElement)

    if (objectElement.contentWindow) {
      this.contentWindow = objectElement.contentWindow
    }

    if (objectElement.contentDocument) {
      objectElement.contentDocument.write(response.text)
      objectElement.contentDocument.close()
    }

    this.onload()
  }

  private onload () {
    if (null === this.contentWindow) {
      return
    }
    ViewState.replace(this.viewEvent.getState(), this.contentWindow)
    this.setTitle(this.contentWindow.document.title ?? this.title)
    this.contentWindow.addEventListener(ViewEvent.name, async (event: CustomEvent) => {
      const viewEvent = event.detail as ViewEvent
      if (viewEvent.target === ViewEvent.TARGET_WINDOW) {
        ViewWindow.open(viewEvent, this.contentWindow)
      }
    })
    this.contentWindow.addEventListener(ViewMessage.name, (event: CustomEvent) => {
      this.viewEvent.element.dispatchEvent(new CustomEvent(ViewMessage.name, {
        detail: event.detail,
        bubbles: true
      }))
    })
  }

  public static open (viewEvent: ViewEvent, parentWindow: WindowProxy) {
    return new ViewWindow(viewEvent, parentWindow)
  }
}
