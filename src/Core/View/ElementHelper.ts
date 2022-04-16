export default class ElementHelper {
  public element: Element

  constructor (element: Element) {
    this.element = element
  }

  public replaceClosest (element: Element, selector: string) {
    const newElement = element.querySelector(selector)
    const elementToReplace = this.element.closest(selector)
    if (null !== newElement && null !== elementToReplace) {
      elementToReplace.replaceWith(newElement)
    }
  }
}