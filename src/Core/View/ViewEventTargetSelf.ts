import ViewEvent from './ViewEvent'

export default class ViewEventTargetSelf extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation()
    const response = await this.getResponse()
    this.element.dispatchEvent(new CustomEvent('state', {
      detail: this.getState(),
      bubbles: true
    }))
    this.getElementHelper().replaceClosest(response.document.documentElement, this.selector)
  }
}
