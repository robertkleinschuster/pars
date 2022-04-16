import ViewEvent from './ViewEvent'

export default class ViewEventTargetBlank extends ViewEvent {
  async trigger (event: Event) {
    event.stopImmediatePropagation();
    const newWindow = window.open(this.getUrl(), '_blank')
    if (newWindow) {
      newWindow.focus()
    }
  }
}