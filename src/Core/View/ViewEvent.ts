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
  public title = ''
  public method = 'GET'

  constructor (element: HTMLElement) {
    this.element = element

    for (const key in element.dataset) {
      this[key] = element.dataset[key]
    }
  }

  public bind () {
    this.element.addEventListener(this.event, this.trigger.bind(this))
  }

  public abstract trigger (event: Event);

  public getState (): ViewState {
    return ViewState.createByEvent(this)
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
    const init: RequestInit = {}
    init.method = this.method

    return new Request(this.getUrl().toString(), init)
  }

  public async getResponse (): Promise<ViewEventResponse> {
    return await ViewEventResponse.create(await fetch(this.getRequest()))
  }

  public getElementHelper () {
    return new ElementHelper(this.element)
  }
}
