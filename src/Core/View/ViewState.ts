import ViewEvent from './ViewEvent'
import ViewEventFactory from './ViewEventFactory'

export default class ViewState {
  public url: string
  public target: string
  public selector: string

  constructor () {
    this.url = window.location.href
    this.target = ViewEvent.TARGET_SELF
    this.selector = 'main'
  }

  public static createByEvent (viewEvent: ViewEvent) {
    const state = new this
    state.url = viewEvent.getUrl().toString()
    state.target = viewEvent.target
    state.selector = viewEvent.selector

    return state
  }

  public static async pop (event: PopStateEvent) {
    const viewState = event.state as ViewState
    const element = document.querySelector(viewState.selector) as HTMLElement
    if (null !== element) {
      await ViewEventFactory.createState(viewState, element).trigger(event)
    }
  }

  public static replace (state: ViewState, window?: Window) {
    window = window ?? global.window.self
    window.history.replaceState(state, '', state.url)
  }

  public static push (state: ViewState) {
    const window = global.window.self
    if (window.self === window.top) {
      window.history.pushState(state, '', state.url)
    }
  }

  public static init () {
    const window = global.window.self
    window.onpopstate = this.pop
    this.replace(new this)
  }
}
window.addEventListener('DOMContentLoaded', ViewState.init.bind(ViewState))
