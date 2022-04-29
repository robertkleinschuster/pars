import './Editor.scss'
import ViewDivElement from '../ViewDivElement'

class Editor extends ViewDivElement {
  protected content: HTMLDivElement

  constructor () {
    super()
    this.init()
  }

  protected init () {
    this.content = this.querySelector('.content') as HTMLDivElement
    this.content.addEventListener('blur', this.onBlur.bind(this))
  }

  protected async onBlur () {
    await fetch(window.location.href, {
      method: 'PUT',
      body: this.content.innerHTML.trim()
    })
  }
}
customElements.define('core-editor', Editor, { extends: 'div' })
