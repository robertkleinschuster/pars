import './Editor.scss'
import ViewDivElement from '../ViewDivElement'

class Editor extends ViewDivElement {
  protected content: HTMLDivElement
  protected prevHtml: string | null
  protected selectedRange: Range | null

  constructor () {
    super()
    this.init()
  }

  protected init () {
    this.content = this.querySelector('.editor__content') as HTMLDivElement
    this.content.addEventListener('blur', this.onBlur.bind(this))
    this.content.addEventListener('focus', this.onFocus.bind(this))
    this.attachSelectionListener()
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

  attachSelectionListener (): void {
    this.content.onselectstart = () => this.handleSelectionChange()
  }

  handleSelectionChange (): void {
    this.content.onmouseup = () => this.retrieveSelection()
    this.content.onkeyup = () => this.retrieveSelection()
  }

  retrieveSelection (): void {
    const selection = document.getSelection()

    // Ignore empty selection
    if (!selection || (selection.toString() === '')) {
      this.selectedRange = null
      return
    }

    if (selection.rangeCount !== 0) {
      this.selectedRange = selection.getRangeAt(0)
    }
  }

}

customElements.define('core-editor', Editor, { extends: 'div' })
