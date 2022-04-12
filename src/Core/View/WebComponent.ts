import ViewComponent from './ViewComponent'

export default class {
  public static define (component: typeof ViewComponent, extend: typeof HTMLElement | null = null) {
    if (extend != null) {
      this.defineExtended(component, extend)
    } else {
      const name = component.name.toLowerCase()
      customElements.define(`core-${name}`, class extends HTMLElement {
        constructor () {
          super()
          new component(this)
        }
      })
    }
  }

  public static defineExtended (component: typeof ViewComponent, extend: typeof HTMLElement) {
    const name = component.name.toLowerCase()
    let tag = extend.name
      .replace('HTML', '')
      .replace('Element', '')
      .toLowerCase()
    if (extend === HTMLUListElement) {
      tag = 'ul'
    }
    customElements.define(`core-${name}`, class extends extend implements ComponentElement {
      private _component: ViewComponent
      constructor () {
        super()
        this._component = new component(this)
      }

      get component (): ViewComponent {
        return this._component
      }

      set component (value: ViewComponent) {
        this._component = value
      }
    }, { extends: tag })
  }
}

export interface ComponentElement extends HTMLElement {
  get component (): ViewComponent;
  set component (value: ViewComponent);
}
