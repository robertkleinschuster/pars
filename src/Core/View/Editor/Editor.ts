import './Editor.scss'
import ViewComponent from '../ViewComponent'
import WebComponent from '../WebComponent'

class Editor extends ViewComponent {
  protected content: HTMLDivElement

  protected init () {
    super.init()
    this.content = this.element.querySelector('.content') as HTMLDivElement
    this.content.addEventListener('blur', this.onBlur.bind(this))
  }

  protected async onBlur () {
    await fetch(window.location.href, {
      method: 'PUT',
      body: this.content.innerHTML.trim()
    })
  }
}

WebComponent.define(Editor, 'div')
