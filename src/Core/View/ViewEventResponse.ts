import ElementHelper from './ElementHelper'

export default class ViewEventResponse {
  private _document: Document
  public headers: Headers
  public text: string;
  public status: number
  public redirect: boolean

  constructor () {
    this._document = document;
    this.headers = new Headers();
    this.status = 200;
    this.redirect = false;
  }

  public static async create (response: Response): Promise<ViewEventResponse> {
    const viewResponse = new this
    viewResponse.headers = response.headers
    viewResponse.status = response.status
    viewResponse.redirect = response.status === 500 || response.type === 'opaqueredirect'
    viewResponse.text = await response.text();

    return viewResponse
  }

  get document (): Document {
    if (null !== this.text && document === this._document) {
      this._document = (new DOMParser()).parseFromString(this.text, 'text/html')
    }
    return this._document
  }

  public getDocumentHelper(): ElementHelper
  {
    return new ElementHelper(this._document.documentElement);
  }
}