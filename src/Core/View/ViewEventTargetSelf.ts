import ViewEvent from './ViewEvent'
import ViewState from './ViewState'

export default class ViewEventTargetSelf extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation()
    const response = await this.getResponse()
    this.getElementHelper().replaceClosest(response.document.documentElement, this.selector)
    ViewState.push(this.getState())
    document.title = response.document.title
    this.injectDependencies(response)
  }
}
