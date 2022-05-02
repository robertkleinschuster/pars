import ViewEvent from './ViewEvent'

export default class ViewEventTargetAction extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation()
    const response = await this.getResponse()
    this.getElementHelper().replaceClosest(response.document.documentElement, this.selector)
    this.injectDependencies(response)
  }

  protected getRequestInit (): RequestInit {
    const init = super.getRequestInit();
    if (init.method === 'POST') {
      const formData = new FormData()
      if (this.element instanceof HTMLInputElement) {
        formData.set(this.element.name, this.element.value)
      }
      init.body = formData
    }
    return init;
  }
}