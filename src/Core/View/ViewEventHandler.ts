import ViewEvent from './ViewEvent'
import ViewComponent from './ViewComponent'
type RequestInit = globalThis.RequestInit

export default class ViewEventHandler {
  protected component: ViewComponent

  constructor (component: ViewComponent) {
    this.component = component
  }

  public init (): void {
    this.component.element.querySelectorAll('[data-event]').forEach(this.initEvent.bind(this))
    if (this.component.element.closest('.winbox') != null) {
      this.component.element.addEventListener('click', event => {
        const link = (event.target as HTMLAnchorElement).closest('a')
        if (link != null) {
          event.preventDefault()
        }
      })
    }
  }

  protected initEvent (element: HTMLElement): void {
    const viewEvent = new ViewEvent(element.dataset)
    element.addEventListener(viewEvent.event, event => {
      event.preventDefault()
      event.stopImmediatePropagation()
      this.trigger(viewEvent, element)
    })
  }

  public trigger (viewEvent: ViewEvent, eventTarget: HTMLElement|null = null): void {
    const url = new URL(viewEvent.url, document.baseURI)
    const options: RequestInit = {}

    options.headers = new Headers()
    options.headers.set('inject', 'true')

    if (viewEvent.target !== '') {
      options.headers.set('target', viewEvent.target)
    }

    if (viewEvent.title !== '') {
      options.headers.set('title', encodeURIComponent(viewEvent.title))
    }

    if (viewEvent.url !== '') {
      options.headers.set('url', viewEvent.url)
    }

    if (viewEvent.target === 'action') {
      options.method = 'post'
    }

    if (eventTarget !== null) {
      const form = eventTarget.closest('form')

      if (form !== null) {
        options.method = form.method ?? 'post'
        options.body = new FormData(form)
        if (eventTarget instanceof HTMLInputElement || eventTarget instanceof HTMLSelectElement || eventTarget instanceof HTMLTextAreaElement || eventTarget instanceof HTMLButtonElement) {
          options.body.append(eventTarget.name, eventTarget.value)
        }
      }
    }

    this.fetch(viewEvent, url, options)
  }

  protected fetch (viewEvent: ViewEvent, url: URL, options: RequestInit): void {
    this.showOverlay()
    options.redirect = 'manual'
    fetch(url.toString(), options)
      .then(response => {
        if (response.type === 'opaqueredirect' && viewEvent.target !== 'blank') {
          this.redirect(viewEvent.url)
        }
        if (response.status === 500) {
          this.redirect(url)
        } else {
          this.injectJs(response)
          this.injectCss(response)
        }
        return response
      })
      .then(async r => await r.text())
      .then(html => {
        this.hideOverlay()
        this.component.handleViewEvent(viewEvent, html)
      }).catch((e) => {
        console.error(e)
        this.redirect(url)
      })
  }

  protected showOverlay (): void {
    document.body.classList.add('overlay')
  }

  protected hideOverlay (): void {
    document.body.classList.remove('overlay')
  }

  protected redirect (url: string | URL): void {
    if (url instanceof URL) {
      url = url.toString()
    }
    window.location.href = url
  }

  private injectJs (response: Response): void {
    const jsFiles = response.headers.get('inject-js')

    if (jsFiles != null) {
      const jsFilesList = jsFiles.split(', ')

      jsFilesList.forEach(file => {
        if (document.body.querySelector(`script[src='${file}']`) == null) {
          const script = document.createElement('script')
          script.src = file
          document.body.append(script)
        }
      })
    }
  }

  private injectCss (response: Response): void {
    const cssFiles = response.headers.get('inject-css')
    if (cssFiles != null) {
      const cssFilesList = cssFiles.split(', ')
      cssFilesList.forEach(file => {
        if (document.head.querySelector(`link[href='${file}']`) == null) {
          const link = document.createElement('link')
          link.rel = 'stylesheet'
          link.href = file
          document.head.append(link)
        }
      })
    }
  }
}
