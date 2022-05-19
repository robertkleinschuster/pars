import ElementScrollState from './ElementScrollState'

export default class ElementHelper {
  public element: Element

  constructor (element: Element) {
    this.element = element
  }

  public replaceClosest (element: Element, selector: string) {
    const newElement = element.querySelector(selector)
    const elementToReplace = this.element.closest(selector)
    if (null !== newElement && null !== elementToReplace) {
      const scrollState = this.getScrollState(this.getScrollParent(elementToReplace))

      elementToReplace.replaceWith(newElement)

      this.restoreScrollState(this.getScrollParent(newElement), scrollState)
    }
  }

  public getScrollState (scrollElement: Element | null): ElementScrollState {
    const state = new ElementScrollState()
    if (scrollElement) {
      state.scrollTop = scrollElement.scrollTop ?? state.scrollTop
      state.scrollLeft = scrollElement.scrollLeft ?? state.scrollLeft
    }
    return state
  }

  public restoreScrollState (scrollElement: Element | null, state: ElementScrollState) {
    if (scrollElement) {
      scrollElement.scrollTo(state.scrollLeft, state.scrollTop)
    }
  }

  public getScrollParent (node) {
    if (node == null) {
      return null
    }

    if (node.scrollHeight > node.clientHeight) {
      return node
    } else {
      return this.getScrollParent(node.parentNode)
    }
  }
}