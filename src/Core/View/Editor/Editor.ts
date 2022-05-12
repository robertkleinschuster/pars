import './Editor.scss'
import ViewDivElement from '../ViewDivElement'

class Editor extends ViewDivElement {
  protected content: HTMLDivElement
  protected prevHtml: string | null

  constructor () {
    super()
    this.init()
  }

  protected init () {
    this.content = this.querySelector('.content') as HTMLDivElement
    this.content.addEventListener('blur', this.onBlur.bind(this))
    this.content.addEventListener('focus', this.onFocus.bind(this))
  }

  protected onFocus () {
    this.prevHtml = this.content.innerHTML
  }

  protected onBlur () {
    if (this.prevHtml != this.content.innerHTML) {
      const event = new Event('change')
      this.content.dispatchEvent(event)
    }
  }
}

customElements.define('core-editor', Editor, { extends: 'div' })
