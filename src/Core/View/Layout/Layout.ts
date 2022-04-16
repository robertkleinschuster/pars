import './Layout.scss'
import ViewComponent from '../ViewComponent'
import WebComponent from '../WebComponent'
import ViewEvent from '../ViewEvent'
import ViewState from '../ViewState'
import ViewEventTargetState from '../ViewEventTargetState'
import ViewWindow from '../ViewWindow'

export default class Layout extends ViewComponent {

  protected init () {
    super.init()
    this.initHistory()
    this.initWindow()
  }

  protected initWindow () {
    this.element.addEventListener('window',
      (event: CustomEvent) => {
        const viewEvent = event.detail as ViewEvent
        ViewWindow.open(viewEvent)
      }
    )
    this.element.addEventListener('reload', async (event: CustomEvent) => {
      await this.loadState(history.state, event);
    })
  }

  protected initHistory () {
    const viewState = new ViewState()
    viewState.url = window.location.href
    viewState.target = ViewEvent.TARGET_SELF
    viewState.selector = 'main'
    history.replaceState(viewState, '', viewState.url)

    this.element.addEventListener('state', (event: CustomEvent) => {
      const viewState = event.detail as ViewState
      history.pushState(viewState, '', viewState.url)
    })

    window.onpopstate = async event => {
      const viewState = event.state as ViewState
        await this.loadState(viewState, event);
    }
  }

  protected async loadState(viewState: ViewState, event: Event)
  {
    const element = this.element.querySelector(viewState.selector) as HTMLElement
    if (null !== element) {
      const viewEvent = new ViewEventTargetState(element)
      viewEvent.url = viewState.url
      viewEvent.target = viewState.target
      viewEvent.selector = viewState.selector
      await viewEvent.trigger(event)
    }
  }
}

WebComponent.define(Layout, HTMLHtmlElement)