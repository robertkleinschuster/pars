import ViewEvent from './ViewEvent'

export default class ViewEventTargetAction extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation();
    const response = await this.getResponse()
    this.getElementHelper().replaceClosest(response.document.documentElement, this.selector);
  }
}