import ViewEvent from './ViewEvent'

export default class ViewEventTargetAction extends ViewEvent {
  targetElement: HTMLElement

  async trigger (event: Event) {
    event.stopImmediatePropagation()
    this.targetElement = event.target as HTMLElement
    const response = await this.getResponse()
    this.getElementHelper().replaceClosest(response.document.documentElement, this.selector)
    this.injectDependencies(response)
  }

  protected getRequestInit (): RequestInit {
    const init = super.getRequestInit()
    if (init.method === 'POST') {
      const formData = new FormData()
      ViewEventTargetAction.findFormData(this.element, formData)
      ViewEventTargetAction.findFormData(this.targetElement, formData)
      init.body = formData
    }
    return init
  }

  private static findFormData (element: HTMLElement, formData: FormData) {
    if (element instanceof HTMLInputElement
      || element instanceof HTMLButtonElement
      || element instanceof HTMLSelectElement
    ) {
      if (element.type == 'checkbox' && 'checked' in element) {
        formData.set(element.name, element.checked ? '1' : '0')
      } else {
        formData.set(element.name, element.value)
      }
    } else if (element.isContentEditable && undefined !== element.dataset.name) {
      formData.set(element.dataset.name, element.innerHTML.trim())
    }
  }
}
