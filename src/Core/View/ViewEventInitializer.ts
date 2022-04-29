import ViewHelper from './ViewHelper'
import ViewEventFactory from './ViewEventFactory'

export default class ViewEventInitializer {
  protected component: ViewHelper

  constructor (component: ViewHelper) {
    this.component = component
  }

  public init (): void {
    this.component.element.querySelectorAll('[data-event]').forEach(this.initEvent.bind(this))
  }

  protected initEvent (element: HTMLElement): void {
    this.createViewEvent(element).bind()
  }

  protected createViewEvent (element: HTMLElement) {
    return ViewEventFactory.create(element)
  }
}
