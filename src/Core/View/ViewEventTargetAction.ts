import ViewEvent from './ViewEvent'

export default class ViewEventTargetAction extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation()
    const response = await this.getResponse()
    this.getElementHelper().replaceClosest(response.document.documentElement, this.selector)
    this.injectDependencies(response)
  }

  protected getRequestInit (): RequestInit {
    const init = super.getRequestInit()
    if (init.method === 'POST') {
      const formData = new FormData()
      if (this.element instanceof HTMLInputElement || this.element instanceof HTMLSelectElement) {
        if (this.element.type == 'checkbox' && 'checked' in this.element) {
            formData.set(this.element.name, this.element.checked ? '1' : '0')
        } else {
          formData.set(this.element.name, this.element.value)
        }
      } else if (this.element.isContentEditable && undefined !== this.element.dataset.name) {
        formData.set(this.element.dataset.name, this.element.innerHTML.trim())
      }
      init.body = formData
    }
    return init
  }
}