import ViewEventHandler from './ViewEventHandler'
import ViewWindow from './ViewWindow'
import ViewEvent from './ViewEvent'

export default class ViewComponent {
  public element: HTMLElement
  public eventHandler: ViewEventHandler

  constructor (element: HTMLElement) {
    this.element = element
    this.eventHandler = new ViewEventHandler(this)
    this.init()
  }

  protected init (): void {
    this.eventHandler.init()
  }

  public handleViewEvent (viewEvent: ViewEvent, responseHtml: string): void {
    this.handleResponse(viewEvent, responseHtml)
  }

  protected handleResponse (viewEvent: ViewEvent, html: string): void {
    switch (viewEvent.target) {
      case ViewEvent.TARGET_BLANK:
        this.handleTargetBlank(viewEvent)
        break
      case ViewEvent.TARGET_SELF:
        this.handleTargetSelf(viewEvent, html)
        break
      case ViewEvent.TARGET_ACTION:
        this.handleTargetAction(viewEvent, html)
        break
      case ViewEvent.TARGET_WINDOW:
        this.handleTargetWindow(viewEvent, html)
        break
    }
  }

  protected handleTargetBlank (viewEvent: ViewEvent): void {
    const newWindow = window.open(viewEvent.url, '_blank')
    if (newWindow != null) {
      newWindow.focus()
    }
  }

  protected handleTargetAction (viewEvent: ViewEvent, html: string): void {
    const winbox = this.element.closest('.winbox')
    const parser = new DOMParser()
    const dom = parser.parseFromString(html, 'text/html')
    const main = this.element.closest('main')
    const newMain = dom.body.querySelector('main')
    if ((main != null) && (newMain != null)) {
      main.replaceWith(newMain)
    }
    if (winbox != null) {
      const winboxTitle = winbox.querySelector('.wb-title')
      if (winboxTitle != null) {
        (winboxTitle as HTMLElement).innerText = dom.title
      }
    } else {
      document.title = dom.title
    }
  }

  protected handleTargetWindow (viewEvent: ViewEvent, html: string): void {
    const parser = new DOMParser()
    const dom = parser.parseFromString(html, 'text/html')
    const main = dom.querySelector('main')
    if (main != null) {
      const viewWindow = new ViewWindow(viewEvent, main)
      viewWindow.setTitle(dom.title)
    }
  }

  protected handleTargetSelf (viewEvent: ViewEvent, html: string): void {
    if (this.element.closest('.winbox') == null) {
      history.replaceState({}, '', viewEvent.url)
    }
    this.handleTargetAction(viewEvent, html)
  }
}
