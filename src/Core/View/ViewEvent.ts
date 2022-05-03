import './ViewEvent.scss'
import ViewEventResponse from './ViewEventResponse'
import ElementHelper from './ElementHelper'
import ViewState from './ViewState'

export default abstract class ViewEvent {
  public static readonly TARGET_SELF = 'self'
  public static readonly TARGET_ACTION = 'action'
  public static readonly TARGET_BLANK = 'blank'
  public static readonly TARGET_WINDOW = 'window'

  public element: HTMLElement

  public event: string
  public target: string
  public selector = 'main'
  public url: string
  public method = 'GET'
  public title = ''

  constructor (element: HTMLElement) {
    this.element = element

    for (const key in element.dataset) {
      this[key] = element.dataset[key]
    }
  }

  public bind () {
    this.element.addEventListener(this.event, event => {
      event.stopImmediatePropagation()
      this.dispatchEvent(true)
      this.trigger(event)
    })
  }

  public abstract trigger (event: Event);

  public getState (): ViewState {
    return ViewState.createByEvent(this)
  }

  public getEvent (bubbles = true): CustomEvent {
    return new CustomEvent(ViewEvent.name, {
      bubbles: bubbles,
      detail: this
    })
  }

  public dispatchEvent (bubbles = true) {
    this.element.dispatchEvent(this.getEvent(bubbles))
  }

  public getUrl (): URL {
    const url = new URL(this.url, document.baseURI)

    this.getParams().forEach((value, name) => {
      url.searchParams.set(name, value)
    })

    return url
  }

  public getParams () {
    const params = new Map()

    for (const [key, value] of Object.entries(this)) {
      if (key.startsWith('param')) {
        params.set(key.substring('param'.length).toLowerCase(), value)
      }
    }
    return params
  }

  public getRequest () {

    return new Request(this.getUrl().toString(), this.getRequestInit())
  }

  protected getRequestInit () {
    const headers = new Headers()
    const init: RequestInit = {
      headers: headers
    }
    init.method = this.method
    return init
  }

  public async getResponse (): Promise<ViewEventResponse> {
    return await ViewEventResponse.create(await fetch(this.getRequest()))
  }

  public getElementHelper () {
    return new ElementHelper(this.element)
  }

  public injectDependencies (viewResponse: ViewEventResponse) {
    viewResponse.document.querySelectorAll('link.css').forEach((l: HTMLLinkElement) => {
      const href = l.getAttribute('href')
      if (null === href) {
        return
      }
      if (document.querySelector(`link.css[href='${href}']`) == null) {
        const link = document.createElement('link')
        link.rel = 'stylesheet'
        link.classList.add('css')
        link.href = href
        document.head.append(link)
      }
    })

    viewResponse.document.querySelectorAll('script.script').forEach((s: HTMLScriptElement) => {
      const src = s.getAttribute('src')
      if (null === src) {
        return
      }
      if (document.querySelector(`script.script[src='${src}']`) == null) {
        const script = document.createElement('script')
        script.classList.add('script')
        script.src = src
        document.body.append(script)
      }
    })
  }
}
