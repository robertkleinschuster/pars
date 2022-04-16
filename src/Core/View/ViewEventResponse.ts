import ElementHelper from './ElementHelper'

export default class ViewEventResponse {
  public document: Document
  public headers: Headers
  public status: number
  public redirect: boolean

  constructor () {
    this.document = document;
    this.headers = new Headers();
    this.status = 200;
    this.redirect = false;
  }

  public static async create (response: Response): Promise<ViewEventResponse> {
    const viewResponse = new this
    viewResponse.headers = response.headers
    viewResponse.status = response.status
    viewResponse.redirect = response.status === 500 || response.type === 'opaqueredirect'
    viewResponse.document = (new DOMParser()).parseFromString(await response.text(), 'text/html')

    viewResponse.document.querySelectorAll('link.css').forEach((link: HTMLLinkElement) => {
      if (document.querySelector(`link.css[href='${link.getAttribute('href')}']`) == null) {
        document.head.append(link)
      }
    })

    viewResponse.document.querySelectorAll('script.script').forEach((script: HTMLScriptElement) => {
      if (document.querySelector(`script.script[src='${script.getAttribute('src')}']`) == null) {
        document.body.append(script)
      }
    })

    return viewResponse
  }

  public getDocumentHelper(): ElementHelper
  {
    return new ElementHelper(this.document.documentElement);
  }
}