import ViewEvent from './ViewEvent'
import ViewComponent from './ViewComponent'
import ViewEventTargetBlank from './ViewEventTargetBlank'
import ViewEventTargetSelf from './ViewEventTargetSelf'
import ViewEventTargetAction from './ViewEventTargetAction'
import ViewEventTargetWindow from './ViewEventTargetWindow'

export default class ViewEventInitializer {
  protected component: ViewComponent

  constructor (component: ViewComponent) {
    this.component = component
  }

  public init (): void {
    this.component.element.querySelectorAll('[data-event]').forEach(this.initEvent.bind(this))
  }

  protected initEvent (element: HTMLElement): void {
    this.createViewEvent(element).bind();
  }

  protected createViewEvent(element: HTMLElement)
  {
    switch (element.dataset.target) {
      case ViewEvent.TARGET_BLANK:
        return new ViewEventTargetBlank(element)
      case ViewEvent.TARGET_SELF:
        return new ViewEventTargetSelf(element)
      case ViewEvent.TARGET_ACTION:
        return new ViewEventTargetAction(element)
      case ViewEvent.TARGET_WINDOW:
        return new ViewEventTargetWindow(element)
    }
    throw 'Missing event target!';
  }
}
