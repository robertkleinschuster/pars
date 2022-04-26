import ViewEvent from './ViewEvent'
import ViewWindow from './ViewWindow'

export default class ViewEventTargetWindow extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation()
    if (window.self === window.top) {
      ViewWindow.open(this, window.top)
    }
  }
}