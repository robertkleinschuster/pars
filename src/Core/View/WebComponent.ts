import '@ungap/custom-elements';
import ViewComponent from './ViewComponent'

export default class {
  public static define (component: typeof ViewComponent, extend: string | null = null) {
    if (extend != null) {
      this.defineExtended(component, extend)
    } else {
      const name = component.name.toLowerCase()
      window.customElements.define(`core-${name}`, class extends HTMLElement {
        constructor () {
          super()
          new component(this)
        }
      })
    }
  }

  public static defineExtended (component: typeof ViewComponent, extend: string) {
    const name = component.name.toLowerCase()
    const extendClass = this.findExtendClass(extend);

    window.customElements.define(`core-${name}`, class extends extendClass implements ComponentElement {
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
    }, { extends: extend })
  }

  private static findExtendClass(tag: string): typeof HTMLElement {
    switch (tag) {
      case 'div':
        return HTMLDivElement;
      case 'html':
        return HTMLHtmlElement;
      case 'ul':
        return HTMLUListElement;
      case 'form':
        return HTMLFormElement
      case 'iframe':
        return HTMLIFrameElement
      case 'input':
        return HTMLInputElement
      case 'button':
        return HTMLButtonElement
      default:
        return HTMLElement
    }
  }
}

export interface ComponentElement extends HTMLElement {
  get component (): ViewComponent;
  set component (value: ViewComponent);
}
