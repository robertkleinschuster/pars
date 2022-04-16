import ViewEvent from './ViewEvent'

export default class ViewEventTargetWindow extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation();
    const window = global.window.top;
    if (window) {
      window.document.documentElement.dispatchEvent(new CustomEvent('window', {
        detail: this,
        bubbles: true
      }))
    }
  }
}