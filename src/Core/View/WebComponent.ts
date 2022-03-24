import ViewComponent from './ViewComponent'

export default class {
  public static define (component: typeof ViewComponent, extend: typeof HTMLElement | null = null) {
    if (extend) {
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
    customElements.define(`core-${name}`, class extends extend {
      constructor () {
        super()
        new component(this)
      }
    }, { extends: tag })
  }
}