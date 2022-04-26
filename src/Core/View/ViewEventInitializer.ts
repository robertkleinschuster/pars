import ViewComponent from './ViewComponent'
import ViewEventFactory from './ViewEventFactory'

export default class ViewEventInitializer {
  protected component: ViewComponent

  constructor (component: ViewComponent) {
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
